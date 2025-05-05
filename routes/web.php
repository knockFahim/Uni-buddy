<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ThesisPostController;
use App\Http\Controllers\ThesisRequestController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\HousingPostController;
use App\Http\Controllers\HousingPhotoController;
use App\Http\Controllers\HousingReviewController;
use App\Http\Controllers\RoommatePreferenceController;

Route::get('/thesis', [ThesisPostController::class, 'index']);
Route::get('/thesis/create', [ThesisPostController::class, 'create']);
Route::post('/thesis', [ThesisPostController::class, 'store']);
Route::get('/thesis/my-posts', [ThesisPostController::class, 'myPosts']);
Route::get('/thesis/edit/{id}', [ThesisPostController::class, 'edit']);
Route::post('/thesis/update/{id}', [ThesisPostController::class, 'update']);
Route::delete('/thesis/delete/{id}', [ThesisPostController::class, 'destroy']);

Route::post('/thesis/request/{id}', [ThesisRequestController::class, 'sendRequest']);
Route::get('/thesis/requests', [ThesisRequestController::class, 'myReceivedRequests']);

// Housing Routes
Route::get('/housing', [HousingPostController::class, 'index'])->name('housing.index');

// Routes that require authentication
Route::middleware(['auth'])->group(function () {
    Route::get('/housing/create', [HousingPostController::class, 'create'])->name('housing.create');
    Route::post('/housing', [HousingPostController::class, 'store'])->name('housing.store');
    Route::get('/housing/my-posts', [HousingPostController::class, 'myHousingPosts'])->name('housing.my-posts');
    Route::get('/housing/{id}/edit', [HousingPostController::class, 'edit'])->name('housing.edit');
    Route::post('/housing/{id}', [HousingPostController::class, 'update'])->name('housing.update');
    Route::delete('/housing/{id}', [HousingPostController::class, 'destroy'])->name('housing.destroy');
    Route::get('/housing/matches', [HousingPostController::class, 'findMatches'])->name('housing.matches');
    Route::post('/housing/{id}/toggle-status', [HousingPostController::class, 'toggleStatus'])->name('housing.toggle-status');
    
    // Housing Photos Routes
    Route::post('/housing/{id}/photos', [HousingPhotoController::class, 'upload'])->name('housing.photos.upload');
    Route::post('/housing/photos/{id}/primary', [HousingPhotoController::class, 'setPrimary'])->name('housing.photos.primary');
    Route::delete('/housing/photos/{id}', [HousingPhotoController::class, 'destroy'])->name('housing.photos.destroy');
    
    // Housing Reviews Routes that require auth
    Route::get('/housing/{id}/reviews/create', [HousingReviewController::class, 'create'])->name('housing.reviews.create');
    Route::post('/housing/{id}/reviews', [HousingReviewController::class, 'store'])->name('housing.reviews.store');
    Route::get('/housing/{id}/reviews/{reviewId}/edit', [HousingReviewController::class, 'edit'])->name('housing.reviews.edit');
    // New route for the URL pattern that's being used in views
    Route::get('/housing/reviews/{id}/edit', [HousingReviewController::class, 'editReview'])->name('housing.reviews.edit.alt');
    Route::post('/housing/reviews/{id}', [HousingReviewController::class, 'update'])->name('housing.reviews.update');
    Route::delete('/housing/reviews/{id}', [HousingReviewController::class, 'destroy'])->name('housing.reviews.destroy');
    Route::post('/housing/reviews/{id}/vote', [HousingReviewController::class, 'vote'])->name('housing.reviews.vote');
    Route::get('/housing/my-reviews', [HousingReviewController::class, 'userReviews'])->name('housing.reviews.my-reviews');
    
    // Roommate Preferences Routes
    Route::get('/roommate/preferences', [RoommatePreferenceController::class, 'show'])->name('roommate.preferences');
    Route::get('/roommate/preferences/edit', [RoommatePreferenceController::class, 'edit'])->name('roommate.preferences.edit');
    Route::post('/roommate/preferences', [RoommatePreferenceController::class, 'update'])->name('roommate.preferences.update');
    Route::get('/roommate/matches', [RoommatePreferenceController::class, 'findMatches'])->name('roommate.matches');
});

// Public housing routes
Route::get('/housing/{id}', [HousingPostController::class, 'show'])->name('housing.show');
Route::get('/housing/{id}/reviews', [HousingReviewController::class, 'showForHousing'])->name('housing.reviews.index');

// Admin Routes
Route::middleware([\App\Http\Middleware\AdminMiddleware::class])->group(function () {
    Route::get('/admin', function () {
        return view('admin.index');
    })->name('admin.dashboard');
    
    // Admin Housing Review Routes
    Route::get('/admin/housing/reviews/moderation', [HousingReviewController::class, 'moderationQueue'])->name('admin.housing.reviews.moderation');
    Route::post('/admin/housing/reviews/{id}/moderate', [HousingReviewController::class, 'moderate'])->name('admin.housing.reviews.moderate');
});

// Login
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);

// Logout
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Register
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);