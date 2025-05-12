<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Make;
use Illuminate\Support\Facades\Validator;

class MakeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $makes = Make::paginate(10);
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

        if ($request->hasFile('logo')) {
            $file = $request->file('logo');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/makes'), $filename);
            $data['logo'] = 'uploads/makes/' . $filename;
        }

        Make::create($data);

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

        if ($request->hasFile('logo')) {
            $file = $request->file('logo');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/makes'), $filename);
            $data['logo'] = 'uploads/makes/' . $filename;
        }

        $make->update($data);

        return redirect()->route('admin.makes.index')
            ->with('success', 'Make updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Make $make)
    {
        $make->delete();
        return redirect()->route('admin.makes.index')
            ->with('success', 'Make deleted successfully.');
    }
}
