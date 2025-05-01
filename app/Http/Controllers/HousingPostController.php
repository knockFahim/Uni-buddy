<?php

namespace App\Http\Controllers;

use App\Models\HousingPost;
use App\Models\HousingPhoto;
use App\Models\RoommatePreference;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class HousingPostController extends Controller
{
    /**
     * Display a listing of housing posts.
     */
    public function index(Request $request)
    {
        $filters = $request->only([
            'min_price', 'max_price', 'property_type', 'bedrooms',
            'bathrooms', 'location', 'available_from', 'utilities_included'
        ]);
        
        $posts = HousingPost::with(['user', 'photos' => function($query) {
            $query->where('is_primary', true);
        }])
        ->filter($filters)
        ->available()
        ->latest()
        ->paginate(10);
        
        return view('housing.index', [
            'posts' => $posts,
            'filters' => $filters
        ]);
    }

    /**
     * Show the form for creating a new housing post.
     */
    public function create()
    {
        return view('housing.create');
    }

    /**
     * Store a newly created housing post.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'rent_amount' => 'required|numeric|min:0',
            'bedrooms' => 'required|integer|min:0',
            'bathrooms' => 'required|numeric|min:0',
            'description' => 'required|string',
            'contact_phone' => 'nullable|string|max:20',
            'property_type' => 'required|string|max:50',
            'utilities_included' => 'boolean',
            'available_from' => 'required|date',
            'photos' => 'nullable|array|max:10',
            'photos.*' => 'image|max:5120', // 5MB per image
        ]);
        
        // Set default values
        $validated['user_id'] = Auth::id();
        $validated['is_available'] = true;
        $validated['utilities_included'] = isset($validated['utilities_included']);
        
        // Create the housing post
        $post = HousingPost::create($validated);
        
        // Handle photo uploads
        if ($request->hasFile('photos')) {
            $this->handlePhotoUploads($request->file('photos'), $post);
        }
        
        return redirect()->route('housing.my-posts')
            ->with('success', 'Housing listing created successfully.');
    }

    /**
     * Display a specific housing post.
     */
    public function show($id)
    {
        $post = HousingPost::with(['user', 'photos', 'approvedReviews.user'])
            ->findOrFail($id);
            
        // Check if current user has already reviewed this property
        $userHasReviewed = false;
        
        if (Auth::check()) {
            $userHasReviewed = $post->reviews()
                ->where('user_id', Auth::id())
                ->exists();
        }
        
        return view('housing.show', [
            'post' => $post,
            'userHasReviewed' => $userHasReviewed
        ]);
    }

    /**
     * Show the form for editing a housing post.
     */
    public function edit($id)
    {
        $post = HousingPost::with('photos')->findOrFail($id);
        
        // Check if current user owns this post
        if ($post->user_id !== Auth::id()) {
            abort(403, 'You cannot edit someone else\'s housing post.');
        }
        
        return view('housing.edit', [
            'post' => $post
        ]);
    }

    /**
     * Update a housing post.
     */
    public function update(Request $request, $id)
    {
        $post = HousingPost::findOrFail($id);
        
        // Check if current user owns this post
        if ($post->user_id !== Auth::id()) {
            abort(403, 'You cannot edit someone else\'s housing post.');
        }
        
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'rent_amount' => 'required|numeric|min:0',
            'bedrooms' => 'required|integer|min:0',
            'bathrooms' => 'required|numeric|min:0',
            'description' => 'required|string',
            'contact_phone' => 'nullable|string|max:20',
            'property_type' => 'required|string|max:50',
            'utilities_included' => 'boolean',
            'available_from' => 'required|date',
            'is_available' => 'boolean',
            'photos' => 'nullable|array|max:10',
            'photos.*' => 'image|max:5120', // 5MB per image
            'delete_photos' => 'nullable|array',
            'delete_photos.*' => 'integer|exists:housing_photos,id',
        ]);
        
        // Update boolean fields
        $validated['utilities_included'] = isset($validated['utilities_included']);
        $validated['is_available'] = isset($validated['is_available']);
        
        // Update the housing post
        $post->update($validated);
        
        // Delete photos if requested
        if ($request->has('delete_photos')) {
            foreach ($request->delete_photos as $photoId) {
                $photo = HousingPhoto::find($photoId);
                if ($photo && $photo->housing_post_id == $post->id) {
                    $photo->delete(); // This will also delete the file from storage
                }
            }
        }
        
        // Handle new photo uploads
        if ($request->hasFile('photos')) {
            $this->handlePhotoUploads($request->file('photos'), $post);
        }
        
        return redirect()->route('housing.my-posts')
            ->with('success', 'Housing listing updated successfully.');
    }

    /**
     * Remove a housing post.
     */
    public function destroy($id)
    {
        $post = HousingPost::findOrFail($id);
        
        // Check if current user owns this post
        if ($post->user_id !== Auth::id() && !Auth::user()->is_admin) {
            abort(403, 'You cannot delete someone else\'s housing post.');
        }
        
        // Delete the post (photos will be deleted via the model's boot method)
        $post->delete();
        
        return redirect()->route('housing.my-posts')
            ->with('success', 'Housing listing deleted successfully.');
    }

    /**
     * Display user's own housing posts.
     */
    public function myHousingPosts()
    {
        $posts = HousingPost::with(['photos' => function($query) {
            $query->where('is_primary', true);
        }])
        ->where('user_id', Auth::id())
        ->latest()
        ->get();
        
        // Count statistics
        $statistics = [
            'total' => $posts->count(),
            'available' => $posts->where('is_available', true)->count(),
            'unavailable' => $posts->where('is_available', false)->count(),
        ];
        
        return view('housing.my-posts', [
            'posts' => $posts,
            'statistics' => $statistics
        ]);
    }

    /**
     * Find matching housing based on user preferences.
     */
    public function findMatches()
    {
        $userId = Auth::id();
        $matches = HousingPost::findMatchingHousing($userId);
        
        return view('housing.matches', [
            'matches' => $matches
        ]);
    }

    /**
     * Handle uploading and storing photos for housing posts.
     */
    private function handlePhotoUploads($files, $housingPost)
    {
        $counter = 0;
        foreach ($files as $file) {
            // Generate unique filename
            $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();
            
            // Store file in storage
            $path = $file->storeAs(
                'housing_photos/' . $housingPost->id,
                $filename,
                'public'
            );
            
            // Create photo record
            $photo = new HousingPhoto([
                'housing_post_id' => $housingPost->id,
                'file_path' => 'public/' . $path,
                'file_name' => $file->getClientOriginalName(),
                'caption' => null,
                'is_primary' => ($counter === 0), // First photo is primary
                'sort_order' => $counter,
                'mime_type' => $file->getMimeType(),
                'file_size' => $file->getSize(),
            ]);
            
            $photo->save();
            $counter++;
        }
    }
}
