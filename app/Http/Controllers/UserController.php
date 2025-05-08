<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::paginate(10);
        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'username' => 'required|string|max:255|unique:users',
            'fullname' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'phone' => 'required|string|max:255|unique:users',
            'address' => 'required|string|max:255',
            'is_active' => 'boolean',
        ]);

        $user = User::create($data);
        return redirect()->route('users.index')->with('success', 'User created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'username' => 'required|string|max:255|unique:users,username,' .$user->id. ',id',
            'fullname' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' .$user->id. ',id',
            'phone' => 'required|string|max:255|unique:users,phone,' .$user->id. ',id',
            'address' => 'required|string|max:255',
            'is_active' => 'boolean',
        ]);

        if (empty($data['password'])){
            unset($data['password']);
        }

        $user->update($data);

        return redirect()->route('users.index')->with('success', 'User updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->update(['is_active' => false]);
        return redirect()->route('users.index')->with('success', 'User deactivated successfully');
    }
}
