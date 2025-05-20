<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Make;
use App\Services\ActivityLogService;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class MakeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Make::query();

        // Handle search
        if ($request->has('search') && !empty($request->search)) {
            $query->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
        }

        // Handle status filter
        if ($request->has('status') && $request->status !== 'all') {
            $status = $request->status === 'active' ? 1 : 0;
            $query->where('isActive', $status);
        }

        $makes = $query->orderBy('created_at', 'desc')->paginate(10);
        return view('admin.makes.index', compact('makes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.makes.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:makes',
            'description' => 'nullable|string',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $data = $request->only(['name', 'description']);

        // Set isActive field
        $data['isActive'] = $request->has('isActive') ? 1 : 0;

        if ($request->hasFile('logo')) {
            $file = $request->file('logo');
            $filename = time() . '_' . Str::slug($request->name) . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('makes', $filename, 'public');
            $data['logo'] = $path;
        }

        $make = Make::create($data);

        // Log activity
        if (class_exists('App\Services\ActivityLogService')) {
            ActivityLogService::log(
                'create',
                'makes',
                $make->id,
                ['name' => $make->name]
            );
        }

        return redirect()->route('admin.makes.index')
            ->with('success', 'Make created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Make $make)
    {
        return view('admin.makes.show', compact('make'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Make $make)
    {
        return view('admin.makes.edit', compact('make'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Make $make)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:makes,name,'.$make->id,
            'description' => 'nullable|string',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $data = $request->only(['name', 'description']);

        // Set isActive field
        $data['isActive'] = $request->has('isActive') ? 1 : 0;

        if ($request->hasFile('logo')) {
            // Remove old logo if exists
            if ($make->logo) {
                Storage::disk('public')->delete($make->logo);
            }

            $file = $request->file('logo');
            $filename = time() . '_' . Str::slug($request->name) . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('makes', $filename, 'public');
            $data['logo'] = $path;
        }

        // Store original data for logging
        $originalData = $make->toArray();

        $make->update($data);

        // Log activity
        if (class_exists('App\Services\ActivityLogService')) {
            ActivityLogService::log(
                'update',
                'makes',
                $make->id,
                [
                    'changed_fields' => array_keys(array_diff_assoc($data, array_intersect_key($originalData, $data))),
                    'name' => $make->name
                ]
            );
        }

        return redirect()->route('admin.makes.index')
            ->with('success', 'Make updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Make $make)
    {
        // Check if has related models
        if ($make->models()->count() > 0) {
            return redirect()->route('admin.makes.index')
                ->with('error', 'Cannot delete make with related models. Please delete all models first.');
        }

        // Remove logo if exists
        if ($make->logo) {
            Storage::disk('public')->delete($make->logo);
        }

        // Store make info before deletion for logging
        $makeInfo = [
            'id' => $make->id,
            'name' => $make->name
        ];

        $make->delete();

        // Log activity
        if (class_exists('App\Services\ActivityLogService')) {
            ActivityLogService::log(
                'delete',
                'makes',
                $makeInfo['id'],
                $makeInfo
            );
        }

        return redirect()->route('admin.makes.index')
            ->with('success', 'Make deleted successfully.');
    }
}
