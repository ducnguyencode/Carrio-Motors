<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the users.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $query = User::query();
        if (request('search')) {
            $search = request('search');
            $query->where(function($q) use ($search) {
                $q->where('username', 'like', "%$search%")
                  ->orWhere('fullname', 'like', "%$search%")
                  ->orWhere('email', 'like', "%$search%")
                  ->orWhere('phone', 'like', "%$search%")
                  ->orWhere('address', 'like', "%$search%")
                  ->orWhere('role', 'like', "%$search%")
                ;
            });
        }
        $users = $query->paginate(10);
        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new user.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * Store a newly created user in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|string|max:50|unique:users,username',
            'fullname' => 'required|string|max:100',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'role' => 'required|in:admin,content,saler,user',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Check if trying to create an admin account when one already exists
        if ($request->role === 'admin' && \App\Models\User::where('role', 'admin')->count() > 0) {
            return redirect()->back()
                ->withErrors(['role' => 'Only one admin account is allowed in the system.'])
                ->withInput();
        }

        $user = \App\Models\User::create([
            'username' => $request->username,
            'fullname' => $request->fullname,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
            'address' => $request->address,
            'role' => $request->role,
            'is_active' => $request->has('is_active'),
        ]);

        // Log the activity
        \App\Services\ActivityLogService::log(
            'create',
            'users',
            $user->id,
            ['role' => $user->role, 'username' => $user->username]
        );

        return redirect()->route('admin.users.index')
            ->with('success', 'User created successfully.');
    }

    /**
     * Display the specified user.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return view('admin.users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified user.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        // Prevent admins from editing other admins unless they are editing themselves
        if ($user->isAdmin() && auth()->user()->isAdmin() && auth()->id() !== $user->id) {
            return redirect()->route('admin.users.index')
                ->with('error', 'Admins cannot edit other admin accounts for security reasons.');
        }

        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update the specified user in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        // Prevent admins from updating other admins unless they are updating themselves
        if ($user->isAdmin() && auth()->user()->isAdmin() && auth()->id() !== $user->id) {
            return redirect()->route('admin.users.index')
                ->with('error', 'Admins cannot update other admin accounts for security reasons.');
        }

        // Prevent changing role of the only admin account
        $isOnlyAdmin = $user->role === 'admin' && \App\Models\User::where('role', 'admin')->count() === 1;
        if ($isOnlyAdmin && $request->role !== 'admin') {
            return redirect()->back()
                ->with('error', 'Cannot change the role of the only admin account in the system.');
        }

        $validator = Validator::make($request->all(), [
            'username' => 'required|string|max:50|unique:users,username,' . $user->id,
            'fullname' => 'required|string|max:100',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'role' => 'required|in:admin,content,saler,user',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Check if trying to change role to admin when one already exists
        if ($request->role === 'admin' && $user->role !== 'admin' && \App\Models\User::where('role', 'admin')->count() > 0) {
            return redirect()->back()
                ->withErrors(['role' => 'Only one admin account is allowed in the system.'])
                ->withInput();
        }

        $userData = [
            'username' => $request->username,
            'fullname' => $request->fullname,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'role' => $request->role,
            'is_active' => $request->has('is_active'),
        ];

        // Only update password if provided
        if (!empty($request->password)) {
            $userData['password'] = Hash::make($request->password);
        }

        // Store original data for logging
        $originalData = $user->toArray();

        $user->update($userData);

        // Log the activity
        \App\Services\ActivityLogService::log(
            'update',
            'users',
            $user->id,
            [
                'changed_fields' => array_keys(array_diff_assoc($userData, $originalData)),
                'username' => $user->username
            ]
        );

        return redirect()->route('admin.users.index')
            ->with('success', 'User updated successfully.');
    }

    /**
     * Remove the specified user from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        // Prevent admins from deleting other admins
        if ($user->isAdmin() && auth()->user()->isAdmin() && auth()->id() !== $user->id) {
            return redirect()->route('admin.users.index')
                ->with('error', 'Admins cannot delete other admin accounts for security reasons.');
        }

        // Do not allow deleting yourself
        if ($user->id === auth()->id()) {
            return redirect()->route('admin.users.index')
                ->with('error', 'Cannot delete your own account.');
        }

        // Store user info before deletion for logging
        $userInfo = [
            'id' => $user->id,
            'username' => $user->username,
            'role' => $user->role,
            'email' => $user->email
        ];

        $user->delete();

        // Log the activity
        \App\Services\ActivityLogService::log(
            'delete',
            'users',
            $userInfo['id'],
            $userInfo
        );

        return redirect()->route('admin.users.index')
            ->with('success', 'User deleted successfully.');
    }
}
