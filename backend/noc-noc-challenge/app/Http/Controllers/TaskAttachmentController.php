<?php
namespace App\Http\Controllers;

use App\Models\TaskAttachment;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Support\Str;

class TaskAttachmentController extends Controller
{
    public function create(Request $request, $id)
    {
        $task = Task::find($id);

        if (!$task) {
            return response()->json(['message' => 'Task not found'], 404);
        }

        $user = Auth::user();

        $uploadedFileUrl = Cloudinary::uploadFile($request->file('file')->getRealPath())->getSecurePath();

        $file = TaskAttachment::create([
            'task_id' => $task->id,
            'user_id' => $user->id,
            'filepath' => $uploadedFileUrl,
            'filename' => $request->file('file')->getClientOriginalName(),
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Comment created successfully',
            'comment' => $file,
        ]);
    }

    public function delete($id)
    {
        $file = TaskAttachment::find($id);

        if (!$file) {
            return response()->json(['message' => 'File not found'], 404);
        }

        $task = Task::find($file->task_id);

        $user = Auth::user();


        if($user->role !== 'superadmin' && $user-> id !== $file->user_id && $user-> id !== $task->assigned_to)
        {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $url = $file->filepath;

        $parts = explode('/', $url);
        $filename = end($parts);
        $id = pathinfo($filename, PATHINFO_FILENAME);

        Cloudinary::destroy($id);

        $file->delete();

        return response()->json(['message' => 'Task deleted succesfully']);
    }

}
