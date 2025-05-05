<?php include(__DIR__ . '/../../partials/head.php'); ?>
<?php include(__DIR__ . '/../../partials/nav.php'); ?>

<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <h1 class="text-3xl font-bold text-center text-indigo-700 mb-8">Edit Your Review</h1>
        
        <div class="bg-white p-6 rounded-lg shadow-lg mb-8">
            <div class="flex items-center mb-6">
                <img src="<?= $housingPost->primaryPhoto() ? $housingPost->primaryPhoto()->getUrlAttribute() : '/images/placeholder-housing.jpg' ?>"
                     alt="<?= $housingPost->title ?>"
                     class="w-24 h-24 object-cover rounded-md mr-4">
                <div>
                    <h2 class="text-xl font-semibold"><?= $housingPost->title ?></h2>
                    <p class="text-gray-600"><?= $housingPost->location ?></p>
                    <p class="text-gray-600">$<?= number_format($housingPost->rent_amount, 2) ?> per month</p>
                </div>
            </div>
            
            <form action="/housing/reviews/<?= $review->id ?>" method="POST" class="space-y-6">
                <?= csrf_field() ?>
                
                <div class="space-y-4">
                    <h3 class="text-lg font-semibold">Rate Your Experience (1-5 stars)</h3>
                    
                    <div class="grid md:grid-cols-3 gap-4">
                        <div>
                            <label for="cleanliness_rating" class="block text-sm font-medium text-gray-700 mb-1">Cleanliness</label>
                            <div class="flex space-x-2">
                                <?php for ($i = 1; $i <= 5; $i++): ?>
                                <label class="rating-label">
                                    <input type="radio" name="cleanliness_rating" value="<?= $i ?>" required class="hidden peer" <?= $review->cleanliness_rating == $i ? 'checked' : '' ?>>
                                    <span class="rating-star text-2xl cursor-pointer <?= $review->cleanliness_rating == $i ? 'text-yellow-400' : 'text-gray-300' ?> peer-checked:text-yellow-400">★</span>
                                </label>
                                <?php endfor; ?>
                            </div>
                        </div>
                        
                        <div>
                            <label for="location_rating" class="block text-sm font-medium text-gray-700 mb-1">Location</label>
                            <div class="flex space-x-2">
                                <?php for ($i = 1; $i <= 5; $i++): ?>
                                <label class="rating-label">
                                    <input type="radio" name="location_rating" value="<?= $i ?>" required class="hidden peer" <?= $review->location_rating == $i ? 'checked' : '' ?>>
                                    <span class="rating-star text-2xl cursor-pointer <?= $review->location_rating == $i ? 'text-yellow-400' : 'text-gray-300' ?> peer-checked:text-yellow-400">★</span>
                                </label>
                                <?php endfor; ?>
                            </div>
                        </div>
                        
                        <div>
                            <label for="value_rating" class="block text-sm font-medium text-gray-700 mb-1">Value for Money</label>
                            <div class="flex space-x-2">
                                <?php for ($i = 1; $i <= 5; $i++): ?>
                                <label class="rating-label">
                                    <input type="radio" name="value_rating" value="<?= $i ?>" required class="hidden peer" <?= $review->value_rating == $i ? 'checked' : '' ?>>
                                    <span class="rating-star text-2xl cursor-pointer <?= $review->value_rating == $i ? 'text-yellow-400' : 'text-gray-300' ?> peer-checked:text-yellow-400">★</span>
                                </label>
                                <?php endfor; ?>
                            </div>
                        </div>
                    </div>
                    
                    <div class="grid md:grid-cols-2 gap-4">
                        <div>
                            <label for="landlord_rating" class="block text-sm font-medium text-gray-700 mb-1">Landlord/Management</label>
                            <div class="flex space-x-2">
                                <?php for ($i = 1; $i <= 5; $i++): ?>
                                <label class="rating-label">
                                    <input type="radio" name="landlord_rating" value="<?= $i ?>" required class="hidden peer" <?= $review->landlord_rating == $i ? 'checked' : '' ?>>
                                    <span class="rating-star text-2xl cursor-pointer <?= $review->landlord_rating == $i ? 'text-yellow-400' : 'text-gray-300' ?> peer-checked:text-yellow-400">★</span>
                                </label>
                                <?php endfor; ?>
                            </div>
                        </div>
                        
                        <div>
                            <label for="safety_rating" class="block text-sm font-medium text-gray-700 mb-1">Safety</label>
                            <div class="flex space-x-2">
                                <?php for ($i = 1; $i <= 5; $i++): ?>
                                <label class="rating-label">
                                    <input type="radio" name="safety_rating" value="<?= $i ?>" required class="hidden peer" <?= $review->safety_rating == $i ? 'checked' : '' ?>>
                                    <span class="rating-star text-2xl cursor-pointer <?= $review->safety_rating == $i ? 'text-yellow-400' : 'text-gray-300' ?> peer-checked:text-yellow-400">★</span>
                                </label>
                                <?php endfor; ?>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div>
                    <label for="review_text" class="block text-sm font-medium text-gray-700 mb-1">Write Your Review</label>
                    <textarea name="review_text" id="review_text" rows="5" 
                              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500"
                              required minlength="10"
                              placeholder="Share details about your experience at this property..."><?= htmlspecialchars($review->review_text) ?></textarea>
                </div>
                
                <div class="grid md:grid-cols-2 gap-4">
                    <div>
                        <label for="stay_start_date" class="block text-sm font-medium text-gray-700 mb-1">When did you move in? (Optional)</label>
                        <input type="date" name="stay_start_date" id="stay_start_date"
                               value="<?= $review->stay_start_date ? date('Y-m-d', strtotime($review->stay_start_date)) : '' ?>"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    </div>
                    
                    <div>
                        <label for="stay_end_date" class="block text-sm font-medium text-gray-700 mb-1">When did you move out? (Optional)</label>
                        <input type="date" name="stay_end_date" id="stay_end_date"
                               value="<?= $review->stay_end_date ? date('Y-m-d', strtotime($review->stay_end_date)) : '' ?>"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    </div>
                </div>
                
                <div class="flex items-center">
                    <input type="checkbox" name="anonymous" id="anonymous" <?= $review->anonymous ? 'checked' : '' ?>
                           class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                    <label for="anonymous" class="ml-2 block text-sm text-gray-700">Submit this review anonymously</label>
                </div>
                
                <div class="flex justify-between">
                    <a href="/housing/<?= $housingPost->id ?>" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300">Cancel</a>
                    <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">Update Review</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // JavaScript for star rating system
    document.addEventListener('DOMContentLoaded', function() {
        const ratingLabels = document.querySelectorAll('.rating-label');
        
        ratingLabels.forEach(label => {
            label.addEventListener('mouseover', function() {
                const stars = this.parentElement.querySelectorAll('.rating-star');
                const value = this.querySelector('input').value;
                
                stars.forEach((star, index) => {
                    if (index < value) {
                        star.classList.add('text-yellow-400');
                        star.classList.remove('text-gray-300');
                    } else {
                        star.classList.add('text-gray-300');
                        star.classList.remove('text-yellow-400');
                    }
                });
            });
            
            label.addEventListener('mouseout', function() {
                const stars = this.parentElement.querySelectorAll('.rating-star');
                const checkedInput = this.parentElement.querySelector('input:checked');
                
                if (!checkedInput) {
                    stars.forEach(star => {
                        star.classList.add('text-gray-300');
                        star.classList.remove('text-yellow-400');
                    });
                } else {
                    const value = checkedInput.value;
                    
                    stars.forEach((star, index) => {
                        if (index < value) {
                            star.classList.add('text-yellow-400');
                            star.classList.remove('text-gray-300');
                        } else {
                            star.classList.add('text-gray-300');
                            star.classList.remove('text-yellow-400');
                        }
                    });
                }
            });
        });
    });
</script>

<?php include(__DIR__ . '/../../partials/tail.php'); ?>