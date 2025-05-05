<?php

namespace App\Http\Controllers;

use App\Models\HousingPost;
use App\Models\HousingReview;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HousingReviewController extends Controller
{
    /**
     * Show the form for creating a new review for a housing post.
     */
    public function create($housingId)
    {
        $housingPost = HousingPost::findOrFail($housingId);
        
        // Check if user has already reviewed this property
        $existingReview = HousingReview::where('housing_post_id', $housingId)
            ->where('user_id', Auth::id())
            ->first();
            
        if ($existingReview) {
            return redirect()->route('housing.reviews.edit', $existingReview->id)
                ->with('info', 'You have already reviewed this property. You can edit your review below.');
        }
        
        return view('housing.reviews.create', [
            'housingPost' => $housingPost,
        ]);
    }

    /**
     * Submit a review for a housing post.
     */
    public function store(Request $request, $housingId)
    {
        // Validate the housing post exists
        $housing = HousingPost::findOrFail($housingId);
        
        // Validate that user hasn't already reviewed this housing
        $existingReview = HousingReview::where('housing_post_id', $housingId)
            ->where('user_id', Auth::id())
            ->first();
            
        if ($existingReview) {
            return redirect()->route('housing.show', $housingId)
                ->with('error', 'You have already submitted a review for this property.');
        }
        
        // Validate input
        $validated = $request->validate([
            'cleanliness_rating' => 'required|integer|min:1|max:5',
            'location_rating' => 'required|integer|min:1|max:5',
            'value_rating' => 'required|integer|min:1|max:5',
            'landlord_rating' => 'required|integer|min:1|max:5',
            'safety_rating' => 'required|integer|min:1|max:5',
            'review_text' => 'required|string|min:10|max:1000',
            'anonymous' => 'boolean',
            'stay_start_date' => 'nullable|date',
            'stay_end_date' => 'nullable|date|after_or_equal:stay_start_date',
        ]);
        
        // Calculate overall rating
        $ratings = [
            $validated['cleanliness_rating'],
            $validated['location_rating'],
            $validated['value_rating'],
            $validated['landlord_rating'],
            $validated['safety_rating']
        ];
        $overallRating = round(array_sum($ratings) / count($ratings), 1);
        
        // Create review
        $review = new HousingReview([
            'housing_post_id' => $housingId,
            'user_id' => Auth::id(),
            'cleanliness_rating' => $validated['cleanliness_rating'],
            'location_rating' => $validated['location_rating'],
            'value_rating' => $validated['value_rating'],
            'landlord_rating' => $validated['landlord_rating'],
            'safety_rating' => $validated['safety_rating'],
            'overall_rating' => $overallRating,
            'review_text' => $validated['review_text'],
            'anonymous' => isset($validated['anonymous']),
            'stay_start_date' => $validated['stay_start_date'] ?? null,
            'stay_end_date' => $validated['stay_end_date'] ?? null,
            'is_approved' => false, // Require moderation for reviews
            'helpful_votes' => 0,
            'unhelpful_votes' => 0,
        ]);
        
        $review->save();
        
        return redirect()->route('housing.show', $housingId)
            ->with('success', 'Thank you for your review! It will be visible after moderation.');
    }

    /**
     * Show the form for editing a review.
     */
    public function edit($housingId, $reviewId)
    {
        $review = HousingReview::findOrFail($reviewId);
        
        // Check if review belongs to the right housing post
        if ($review->housing_post_id != $housingId) {
            abort(404, 'Review not found for this housing post.');
        }
        
        // Check if current user owns this review
        if ($review->user_id !== Auth::id()) {
            abort(403, 'You cannot edit someone else\'s review.');
        }
        
        return view('housing.reviews.edit', [
            'review' => $review,
            'housingPost' => $review->housingPost,
        ]);
    }

    /**
     * Show the form for editing a review (alternate URL pattern).
     * This handles the /housing/reviews/{id}/edit URL pattern.
     */
    public function editReview($reviewId)
    {
        $review = HousingReview::findOrFail($reviewId);
        
        // Check if current user owns this review
        if ($review->user_id !== Auth::id() && !Auth::user()->is_admin) {
            abort(403, 'You cannot edit someone else\'s review.');
        }
        
        return view('housing.reviews.edit', [
            'review' => $review,
            'housingPost' => $review->housingPost,
        ]);
    }

    /**
     * Update a review.
     */
    public function update(Request $request, $reviewId)
    {
        $review = HousingReview::findOrFail($reviewId);
        
        // Check if current user owns this review
        if ($review->user_id !== Auth::id()) {
            abort(403, 'You cannot edit someone else\'s review.');
        }
        
        $validated = $request->validate([
            'cleanliness_rating' => 'required|integer|min:1|max:5',
            'location_rating' => 'required|integer|min:1|max:5',
            'value_rating' => 'required|integer|min:1|max:5',
            'landlord_rating' => 'required|integer|min:1|max:5',
            'safety_rating' => 'required|integer|min:1|max:5',
            'review_text' => 'required|string|min:10',
            'anonymous' => 'boolean',
            'stay_start_date' => 'nullable|date',
            'stay_end_date' => 'nullable|date|after_or_equal:stay_start_date',
        ]);
        
        // Update the boolean field
        $validated['anonymous'] = isset($validated['anonymous']);
        
        $review->update($validated);
        
        return redirect()->route('housing.show', $review->housing_post_id)
            ->with('success', 'Your review has been updated successfully.');
    }

    /**
     * Delete a review.
     */
    public function destroy($reviewId)
    {
        $review = HousingReview::findOrFail($reviewId);
        
        // Check if current user owns this review
        if ($review->user_id !== Auth::id() && !Auth::user()->is_admin) {
            abort(403, 'You cannot delete someone else\'s review.');
        }
        
        $housingId = $review->housing_post_id;
        $review->delete();
        
        return redirect()->route('housing.show', $housingId)
            ->with('success', 'Review deleted successfully.');
    }
    
    /**
     * Display reviews for a specific housing post.
     */
    public function showForHousing($housingId)
    {
        $housingPost = HousingPost::with(['approvedReviews.user'])->findOrFail($housingId);
        
        return view('housing.reviews.index', [
            'housingPost' => $housingPost,
            'reviews' => $housingPost->approvedReviews,
        ]);
    }

    /**
     * Update the helpful/unhelpful votes for a review.
     */
    public function vote(Request $request, $reviewId)
    {
        $validated = $request->validate([
            'vote_type' => 'required|string|in:helpful,unhelpful',
        ]);
        
        $review = HousingReview::findOrFail($reviewId);
        
        if ($validated['vote_type'] === 'helpful') {
            $review->increment('helpful_votes');
        } else {
            $review->increment('unhelpful_votes');
        }
        
        return response()->json([
            'success' => true,
            'helpful_votes' => $review->helpful_votes,
            'unhelpful_votes' => $review->unhelpful_votes
        ]);
    }
    
    /**
     * Admin: List reviews that need moderation.
     */
    public function moderationQueue()
    {
        // Check if user is admin
        if (!Auth::user()->is_admin) {
            abort(403, 'Unauthorized');
        }
        
        $pendingReviews = HousingReview::with(['user', 'housingPost'])
            ->where('is_approved', false)
            ->orderBy('created_at')
            ->paginate(20);
            
        return view('admin.housing.review-moderation', [
            'reviews' => $pendingReviews
        ]);
    }
    
    /**
     * Admin: Approve or reject a review.
     */
    public function moderate(Request $request, $reviewId)
    {
        // Check if user is admin
        if (!Auth::user()->is_admin) {
            abort(403, 'Unauthorized');
        }
        
        $validated = $request->validate([
            'action' => 'required|string|in:approve,reject',
            'rejection_reason' => 'required_if:action,reject|nullable|string|max:500',
        ]);
        
        $review = HousingReview::findOrFail($reviewId);
        
        if ($validated['action'] === 'approve') {
            $review->update([
                'is_approved' => true,
                'moderated_at' => now(),
                'moderated_by' => Auth::id(),
            ]);
            
            $message = 'Review approved and now visible to users.';
        } else {
            // Delete the review if rejected
            $review->delete();
            
            // Could also implement a notification to the user here
            // about why their review was rejected
            
            $message = 'Review rejected and removed from the system.';
        }
        
        return redirect()->route('admin.housing.reviews.moderation')
            ->with('success', $message);
    }
    
    /**
     * Get a user's review history.
     */
    public function userReviews()
    {
        $reviews = HousingReview::with('housingPost')
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();
            
        return view('housing.reviews.my-reviews', [
            'reviews' => $reviews
        ]);
    }
}