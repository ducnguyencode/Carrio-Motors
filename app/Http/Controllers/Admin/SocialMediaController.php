<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SocialMediaLink;
use Illuminate\Http\Request;

class SocialMediaController extends Controller
{
    /**
     * Display a listing of social media links.
     */
    public function index()
    {
        $socialMediaLinks = SocialMediaLink::orderBy('display_order')->paginate(10);
        return view('admin.social_media.index', compact('socialMediaLinks'));
    }

    /**
     * Show the form for creating a new social media link.
     */
    public function create()
    {
        return view('admin.social_media.create');
    }

    /**
     * Store a newly created social media link in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'platform_name' => 'required|string|max:255',
            'url' => 'required|url|max:255',
            'icon_class' => 'required|string|max:255',
            'display_order' => 'integer',
        ]);

        // Handle checkbox - set is_active to 0 if not present in request
        $data = $request->all();
        $data['is_active'] = $request->has('is_active') ? 1 : 0;
        // Handle show_on_car_detail - set to 1 if checked, otherwise 0
        $data['show_on_car_detail'] = $request->has('show_on_car_detail') ? 1 : 0;

        SocialMediaLink::create($data);

        return redirect()->route('admin.social-media.index')
            ->with('success', 'Social media link created successfully.');
    }

    /**
     * Display the specified social media link.
     */
    public function show(SocialMediaLink $social_medium)
    {
        return view('admin.social_media.show', compact('social_medium'));
    }

    /**
     * Show the form for editing the specified social media link.
     */
    public function edit(SocialMediaLink $social_medium)
    {
        return view('admin.social_media.edit', compact('social_medium'));
    }

    /**
     * Update the specified social media link in storage.
     */
    public function update(Request $request, SocialMediaLink $social_medium)
    {
        $request->validate([
            'platform_name' => 'required|string|max:255',
            'url' => 'required|url|max:255',
            'icon_class' => 'required|string|max:255',
            'display_order' => 'integer',
        ]);

        // Handle checkbox - set is_active to 0 if not present in request
        $data = $request->all();
        $data['is_active'] = $request->has('is_active') ? 1 : 0;
        // Handle show_on_car_detail
        $data['show_on_car_detail'] = $request->has('show_on_car_detail') ? 1 : 0;

        $social_medium->update($data);

        return redirect()->route('admin.social-media.index')
            ->with('success', 'Social media link updated successfully.');
    }

    /**
     * Remove the specified social media link from storage.
     */
    public function destroy(SocialMediaLink $social_medium)
    {
        try {
            // Log the deletion action
            \Illuminate\Support\Facades\Log::info('Deleting social media link', ['id' => $social_medium->id, 'platform' => $social_medium->platform_name]);

            // Perform deletion
            $result = $social_medium->delete();

            // Log the result
            \Illuminate\Support\Facades\Log::info('Social media delete result', ['success' => $result ? 'true' : 'false']);

            return redirect()->route('admin.social-media.index')
                ->with('success', 'Social media link deleted successfully.');
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Error deleting social media link', [
                'id' => $social_medium->id,
                'error' => $e->getMessage()
            ]);

            return redirect()->route('admin.social-media.index')
                ->with('error', 'Error deleting social media link: ' . $e->getMessage());
        }
    }

    /**
     * Update the active status of a social media link.
     */
    public function toggleActive(Request $request, SocialMediaLink $socialMedia)
    {
        $socialMedia->is_active = !$socialMedia->is_active;
        $socialMedia->save();

        return redirect()->route('admin.social-media.index')
            ->with('success', 'Social media link status updated successfully.');
    }

    /**
     * Update the display order of social media links.
     */
    public function updateOrder(Request $request)
    {
        $request->validate([
            'orders' => 'required|array',
            'orders.*' => 'integer',
        ]);

        foreach ($request->orders as $id => $order) {
            SocialMediaLink::where('id', $id)->update(['display_order' => $order]);
        }

        return response()->json(['success' => true]);
    }
}
