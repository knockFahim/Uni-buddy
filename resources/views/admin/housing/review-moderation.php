<?php include(__DIR__ . '/../../partials/head.php'); ?>
<?php include(__DIR__ . '/../../partials/nav.php'); ?>

<div class="container mx-auto px-4 py-8">
    <div class="max-w-5xl mx-auto">
        <!-- Breadcrumbs -->
        <div class="flex items-center mb-6 text-sm">
            <a href="/admin" class="text-indigo-600 hover:text-indigo-800">
                <i class="fas fa-cog"></i> Admin
            </a>
            <i class="fas fa-chevron-right mx-2 text-gray-400 text-xs"></i>
            <span class="text-gray-600">Review Moderation</span>
        </div>

        <h1 class="text-3xl font-bold text-center text-indigo-700 mb-8">Housing Review Moderation</h1>
        
        <!-- Flash Message -->
        <?php if (session('success')): ?>
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-md flex items-center" role="alert">
                <i class="fas fa-check-circle text-green-500 mr-2"></i>
                <span><?= session('success') ?></span>
            </div>
        <?php endif; ?>
        
        <?php if (session('error')): ?>
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded-md flex items-center" role="alert">
                <i class="fas fa-exclamation-circle text-red-500 mr-2"></i>
                <span><?= session('error') ?></span>
            </div>
        <?php endif; ?>
        
        <div class="bg-white p-6 rounded-lg shadow-lg">
            <div class="mb-6 flex items-center justify-between">
                <div>
                    <h2 class="text-xl font-semibold">Pending Reviews</h2>
                    <p class="text-gray-600">Reviews awaiting moderation: <?= count($reviews) ?></p>
                </div>
                <div class="text-sm text-gray-600">
                    <i class="fas fa-info-circle mr-1"></i> Reviews need approval before they appear on the site
                </div>
            </div>
            
            <?php if (count($reviews) > 0): ?>
                <div class="space-y-8">
                    <?php foreach ($reviews as $review): ?>
                        <div class="border border-gray-200 rounded-lg p-6 bg-gray-50">
                            <div class="flex flex-col md:flex-row md:justify-between md:items-start mb-4">
                                <!-- Housing and Review Info -->
                                <div class="mb-4 md:mb-0">
                                    <h3 class="text-lg font-semibold">
                                        <a href="/housing/<?= $review->housing_post_id ?>" class="text-indigo-600 hover:underline" target="_blank">
                                            <?= htmlspecialchars($review->housingPost->title) ?>
                                        </a>
                                    </h3>
                                    <div class="text-sm text-gray-500 mb-1">
                                        <i class="fas fa-map-marker-alt mr-1"></i> <?= htmlspecialchars($review->housingPost->location) ?>
                                    </div>
                                    <div class="text-sm text-gray-500">
                                        Reviewed <?= date('M d, Y', strtotime($review->created_at)) ?> by 
                                        <?= $review->anonymous ? '<span class="font-medium">Anonymous User</span>' : htmlspecialchars($review->user->name) ?>
                                        <?= $review->anonymous ? ' <span class="text-xs italic">(Admin can see: ' . htmlspecialchars($review->user->name) . ')</span>' : '' ?>
                                    </div>
                                </div>
                                
                                <!-- Rating Summary -->
                                <div class="text-right">
                                    <div class="flex items-center justify-end">
                                        <span class="text-2xl font-bold text-indigo-600 mr-2"><?= number_format($review->overall_rating, 1) ?></span>
                                        <div class="flex">
                                            <?php for ($i = 1; $i <= 5; $i++): ?>
                                                <?php if ($i <= round($review->overall_rating)): ?>
                                                    <span class="text-yellow-400">★</span>
                                                <?php else: ?>
                                                    <span class="text-gray-300">★</span>
                                                <?php endif; ?>
                                            <?php endfor; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Review Details -->
                            <div class="mb-4">
                                <p class="text-gray-700 whitespace-pre-line"><?= nl2br(htmlspecialchars($review->review_text)) ?></p>
                            </div>
                            
                            <!-- Rating Breakdown -->
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
                            
                            <!-- Moderation Actions -->
                            <div class="flex flex-col sm:flex-row sm:justify-between space-y-3 sm:space-y-0 mt-4 pt-4 border-t border-gray-200">
                                <div class="flex space-x-2">
                                    <form action="/admin/housing/reviews/<?= $review->id ?>/moderate" method="POST">
                                        <?= csrf_field() ?>
                                        <input type="hidden" name="action" value="approve">
                                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-md transition-colors">
                                            <i class="fas fa-check mr-2"></i> Approve Review
                                        </button>
                                    </form>
                                    
                                    <button type="button" onclick="toggleRejectForm('reject-form-<?= $review->id ?>')" class="inline-flex items-center px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-md transition-colors">
                                        <i class="fas fa-times mr-2"></i> Reject Review
                                    </button>
                                </div>
                                
                                <a href="/housing/<?= $review->housing_post_id ?>" target="_blank" class="inline-flex items-center text-indigo-600 hover:text-indigo-800">
                                    <i class="fas fa-external-link-alt mr-1"></i> View Property
                                </a>
                            </div>
                            
                            <!-- Rejection Form (Hidden by Default) -->
                            <div id="reject-form-<?= $review->id ?>" class="mt-4 border-t border-gray-200 pt-4 hidden">
                                <form action="/admin/housing/reviews/<?= $review->id ?>/moderate" method="POST">
                                    <?= csrf_field() ?>
                                    <input type="hidden" name="action" value="reject">
                                    
                                    <div class="mb-3">
                                        <label for="rejection_reason" class="block text-sm font-medium text-gray-700 mb-1">Reason for Rejection</label>
                                        <textarea name="rejection_reason" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500"
                                              required placeholder="Explain why this review is being rejected..."></textarea>
                                    </div>
                                    
                                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white rounded-md transition-colors">
                                        <i class="fas fa-paper-plane mr-2"></i> Submit Rejection
                                    </button>
                                </form>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                
                <!-- Pagination -->
                <div class="mt-6">
                    <!-- Add pagination links here if needed -->
                </div>
            <?php else: ?>
                <div class="py-8 text-center">
                    <div class="text-5xl text-gray-400 mb-4">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">No Pending Reviews</h3>
                    <p class="text-gray-600">All housing reviews have been moderated. Check back later!</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- JavaScript for toggle functionality -->
<script>
    function toggleRejectForm(formId) {
        const form = document.getElementById(formId);
        if (form.classList.contains('hidden')) {
            form.classList.remove('hidden');
        } else {
            form.classList.add('hidden');
        }
    }
</script>

<?php include(__DIR__ . '/../../partials/tail.php'); ?>