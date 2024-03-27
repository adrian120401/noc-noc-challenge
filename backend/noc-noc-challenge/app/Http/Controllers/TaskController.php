<?php
namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    public function getAll()
    {

        $user = Auth::user();

        $userTasks = Task::with('assignedUser')->where('assigned_to', $user->id)->get();

        $colleagueTasks = Task::with('assignedUser')->where('assigned_to', '!=', $user->id)->get();

        return response()->json([
            'user_tasks' => $userTasks,
            'colleague_tasks' => $colleagueTasks,
        ]);
    }
    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string',
            'description' => 'required|string',
            'assigned_to' => 'required|uuid',
            'status' => 'required|in:Pending,In progress,Blocked,Completed',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $user = Auth::user();

        if($user->role !== 'superadmin')
        {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $task = Task::create([
            'title' => $request->title,
            'description' => $request->description,
            'status' => $request->status,
            'assigned_to' => $request->assigned_to,
            'created_by' => $user->id
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Task created successfully',
            'task' => $task,
        ]);
    }

    public function delete($id)
    {

        $user = Auth::user();

        if($user->role !== 'superadmin')
        {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $task = Task::find($id);

        if (!$task) {
            return response()->json(['message' => 'Task not found'], 404);
        }

        $task->delete();

        return response()->json(['message' => 'Task deleted succesfully']);
    }

    public function updateUser(Request $request, $id)
    {
        $user = Auth::user();

        if($user->role !== 'superadmin')
        {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $task = Task::find($id);

        if (!$task) {
            return response()->json(['message' => 'Task not found'], 404);
        }

        $request->validate([
            'assigned_to' => 'required|uuid',
        ]);

        $task->assigned_to = $request->assigned_to;
        $task->save();

        return response()->json(['message' => 'Task updated successfully', 'task' => $task]);
    }

    public function updateStatus(Request $request, $id)
    {
        $task = Task::find($id);

        if (!$task) {
            return response()->json(['message' => 'Task not found'], 404);
        }

        $user = Auth::user();

        if($user->role !== 'superadmin' && $user->id !== $task->assigned_to)
        {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $request->validate([
            'status' => 'required|in:Pending,In progress,Blocked,Completed',
        ]);

        $task->status = $request->status;

        if ($request->status === 'Completed') {
            $task->completed_at = now();
        }

        $task->save();

        return response()->json(['message' => 'Task updated successfully', 'task' => $task]);
    }

    public function getReport(Request $request)
    {
        $dateStart= $request->input('date_start');
        $dateEnd= $request->input('date_end');
        $tasks = Task::with('assignedUser')->where('completed_at', '>=', $dateStart)->where('completed_at', '<=', $dateEnd)->get();
        return response()->json([
            'tasks' => $tasks,
        ]);
    }
}
