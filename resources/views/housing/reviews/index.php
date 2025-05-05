<?php include(__DIR__ . '/../../partials/head.php'); ?>
<?php include(__DIR__ . '/../../partials/nav.php'); ?>

<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <h1 class="text-3xl font-bold text-center text-indigo-700 mb-8">Reviews for "<?= $housingPost->title ?>"</h1>
        
        <div class="bg-white p-6 rounded-lg shadow-lg mb-8">
            <div class="flex flex-col md:flex-row items-center mb-6">
                <img src="<?= $housingPost->primaryPhoto() ? $housingPost->primaryPhoto()->getUrlAttribute() : '/images/placeholder-housing.jpg' ?>"
                     alt="<?= $housingPost->title ?>"
                     class="w-24 h-24 object-cover rounded-md mr-4 mb-4 md:mb-0">
                <div>
                    <h2 class="text-xl font-semibold"><?= $housingPost->title ?></h2>
                    <p class="text-gray-600"><?= $housingPost->location ?></p>
                    <p class="text-gray-600">$<?= number_format($housingPost->rent_amount, 2) ?> per month</p>
                    <div class="mt-2">
                        <a href="/housing/<?= $housingPost->id ?>" class="text-indigo-600 hover:underline">Back to listing</a>
                    </div>
                </div>
                <div class="ml-auto text-center">
                    <div class="text-4xl font-bold text-indigo-600"><?= number_format($housingPost->avgRating, 1) ?></div>
                    <div class="flex justify-center">
                        <?php for ($i = 1; $i <= 5; $i++): ?>
                            <?php if ($i <= round($housingPost->avgRating)): ?>
                                <span class="text-yellow-400 text-xl">★</span>
                            <?php else: ?>
                                <span class="text-gray-300 text-xl">★</span>
                            <?php endif; ?>
                        <?php endfor; ?>
                    </div>
                    <div class="text-gray-500 text-sm mt-1"><?= $housingPost->reviewsCount ?> reviews</div>
                </div>
            </div>
            
            <hr class="my-6">
            
            <div class="grid grid-cols-2 md:grid-cols-5 gap-4 mb-6">
                <div class="text-center">
                    <div class="text-sm text-gray-600">Cleanliness</div>
                    <div class="font-semibold"><?= number_format($reviews->avg('cleanliness_rating'), 1) ?></div>
                    <div class="flex justify-center">
                        <?php for ($i = 1; $i <= 5; $i++): ?>
                            <?php if ($i <= round($reviews->avg('cleanliness_rating'))): ?>
                                <span class="text-yellow-400 text-sm">★</span>
                            <?php else: ?>
                                <span class="text-gray-300 text-sm">★</span>
                            <?php endif; ?>
                        <?php endfor; ?>
                    </div>
                </div>
                
                <div class="text-center">
                    <div class="text-sm text-gray-600">Location</div>
                    <div class="font-semibold"><?= number_format($reviews->avg('location_rating'), 1) ?></div>
                    <div class="flex justify-center">
                        <?php for ($i = 1; $i <= 5; $i++): ?>
                            <?php if ($i <= round($reviews->avg('location_rating'))): ?>
                                <span class="text-yellow-400 text-sm">★</span>
                            <?php else: ?>
                                <span class="text-gray-300 text-sm">★</span>
                            <?php endif; ?>
                        <?php endfor; ?>
                    </div>
                </div>
                
                <div class="text-center">
                    <div class="text-sm text-gray-600">Value</div>
                    <div class="font-semibold"><?= number_format($reviews->avg('value_rating'), 1) ?></div>
                    <div class="flex justify-center">
                        <?php for ($i = 1; $i <= 5; $i++): ?>
                            <?php if ($i <= round($reviews->avg('value_rating'))): ?>
                                <span class="text-yellow-400 text-sm">★</span>
                            <?php else: ?>
                                <span class="text-gray-300 text-sm">★</span>
                            <?php endif; ?>
                        <?php endfor; ?>
                    </div>
                </div>
                
                <div class="text-center">
                    <div class="text-sm text-gray-600">Landlord</div>
                    <div class="font-semibold"><?= number_format($reviews->avg('landlord_rating'), 1) ?></div>
                    <div class="flex justify-center">
                        <?php for ($i = 1; $i <= 5; $i++): ?>
                            <?php if ($i <= round($reviews->avg('landlord_rating'))): ?>
                                <span class="text-yellow-400 text-sm">★</span>
                            <?php else: ?>
                                <span class="text-gray-300 text-sm">★</span>
                            <?php endif; ?>
                        <?php endfor; ?>
                    </div>
                </div>
                
                <div class="text-center">
                    <div class="text-sm text-gray-600">Safety</div>
                    <div class="font-semibold"><?= number_format($reviews->avg('safety_rating'), 1) ?></div>
                    <div class="flex justify-center">
                        <?php for ($i = 1; $i <= 5; $i++): ?>
                            <?php if ($i <= round($reviews->avg('safety_rating'))): ?>
                                <span class="text-yellow-400 text-sm">★</span>
                            <?php else: ?>
                                <span class="text-gray-300 text-sm">★</span>
                            <?php endif; ?>
                        <?php endfor; ?>
                    </div>
                </div>
            </div>
        </div>
        
        <?php if (count($reviews) > 0): ?>
            <div class="space-y-6">
                <?php foreach ($reviews as $review): ?>
                    <div class="bg-white p-6 rounded-lg shadow-lg">
                        <div class="flex justify-between items-start">
                            <div>
                                <div class="flex items-center mb-2">
                                    <div class="flex mr-2">
                                        <?php for ($i = 1; $i <= 5; $i++): ?>
                                            <?php if ($i <= $review->overall_rating): ?>
                                                <span class="text-yellow-400">★</span>
                                            <?php else: ?>
                                                <span class="text-gray-300">★</span>
                                            <?php endif; ?>
                                        <?php endfor; ?>
                                    </div>
                                    <span class="text-gray-600 text-sm"><?= number_format($review->overall_rating, 1) ?>/5.0</span>
                                </div>
                                
                                <div class="font-semibold">
                                    <?php if ($review->anonymous): ?>
                                        Anonymous
                                    <?php else: ?>
                                        <?= $review->user->name ?>
                                    <?php endif; ?>
                                </div>
                                
                                <?php if ($review->stay_start_date): ?>
                                    <div class="text-sm text-gray-600">
                                        Stayed: <?= date('M Y', strtotime($review->stay_start_date)) ?> - 
                                        <?= $review->stay_end_date ? date('M Y', strtotime($review->stay_end_date)) : 'Present' ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                            
                            <div class="text-sm text-gray-500">
                                <?= date('M d, Y', strtotime($review->created_at)) ?>
                            </div>
                        </div>
                        
                        <div class="mt-4">
                            <p class="text-gray-700"><?= nl2br(htmlspecialchars($review->review_text)) ?></p>
                        </div>
                        
                        <div class="mt-4 flex justify-between items-center">
                            <div class="flex items-center space-x-4">
                                <button class="vote-btn flex items-center space-x-1 text-sm text-gray-600 hover:text-indigo-600" 
                                        data-review-id="<?= $review->id ?>" 
                                        data-vote-type="helpful">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905V19c0 .5.405.905.905.905h.095a2 2 0 002-2v-9m0 0h-3"></path>
                                    </svg>
                                    <span>Helpful</span>
                                    <span class="helpful-count">(<?= $review->helpful_votes ?? 0 ?>)</span>
                                </button>
                                
                                <button class="vote-btn flex items-center space-x-1 text-sm text-gray-600 hover:text-indigo-600"
                                        data-review-id="<?= $review->id ?>" 
                                        data-vote-type="unhelpful">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14H5.236a2 2 0 01-1.789-2.894l3.5-7A2 2 0 018.736 3h4.018a2 2 0 01.485.06l3.76.94m-7 10v5a2 2 0 002 2h.096c.5 0 .905-.405.905-.904v-3.5a.75.75 0 00-.75-.75h-.5v-1a2 2 0 00-2-2h-3m0 0h.5a.5.5 0 01.5.5v.5"></path>
                                    </svg>
                                    <span>Not Helpful</span>
                                    <span class="unhelpful-count">(<?= $review->unhelpful_votes ?? 0 ?>)</span>
                                </button>
                            </div>
                            
                            <?php if ($review->user_id === auth()->id()): ?>
                                <div class="flex space-x-2">
                                    <a href="/housing/reviews/<?= $review->id ?>/edit" class="text-sm text-blue-600 hover:underline">Edit</a>
                                    <form action="/housing/reviews/<?= $review->id ?>" method="POST" class="inline">
                                        <?= csrf_field() ?>
                                        <input type="hidden" name="_method" value="DELETE">
                                        <button type="submit" class="text-sm text-red-600 hover:underline" onclick="return confirm('Are you sure you want to delete this review?')">Delete</button>
                                    </form>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="bg-white p-6 rounded-lg shadow-lg text-center">
                <p class="text-gray-600">No reviews yet. Be the first to review this property!</p>
                <a href="/housing/<?= $housingPost->id ?>/reviews/create" class="inline-block mt-4 px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">Write a Review</a>
            </div>
        <?php endif; ?>
    </div>
</div>

<script>
    // JavaScript for voting functionality
    document.addEventListener('DOMContentLoaded', function() {
        const voteButtons = document.querySelectorAll('.vote-btn');
        
        voteButtons.forEach(button => {
            button.addEventListener('click', function() {
                const reviewId = this.getAttribute('data-review-id');
                const voteType = this.getAttribute('data-vote-type');
                
                fetch(`/housing/reviews/${reviewId}/vote`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({ vote_type: voteType })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Update the vote counts
                        const reviewElement = this.closest('.bg-white');
                        reviewElement.querySelector('.helpful-count').textContent = `(${data.helpful_votes})`;
                        reviewElement.querySelector('.unhelpful-count').textContent = `(${data.unhelpful_votes})`;
                    }
                })
                .catch(error => console.error('Error voting on review:', error));
            });
        });
    });
</script>

<?php include(__DIR__ . '/../../partials/tail.php'); ?>