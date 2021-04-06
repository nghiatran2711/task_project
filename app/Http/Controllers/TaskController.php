<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $data=[];
        $tasks=Task::paginate(5);
        $data['tasks']=$tasks;
        return view('tasks.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $data=[];
        $users=User::pluck('name','id');
        $data['users']=$users;
        return view('tasks.create',$data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateTaskRequest $request)
    {
        //
        $taskInsert=[];
        $taskInsert=[
            'content'=>$request->content,
            'user_id'=>$request->user_id,
        ];
        DB::beginTransaction();
        try{
            Task::create($taskInsert);
            DB::commit();
            return redirect()->route('task.index')->with('success','Add task success');
        }catch(\Exception $ex){
            DB::rollBack();
            return redirect()->back()->with('error',$ex->getMessage());
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $data=[];
        $task=Task::find($id);
        $users=User::pluck('name','id');
        $data['task']=$task;     
        $data['users']=$users;   
        return view('tasks.edit',$data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTaskRequest $request, $id)
    {
        //
        $task=Task::find($id);
        $task->content=$request->content;
        $task->user_id=$request->user_id;
         
        DB::beginTransaction();
        try{
           $task->save();
           DB::commit();
           return redirect()->route('task.index')->with('success','Update task success'); 

        }catch(\Exception $ex){
            DB::rollBack();
            return redirect()->back()->with('error',$ex->getMessage());
            
        }
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
        $task=Task::find($id);
        
        DB::beginTransaction();
        try{
            $task->delete();
            DB::commit();
            return redirect()->route('task.index')->with('success','Delete task success');
        }catch(\Exception $ex){
            DB::rollBack();
            return redirect()->back()->with('error',$ex->getMessage());
        }
    }
}
