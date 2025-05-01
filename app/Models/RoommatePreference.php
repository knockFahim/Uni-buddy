<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RoommatePreference extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'user_id',
        'preferred_gender',
        'smoking_allowed',
        'pets_allowed',
        'budget_min',
        'budget_max',
        'preferred_location',
        'early_bird',
        'partying',
        'quiet_study',
        'additional_preferences',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'smoking_allowed' => 'boolean',
        'pets_allowed' => 'boolean',
        'early_bird' => 'boolean',
        'partying' => 'boolean',
        'quiet_study' => 'boolean',
        'budget_min' => 'decimal:2',
        'budget_max' => 'decimal:2',
    ];

    /**
     * Get the user that owns the roommate preferences.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Find compatible roommates based on preferences.
     *
     * @param int $userId
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public static function findCompatibleRoommates(int $userId)
    {
        $userPreferences = self::where('user_id', $userId)->first();
        
        if (!$userPreferences) {
            return User::where('id', '!=', $userId)->get();
        }
        
        // Start with all users except the current one
        $query = User::where('id', '!=', $userId);
        
        // Join with their preferences
        $query->leftJoin('roommate_preferences', 'users.id', '=', 'roommate_preferences.user_id');
        
        // Budget compatibility (if specified)
        if ($userPreferences->budget_min) {
            $query->where(function($q) use ($userPreferences) {
                $q->whereNull('roommate_preferences.budget_max')
                  ->orWhere('roommate_preferences.budget_max', '>=', $userPreferences->budget_min);
            });
        }
        
        if ($userPreferences->budget_max) {
            $query->where(function($q) use ($userPreferences) {
                $q->whereNull('roommate_preferences.budget_min')
                  ->orWhere('roommate_preferences.budget_min', '<=', $userPreferences->budget_max);
            });
        }
        
        // Gender preference compatibility
        if ($userPreferences->preferred_gender !== 'any') {
            // Only match with users who are okay with the current user's gender or 'any'
            $query->where(function($q) use ($userPreferences) {
                $q->whereNull('roommate_preferences.preferred_gender')
                  ->orWhere('roommate_preferences.preferred_gender', '=', 'any');
                  // This would also need to check against the current user's gender
            });
        }
        
        // Location preference (if specified)
        if ($userPreferences->preferred_location) {
            $query->where(function($q) use ($userPreferences) {
                $q->whereNull('roommate_preferences.preferred_location')
                  ->orWhere('roommate_preferences.preferred_location', 'like', '%' . $userPreferences->preferred_location . '%');
            });
        }
        
        // Get distinct users with their preference data
        return $query->select('users.*')->distinct()->get();
    }
}
