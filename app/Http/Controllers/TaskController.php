<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use App\Task;
use Auth;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(!Auth::user())return redirect('/');
        if (Auth::user()->position == 'manager')$tasks = Task::where('status', "=", "created")->orWhere('author_id', Auth::user()->id)->get();
        if (Auth::user()->position == 'developer'){
            $all_tasks = Task::all();
            $tasks = [];
            foreach ($all_tasks as $task){
                if(in_array(Auth::user()->id, json_decode($task->performers))){
                    $tasks[] = $task;
                }
            }
        }
        $developers = User::where('position', 'developer')->pluck('name', 'id');

        return view('index', compact('tasks', 'developers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(!Auth::user())return redirect('/');
        $developers = User::where('position', '=', 'developer')->pluck('name', 'id');
        return view('create', compact('developers'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $validatedData = $request->validate([
            'title' => 'required|max:255',
            'deadline' => 'required|date|after:today',
            'description' => 'required',
        ]);
        $validatedData['status'] = 'assigned';
        $validatedData['performers'] = json_encode($request->performers);
        $validatedData['author_id'] = Auth::user()->id;
        if(empty($request->performers)){
            $validatedData['status'] = 'created';
            $validatedData['performers'] = '[null]';
        }
        if($validatedData['deadline']){
            $date = strtotime($validatedData['deadline']);
            $validatedData['deadline'] = date("Y-m-d H:i:s", $date);
        }
        $task = Task::create($validatedData);
        return redirect('/tasks')->with('success', 'Task is successfully saved');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if(!Auth::user())return redirect('/');
        $task = Task::findOrFail($id);
        if (Auth::user()->position != 'manager'){
            if(!in_array(Auth::user()->id, json_decode($task->performers)))return redirect('/');
        }
        return view('show', compact('task'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(!Auth::user())return redirect('/');

        $task = Task::findOrFail($id);
        $developers = User::where('position', '=', 'developer')->pluck('name', 'id');

        return view('edit', compact('task','developers'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'title' => 'required|max:255',
            'deadline' => "required|date|after:now",
            'description' => 'required',
        ]);
        $validatedData['status'] = 'assigned';
        $validatedData['performers'] = json_encode($request->performers);
        $validatedData['author_id'] = Auth::user()->id;
        if(empty($request->performers)){
            $validatedData['status'] = 'created';
            $validatedData['performers'] = '[null]';
        }
        if($validatedData['deadline']){
            $date = strtotime($validatedData['deadline']);
            $validatedData['deadline'] = date("Y-m-d H:i:s", $date);
        }
        Task::whereId($id)->update($validatedData);

        return redirect('/tasks')->with('success', 'Task is successfully updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $book = Task::findOrFail($id);
        $book->delete();

        return redirect('/tasks')->with('success', 'Task is successfully deleted');
    }

    public function change(Request $request)
    {
        $result = Task::whereId($request->id)->update(['status'=>$request->status]);
        echo $result;
    }
}
