<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Engine;
use Illuminate\Support\Facades\Validator;

class EngineController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Engine::query();

        // Handle search
        if ($request->has('search') && !empty($request->search)) {
            $query->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('engine_type', 'like', '%' . $request->search . '%');
        }

        $engines = $query->paginate(10);
        return view('admin.engines.index', compact('engines'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.engines.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'horsepower' => 'nullable|integer|min:1',
            'level' => 'nullable|string|max:255',
            'max_speed' => 'nullable|integer|min:1',
            'drive_type' => 'nullable|string|max:255',
            'engine_type' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $data = $request->only([
            'name', 'horsepower', 'level', 'max_speed', 'drive_type', 'engine_type'
        ]);

        // Set isActive field
        $data['isActive'] = $request->has('isActive') ? 1 : 0;

        Engine::create($data);

        return redirect()->route('admin.engines.index')
            ->with('success', 'Engine created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Engine $engine)
    {
        return view('admin.engines.show', compact('engine'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Engine $engine)
    {
        return view('admin.engines.edit', compact('engine'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Engine $engine)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'horsepower' => 'nullable|integer|min:1',
            'level' => 'nullable|string|max:255',
            'max_speed' => 'nullable|integer|min:1',
            'drive_type' => 'nullable|string|max:255',
            'engine_type' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $data = $request->only([
            'name', 'horsepower', 'level', 'max_speed', 'drive_type', 'engine_type'
        ]);

        // Set isActive field
        $data['isActive'] = $request->has('isActive') ? 1 : 0;

        $engine->update($data);

        return redirect()->route('admin.engines.index')
            ->with('success', 'Engine updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Engine $engine)
    {
        $engine->delete();
        return redirect()->route('admin.engines.index')
            ->with('success', 'Engine deleted successfully.');
    }
}
