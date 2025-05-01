<?php

namespace App\Http\Controllers;

use App\Models\RoommatePreference;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoommatePreferenceController extends Controller
{
    /**
     * Display the current user's roommate preferences.
     */
    public function show()
    {
        $preferences = RoommatePreference::firstOrNew(['user_id' => Auth::id()]);
        return view('housing.preferences.show', ['preferences' => $preferences]);
    }
    
    /**
     * Show the form for creating/editing roommate preferences.
     */
    public function edit()
    {
        $preferences = RoommatePreference::firstOrNew(['user_id' => Auth::id()]);
        return view('housing.preferences.edit', ['preferences' => $preferences]);
    }
    
    /**
     * Update or create the roommate preferences.
     */
    public function update(Request $request)
    {
        $validated = $request->validate([
            'gender_preference' => 'nullable|string|in:male,female,any',
            'smoking_preference' => 'nullable|string|in:yes,no,outdoors_only,indifferent',
            'pets_preference' => 'nullable|string|in:yes,no,small_only,indifferent',
            'min_age' => 'nullable|integer|min:18|max:100',
            'max_age' => 'nullable|integer|min:18|max:100|gte:min_age',
            'studying_habits' => 'nullable|string|in:quiet,moderate,noisy,indifferent',
            'sleeping_habits' => 'nullable|string|in:early_riser,night_owl,indifferent',
            'cleanliness_level' => 'nullable|integer|min:1|max:5',
            'social_level' => 'nullable|integer|min:1|max:5',
            'shared_items' => 'nullable|array',
            'shared_items.*' => 'string',
            'additional_notes' => 'nullable|string|max:1000',
            'has_roommate_preferences' => 'boolean',
        ]);
        
        // Convert checkboxes to boolean
        $validated['has_roommate_preferences'] = isset($validated['has_roommate_preferences']);
        
        // Convert shared items array to JSON
        if (isset($validated['shared_items'])) {
            $validated['shared_items'] = json_encode($validated['shared_items']);
        }
        
        // Update or create preferences
        RoommatePreference::updateOrCreate(
            ['user_id' => Auth::id()],
            $validated
        );
        
        return redirect()->route('roommate.preferences')
            ->with('success', 'Your roommate preferences have been updated successfully.');
    }
    
    /**
     * Find matching roommates based on preferences.
     */
    public function findMatches()
    {
        $userId = Auth::id();
        $userPreferences = RoommatePreference::where('user_id', $userId)->first();
        
        if (!$userPreferences || !$userPreferences->has_roommate_preferences) {
            return redirect()->route('roommate.preferences.edit')
                ->with('info', 'Please set your roommate preferences first to find matches.');
        }
        
        // Find potential matches based on preferences
        $matches = RoommatePreference::findPotentialMatches($userId);
        
        return view('housing.preferences.matches', [
            'matches' => $matches,
            'userPreferences' => $userPreferences
        ]);
    }
}