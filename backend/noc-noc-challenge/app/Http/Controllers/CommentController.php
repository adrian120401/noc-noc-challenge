<?php
namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function create(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'comment' => 'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $task = Task::find($id);

        if (!$task) {
            return response()->json(['message' => 'Task not found'], 404);
        }

        $user = Auth::user();

        $comment = Comment::create([
            'task_id' => $task->id,
            'comment' => $request->comment,
            'user_id' => $user->id,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Comment created successfully',
            'comment' => $comment,
        ]);

    }
}
