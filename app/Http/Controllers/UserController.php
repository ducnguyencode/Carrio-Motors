<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        // Add admin middleware to specific actions
        $this->middleware('admin')->only(['index', 'create', 'store', 'destroy', 'restore']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Get users with filter options
        $query = User::query();

        // Filter by role if requested
        if ($request->has('role') && in_array($request->role, ['admin', 'saler', 'user'])) {
            $query->where('role', $request->role);
        }

        // Filter active/inactive if requested
        if ($request->has('status')) {
            $isActive = $request->status === 'active';
            $query->where('is_active', $isActive);
        }

        // Search by name or email
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('fullname', 'like', "%{$search}%")
                  ->orWhere('username', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $users = $query->paginate(10);

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
            'role' => 'required|string|in:admin,saler,user',
        ]);

        $data['is_active'] = $request->has('is_active');
        $data['password'] = Hash::make($data['password']);
        $user = User::create($data);

        return redirect()->route('users.index')->with('success', 'User created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        // Allow users to view only their own profile unless they're admin
        if (!Auth::user()->isAdmin() && Auth::id() !== $user->id) {
            return redirect()->route('users.show', Auth::id())
                ->with('error', 'You can only view your own profile');
        }

        return view('users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        // Allow users to edit only their own profile unless they're admin
        if (!Auth::user()->isAdmin() && Auth::id() !== $user->id) {
            return redirect()->route('users.edit', Auth::id())
                ->with('error', 'You can only edit your own profile');
        }

        return view('users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        // Allow users to update only their own profile unless they're admin
        if (!Auth::user()->isAdmin() && Auth::id() !== $user->id) {
            return redirect()->route('users.edit', Auth::id())
                ->with('error', 'You can only update your own profile');
        }

        $rules = [
            'username' => 'required|string|max:255|unique:users,username,' . $user->id . ',id',
            'fullname' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id . ',id',
            'phone' => 'required|string|max:255|unique:users,phone,' . $user->id . ',id',
            'address' => 'required|string|max:255',
        ];

        // Only admin can change roles and active status
        if (Auth::user()->isAdmin()) {
            $rules['role'] = 'required|string|in:admin,saler,user';
            $rules['is_active'] = 'boolean';
        }

        $data = $request->validate($rules);

        // Handle is_active checkbox
        if (Auth::user()->isAdmin()) {
            $data['is_active'] = $request->has('is_active');
        }

        // If password is provided, update it
        if ($request->filled('password')) {
            $request->validate([
                'password' => 'required|string|min:8|confirmed',
            ]);

            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        if (Auth::user()->isAdmin()) {
            return redirect()->route('users.index')->with('success', 'User updated successfully');
        } else {
            return redirect()->route('users.show', $user->id)->with('success', 'Your profile has been updated');
        }
    }

    /**
     * Toggle the active status of the specified resource.
     */
    public function toggleActive(User $user)
    {
        // Prevent admins from deactivating themselves
        if (Auth::id() === $user->id) {
            return redirect()->route('users.index')
                ->with('error', 'You cannot toggle your own active status');
        }

        $user->is_active = !$user->is_active;
        $user->save();

        $status = $user->is_active ? 'activated' : 'deactivated';
        return redirect()->route('users.index')->with('success', "User {$status} successfully");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        // Prevent admins from deleting themselves
        if (Auth::id() === $user->id) {
            return redirect()->route('users.index')
                ->with('error', 'You cannot delete your own account');
        }

        // Soft delete by setting is_active to false
        $user->is_active = false;
        $user->save();

        return redirect()->route('users.index')->with('success', 'User deactivated successfully');
    }
}
