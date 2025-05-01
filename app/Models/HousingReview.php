<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HousingReview extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'housing_post_id',
        'user_id',
        'cleanliness_rating',
        'location_rating',
        'value_rating',
        'landlord_rating',
        'safety_rating',
        'overall_rating',
        'review_text',
        'is_approved',
        'anonymous',
        'stay_start_date',
        'stay_end_date',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'cleanliness_rating' => 'integer',
        'location_rating' => 'integer',
        'value_rating' => 'integer',
        'landlord_rating' => 'integer',
        'safety_rating' => 'integer',
        'overall_rating' => 'decimal:1',
        'is_approved' => 'boolean',
        'anonymous' => 'boolean',
        'stay_start_date' => 'datetime',
        'stay_end_date' => 'datetime',
    ];

    /**
     * Get the housing post that this review belongs to.
     */
    public function housingPost(): BelongsTo
    {
        return $this->belongsTo(HousingPost::class);
    }

    /**
     * Get the user who wrote the review.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Calculate the overall rating based on all the individual ratings.
     */
    public function calculateOverallRating()
    {
        $total = 0;
        $count = 0;
        
        $ratings = [
            $this->cleanliness_rating,
            $this->location_rating,
            $this->value_rating,
            $this->landlord_rating,
            $this->safety_rating
        ];
        
        foreach ($ratings as $rating) {
            if ($rating > 0) {
                $total += $rating;
                $count++;
            }
        }
        
        return $count > 0 ? round($total / $count, 1) : 0;
    }
    
    /**
     * Set the overall rating before saving.
     */
    protected static function boot()
    {
        parent::boot();
        
        static::saving(function ($review) {
            $review->overall_rating = $review->calculateOverallRating();
        });
        
        static::saved(function ($review) {
            // Update the average rating on the housing post
            $review->housingPost->updateAverageRating();
        });
    }
}
