<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\UserRole;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
//        if(Gate::allows('is-admin'))
//        {
//            return view ('admin.users.index',['users'=>User::all()]);
//        }

        $users = User::getUsers('');
        $a = 0;
        return view('admin.users.index')
            ->with('users', $users)
            ->with('a',$a);
    }

    public function getMoreUsers(Request $request) {
        $query = $request->search_query;
        if($request->ajax()) {
            $users = User::getUsers($query);
            return view('admin.users.includes.users_data', compact('users'))->render();
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view ('admin.users.create',['roles'=>Role::all()]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = User::create(
            [
                'username' => $request->input('username'),
                'email' => $request->input('email'),
                'password' => Hash::make($request->password),
            ]);
        $user->roles()->sync($request->roles);

        UserRole::create(
            [
                'user_id' => $user->id,
                'role_id' => 4
            ]);

        Password::sendResetLink($request->only(['email']));

        return redirect( route('admin.users.index') );
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

        return view( 'admin.users.edit',[
            'roles' => Role::all(),
            'user' => User::find($id),
        ]);
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
        $user = User::findOrFail($id);
        $user->update($request->except(['remember_token','roles']));
        $user->roles()->sync($request->roles);

        UserRole::create(
            [
                'user_id' => $user->id,
                'role_id' => 4
            ]);

        return redirect( route('admin.users.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        User::find($id)->delete();
        return redirect()->back();
    }

    public function validateUserEmail(Request $request)
    {
        $user = User::where('email', $request->input('email'))->first('email');
        if($user){
            $return =  false;
        }
        else{
            $return= true;
        }
        echo json_encode($return);
        exit;
    }

    public function validateUsername(Request $request)
    {
        $user = User::where('username', $request->input('username'))->first('username');
        if($user){
            $return =  false;
        }
        else{
            $return= true;
        }
        echo json_encode($return);
        exit;
    }
}
