<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CarModel;
use App\Models\Make;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ModelController extends Controller
{
    public function __construct()
    {
        // ensure user is logged in
        $this->middleware('auth');

        // Log access attempt for debugging
        Log::debug('ModelController accessed', [
            'user' => Auth::user()->username,
            'role' => Auth::user()->role,
            'action' => 'constructor'
        ]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // More detailed logging
        Log::debug('ModelController index method accessed', [
            'user' => Auth::user()->username,
            'role' => Auth::user()->role
        ]);

        // Check the role specifically (for debugging)
        if (Auth::user()->role === 'content') {
            Log::debug('Content user has correct role for this method');
        }

        $models = CarModel::with('make')->paginate(10);
        return view('admin.models.index', compact('models'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $makes = Make::all();
        return view('admin.models.create', compact('makes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'year' => 'nullable|integer|min:1886|max:' . (date('Y') + 1),
            'make_id' => 'required|exists:makes,id',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        CarModel::create($request->only(['name', 'year', 'make_id']));

        return redirect()->route('admin.models.index')
            ->with('success', 'Model created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(CarModel $model)
    {
        return view('admin.models.show', compact('model'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CarModel $model)
    {
        $makes = Make::all();
        return view('admin.models.edit', compact('model', 'makes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CarModel $model)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'year' => 'nullable|integer|min:1886|max:' . (date('Y') + 1),
            'make_id' => 'required|exists:makes,id',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $model->update($request->only(['name', 'year', 'make_id']));

        return redirect()->route('admin.models.index')
            ->with('success', 'Model updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CarModel $model)
    {
        $model->delete();
        return redirect()->route('admin.models.index')
            ->with('success', 'Model deleted successfully.');
    }
}
