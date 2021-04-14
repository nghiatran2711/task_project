<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    // public function __construct()
    // {
    //     $this->middleware(['jwt.auth','auth:api'], ['except' => ['index', 'show']]);
    // }
    public function index()
    {
        //
        $tasks=Task::with('user')->paginate(5);
        
        return response()->json($tasks);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $validatedData = $request->validate([
            'content' => ['required', 'max:255'],
            'user_id' => ['required'],
        ]);
        DB::beginTransaction();
        try{
            Task::create($validatedData);
            DB::commit();
            return response()->json(['success' => 'Insert into data to Task Successful.']);
        }catch(\Exception $ex){
            DB::rollBack();
            Log::error($ex->getMessage());
            return response()->json(['error',$ex->getMessage()],500);
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
        $task=Task::find($id);
        return response()->json($task);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        //
        $validatedData = $request->validate([
            'content' => ['required', 'max:255'],
            'user_id' => ['required'],
        ]);
        DB::beginTransaction();
        try{
            $task=Task::find($id);
            $task->content=$request->content;
            $task->user_id=$request->user_id;
            $task->save();
            DB::commit();
            return response()->json(['Success'=>'Update data to Task Successful!']);
        }catch(\Exception $ex){
            DB::rollBack();
            return response()->json(['Error' => $ex->getMessage()], 500);
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
        
        DB::beginTransaction();
        try{
            Task::findOrFail($id)->delete();
            DB::commit();
            return response()->json(['Success'=>'Delete task success']);
        }catch(\Exception $ex){
            DB::rollBack();
            return response()->json(['Error'=>$ex->getMessage()],500);
        }
    }
}
