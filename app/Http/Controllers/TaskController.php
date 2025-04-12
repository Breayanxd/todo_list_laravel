<?php

namespace App\Http\Controllers;

#Import Task Model
use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {   
        $user_id = $request->query("user_id");
        if(!$user_id){
            return response()->json(['message'=>'user_id is required'],400);
        }
        $tasks = Task::where('user_id', $user_id)->get();
        return response()->json($tasks,200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate = $request->validate([
            'user_id' => 'required|exist:users, id',
            'title'=> 'required|string|max:255',
            'description'=>'nullable|string',
            'due_date'=> 'nullable|date',
            'status'=> 'in:pending,completed',
        ]);
        $task = Task::create($validate);
        return response()->json($task, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $task = Task::find($id);
        if(!$task){
            return response()->json(['message' => 'Task not found'], 404);
        }

        return response()->json($task,200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $task = Task::find($id);
        if(!$task){
            return response()->json(['message'=> 'Task not found'],404);
        }
        $validate = $request->validate([
            'title'=> 'required|string|max:255',
            'description'=>'nullable|string',
            'due_date'=> 'nullable|date',
            'status'=> 'in:pending,completed',
        ]);
        $task->update($validate);
        return response()->json($task,200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $task = Task::find($id);
        if(!$task){
            return response()->json(['message'=> 'Task not found'],404);
        }
        $task->delete();
        return response()->json('Task deleted successfully',200);
    }
}
