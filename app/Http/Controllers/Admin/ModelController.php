<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CarModel;
use App\Models\Make;
use App\Services\ActivityLogService;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ModelController extends Controller
{
    public function __construct()
    {
        // ensure user is logged in
        $this->middleware('auth');

        // // Log access attempt for debugging
        // Log::debug('ModelController accessed', [
        //     'user' => Auth::user()->username,
        //     'role' => Auth::user()->role,
        //     'action' => 'constructor'
        // ]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = CarModel::with('make');

        // Handle search
        if ($request->has('search') && !empty($request->search)) {
            $query->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%')
                  ->orWhereHas('make', function($q) use ($request) {
                      $q->where('name', 'like', '%' . $request->search . '%');
                  });
        }

        // Handle status filter
        if ($request->has('status') && $request->status !== 'all') {
            $status = $request->status === 'active' ? 1 : 0;
            $query->where('isActive', $status);
        }

        // Handle make filter
        if ($request->has('make_id') && !empty($request->make_id)) {
            $query->where('make_id', $request->make_id);
        }

        $models = $query->orderBy('created_at', 'desc')->paginate(10);
        $makes = Make::all();

        return view('admin.models.index', compact('models', 'makes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $makes = Make::active()->get();
        return view('admin.models.create', compact('makes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'year' => 'nullable|integer|min:1886|max:' . (date('Y') + 1),
            'make_id' => 'required|exists:makes,id',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $data = $request->only(['name', 'description', 'year', 'make_id']);

        // Set isActive field
        $data['isActive'] = $request->has('isActive') ? 1 : 0;

        $model = CarModel::create($data);

        // Log activity
        if (class_exists('App\Services\ActivityLogService')) {
            ActivityLogService::log(
                'create',
                'models',
                $model->id,
                ['name' => $model->name, 'make' => $model->make->name]
            );
        }

        return redirect()->route('admin.models.index')
            ->with('success', 'Model created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(CarModel $model)
    {
        $model->load('make');
        return view('admin.models.show', compact('model'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CarModel $model)
    {
        $makes = Make::active()->get();
        return view('admin.models.edit', compact('model', 'makes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CarModel $model)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'year' => 'nullable|integer|min:1886|max:' . (date('Y') + 1),
            'make_id' => 'required|exists:makes,id',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $data = $request->only(['name', 'description', 'year', 'make_id']);

        // Set isActive field
        $data['isActive'] = $request->has('isActive') ? 1 : 0;

        // Store original data for logging
        $originalData = $model->toArray();

        $model->update($data);

        // Log activity
        if (class_exists('App\Services\ActivityLogService')) {
            ActivityLogService::log(
                'update',
                'models',
                $model->id,
                [
                    'changed_fields' => array_keys(array_diff_assoc($data, array_intersect_key($originalData, $data))),
                    'name' => $model->name,
                    'make' => $model->make->name
                ]
            );
        }

        return redirect()->route('admin.models.index')
            ->with('success', 'Model updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CarModel $model)
    {
        // Check if has related cars
        if ($model->cars()->count() > 0) {
            return redirect()->route('admin.models.index')
                ->with('error', 'Cannot delete model with related cars. Please delete all cars first.');
        }

        // Store model info before deletion for logging
        $modelInfo = [
            'id' => $model->id,
            'name' => $model->name,
            'make' => $model->make->name
        ];

        $model->delete();

        // Log activity
        if (class_exists('App\Services\ActivityLogService')) {
            ActivityLogService::log(
                'delete',
                'models',
                $modelInfo['id'],
                $modelInfo
            );
        }

        return redirect()->route('admin.models.index')
            ->with('success', 'Model deleted successfully.');
    }
}
