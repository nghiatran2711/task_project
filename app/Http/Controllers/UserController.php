<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
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
        $users=User::paginate(5);

        $data['users']=$users;
        
        return view('users.index',$data);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateUserRequest $request)
    {
        //
        $avatarPath=null;
        if($request->hasFile('avatar') && $request->file('avatar')->isValid()){
            //Nếu có thì thực hiện lưu trữ vào public/images
            $image=$request->file('avatar');
            $extension=$request->avatar->extension();
            $fileName='avatar_'.time().'.'.$extension;
            $avatarPath=$image->move('images',$fileName);
        }

        $data=[
            'name' => $request->name,
            'email' => $request->email,
            'password'=>bcrypt($request->password),
            'avatar'=>$avatarPath,
        ];

            DB::beginTransaction();
        try{
            User::create($data); 

            DB::commit();
            return redirect()->route('user.index')->with('success','Add user success !!!');

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
        $user=User::find($id);
        
        return view('users.edit',['user'=>$user]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserRequest $request, $id)
    {
        //
        $user=User::find($id);
        $avatarOld=$user->avatar;   

        //update data for table users

        $user->name=$request->name;
        $user->email=$request->email;
        $avatarPath=null;
        if($request->hasFile('avatar') && $request->file('avatar')->isValid()){
            $image=$request->file('avatar');
            $extension=$request->avatar->extension();
            $fileName='avatar_'.time().'.'.$extension;
            $avatarPath=$image->move('images',$fileName);
            $user->avatar=$avatarPath;
            Log::info('avatarPath: ' . $avatarPath);
        }
        DB::beginTransaction();
        try{
            $user->save();
            DB::commit();
            if($request->file('avatar') && File::exists(public_path($avatarOld))){
                File::delete(public_path($avatarOld));
            }
            return redirect()->route('user.index')->with('success','Update user success');
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
        DB::beginTransaction();
        try{
        
            $user=User::find($id);
            $avatar=$user->avatar;
            $user->delete();
            DB::commit();
        if(File::exists(public_path($avatar))){
            File::delete(public_path($avatar));
        }
        return redirect()->route('user.index')->with('success','Delete user success');
        }catch(\Exception $ex){
            return redirect()->back()->with('error',$ex->getMessage());
        }
        
        
    }
}
