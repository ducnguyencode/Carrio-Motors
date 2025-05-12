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
    public function index()
    {
        $engines = Engine::paginate(10);
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
            'displacement' => 'nullable|numeric|min:0.1|max:20',
            'cylinders' => 'nullable|integer|min:1|max:16',
            'power' => 'nullable|integer|min:1',
            'torque' => 'nullable|integer|min:1',
            'fuel_type' => 'required|in:gasoline,diesel,electric,hybrid,plug-in hybrid',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        Engine::create($request->only([
            'name', 'displacement', 'cylinders', 'power', 'torque', 'fuel_type'
        ]));

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
            'displacement' => 'nullable|numeric|min:0.1|max:20',
            'cylinders' => 'nullable|integer|min:1|max:16',
            'power' => 'nullable|integer|min:1',
            'torque' => 'nullable|integer|min:1',
            'fuel_type' => 'required|in:gasoline,diesel,electric,hybrid,plug-in hybrid',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $engine->update($request->only([
            'name', 'displacement', 'cylinders', 'power', 'torque', 'fuel_type'
        ]));

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
