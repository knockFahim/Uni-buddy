<?php include(__DIR__ . '/../../partials/head.php'); ?>
<?php include(__DIR__ . '/../../partials/nav.php'); ?>

<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <h1 class="text-3xl font-bold text-center text-indigo-700 mb-8">My Housing Reviews</h1>
        
        <?php if (count($reviews) > 0): ?>
            <div class="mb-6 bg-white p-4 rounded-lg shadow">
                <p class="text-center text-lg">You have written <span class="font-semibold"><?= count($reviews) ?></span> housing <?= count($reviews) == 1 ? 'review' : 'reviews' ?></p>
            </div>
            
            <div class="space-y-6">
                <?php foreach ($reviews as $review): ?>
                    <div class="bg-white p-6 rounded-lg shadow-lg">
                        <div class="flex flex-col md:flex-row justify-between items-start mb-4">
                            <div class="flex flex-col md:flex-row items-start md:items-center mb-4 md:mb-0">
                                <img src="<?= $review->housingPost->primaryPhoto() ? $review->housingPost->primaryPhoto()->getUrlAttribute() : '/images/placeholder-housing.jpg' ?>" 
                                     alt="<?= $review->housingPost->title ?>" 
                                     class="w-16 h-16 object-cover rounded-md mr-4 mb-2 md:mb-0">
                                     
                                <div>
                                    <h3 class="text-lg font-semibold">
                                        <a href="/housing/<?= $review->housingPost->id ?>" class="text-indigo-600 hover:underline">
                                            <?= $review->housingPost->title ?>
                                        </a>
                                    </h3>
                                    <p class="text-gray-600"><?= $review->housingPost->location ?></p>
                                </div>
                            </div>
                            
                            <div class="flex flex-col items-end">
                                <div class="text-sm text-gray-500 mb-1">Reviewed on <?= date('M d, Y', strtotime($review->created_at)) ?></div>
                                <div class="flex items-center">
                                    <div class="flex mr-2">
                                        <?php for ($i = 1; $i <= 5; $i++): ?>
                                            <?php if ($i <= round($review->overall_rating)): ?>
                                                <span class="text-yellow-400">★</span>
                                            <?php else: ?>
                                                <span class="text-gray-300">★</span>
                                            <?php endif; ?>
                                        <?php endfor; ?>
                                    </div>
                                    <span class="text-gray-600 text-sm"><?= number_format($review->overall_rating, 1) ?></span>
                                </div>
                                
                                <?php if (!$review->is_approved): ?>
                                    <span class="mt-1 px-2 py-1 bg-yellow-100 text-yellow-800 text-xs rounded-full">
                                        Pending Approval
                                    </span>
                                <?php endif; ?>
                                
                                <?php if ($review->anonymous): ?>
                                    <span class="mt-1 px-2 py-1 bg-gray-100 text-gray-600 text-xs rounded-full">
                                        Anonymous
                                    </span>
                                <?php endif; ?>
                            </div>
                        </div>
                        
                        <div class="mb-4">
                            <p class="text-gray-700"><?= nl2br(htmlspecialchars($review->review_text)) ?></p>
                        </div>
                        
                        <div class="grid grid-cols-5 gap-2 mb-4 text-sm">
                            <div class="text-center">
                                <div class="text-gray-600">Cleanliness</div>
                                <div class="font-semibold"><?= $review->cleanliness_rating ?>/5</div>
                            </div>
                            <div class="text-center">
                                <div class="text-gray-600">Location</div>
                                <div class="font-semibold"><?= $review->location_rating ?>/5</div>
                            </div>
                            <div class="text-center">
                                <div class="text-gray-600">Value</div>
                                <div class="font-semibold"><?= $review->value_rating ?>/5</div>
                            </div>
                            <div class="text-center">
                                <div class="text-gray-600">Landlord</div>
                                <div class="font-semibold"><?= $review->landlord_rating ?>/5</div>
                            </div>
                            <div class="text-center">
                                <div class="text-gray-600">Safety</div>
                                <div class="font-semibold"><?= $review->safety_rating ?>/5</div>
                            </div>
                        </div>
                        
                        <div class="flex justify-end space-x-2">
                            <a href="/housing/reviews/<?= $review->id ?>/edit" class="px-4 py-2 text-sm bg-indigo-100 text-indigo-700 rounded hover:bg-indigo-200 transition">Edit Review</a>
                            <form action="/housing/reviews/<?= $review->id ?>" method="POST" class="inline">
                                <?= csrf_field() ?>
                                <input type="hidden" name="_method" value="DELETE">
                                <button type="submit" class="px-4 py-2 text-sm bg-red-100 text-red-700 rounded hover:bg-red-200 transition" onclick="return confirm('Are you sure you want to delete this review?')">
                                    Delete
                                </button>
                            </form>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="bg-white p-8 rounded-lg shadow-lg text-center">
                <div class="text-5xl text-gray-400 mb-4">
                    <i class="fas fa-comments"></i>
                </div>
                <h2 class="text-2xl font-semibold mb-2">No Reviews Yet</h2>
                <p class="text-gray-600 mb-6">You haven't written any housing reviews yet.</p>
                <a href="/housing" class="px-6 py-3 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 transition">Browse Housing</a>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php include(__DIR__ . '/../../partials/tail.php'); ?>