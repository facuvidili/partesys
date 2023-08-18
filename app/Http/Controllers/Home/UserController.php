<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home.users.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        return view('home.users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:30',
            'email' => 'required|max:30|unique:users',
            'password' => 'required',
            'dni' => 'required|unique:users|max:10|min:7',
            'phone_number' => 'max:10'
        ]);
        $user = User::create([
            'name' => $request->name,
            'dni' => $request->dni,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'phone_number' => $request->phone_number?$request->phone_number: '-',
        ]);
        $user->assignRole($request->role);
        return redirect()->route('home.users.index')->with('info', 'El usuario se agregó correctamente');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return view('home.users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        return view('home.users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|max:30',
            // 'password' => 'required',
            'email' => "required|max:30|unique:users,email,$user->id", //para que en caso de no modificar el email ignore el error
            'phone_number' => "max:10|unique:users,phone_number, $user->id"
        ]);
        $user->update($request->all());
        return redirect()->route('home.users.index')->with('info', 'El usuario se actualizó correctamente');  
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();
        // return redirect()->route('home.users.index')->with('info','El usuario se eliminó correctamente');
        return redirect()->route('home.users.index');
    }
}
