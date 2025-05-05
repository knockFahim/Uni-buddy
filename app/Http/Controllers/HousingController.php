<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\HousingPost;
use Illuminate\Support\Facades\Auth;

class HousingController extends Controller
{
    /**
     * Display a listing of the resource.
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
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $housingPost = HousingPost::with(['user', 'photos', 'approvedReviews.user'])
            ->findOrFail($id);
            
        // Check if current user has already reviewed this property
        $userHasReviewed = false;
        
        if (Auth::check()) {
            $userHasReviewed = $housingPost->reviews()
                ->where('user_id', Auth::id())
                ->exists();
        }
        
        return view('housing.show', [
            'housingPost' => $housingPost,
            'userHasReviewed' => $userHasReviewed
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
