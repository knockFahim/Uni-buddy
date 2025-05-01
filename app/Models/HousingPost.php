<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\DB;

class HousingPost extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'location',
        'rent_amount',
        'bedrooms',
        'bathrooms',
        'description',
        'is_available',
        'contact_phone',
        'property_type',
        'utilities_included',
        'available_from',
    ];

    protected $casts = [
        'rent_amount' => 'decimal:2',
        'bedrooms' => 'integer',
        'bathrooms' => 'float',
        'is_available' => 'boolean',
        'utilities_included' => 'boolean',
        'available_from' => 'date',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function photos(): HasMany
    {
        return $this->hasMany(HousingPhoto::class);
    }

    public function primaryPhoto()
    {
        return $this->photos()->where('is_primary', true)->first();
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(HousingReview::class);
    }

    public function approvedReviews()
    {
        return $this->reviews()->where('is_approved', true);
    }

    public function updateAverageRating()
    {
        return $this->avgRating;
    }

    public function getAvgRatingAttribute()
    {
        return $this->approvedReviews()
            ->avg('overall_rating') ?? 0;
    }

    public function getReviewsCountAttribute()
    {
        return $this->approvedReviews()->count();
    }

    public function scopeAvailable($query)
    {
        return $query->where('is_available', true);
    }

    public function scopeFilter($query, array $filters)
    {
        if (isset($filters['min_price'])) {
            $query->where('rent_amount', '>=', $filters['min_price']);
        }

        if (isset($filters['max_price'])) {
            $query->where('rent_amount', '<=', $filters['max_price']);
        }

        if (isset($filters['property_type']) && !empty($filters['property_type'])) {
            $query->whereIn('property_type', (array)$filters['property_type']);
        }

        if (isset($filters['bedrooms']) && !empty($filters['bedrooms'])) {
            $query->where('bedrooms', '>=', $filters['bedrooms']);
        }

        if (isset($filters['bathrooms']) && !empty($filters['bathrooms'])) {
            $query->where('bathrooms', '>=', $filters['bathrooms']);
        }

        if (isset($filters['location']) && !empty($filters['location'])) {
            $query->where('location', 'like', '%' . $filters['location'] . '%');
        }

        if (isset($filters['available_from']) && !empty($filters['available_from'])) {
            $query->where('available_from', '<=', $filters['available_from']);
        }

        if (isset($filters['utilities_included'])) {
            $query->where('utilities_included', $filters['utilities_included']);
        }

        return $query;
    }

    public static function findMatchingHousing(int $userId)
    {
        $preferences = RoommatePreference::where('user_id', $userId)->first();

        if (!$preferences) {
            return self::available()->latest()->get();
        }

        $query = self::available();

        if ($preferences->budget_max) {
            $query->where('rent_amount', '<=', $preferences->budget_max);
        }

        if ($preferences->preferred_location) {
            $query->where('location', 'like', '%' . $preferences->preferred_location . '%');
        }

        return $query->latest()->get();
    }
}
