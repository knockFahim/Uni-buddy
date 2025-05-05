<?php include(__DIR__ . '/../partials/head.php'); ?>
<?php include(__DIR__ . '/../partials/nav.php'); ?>

<div class="container mx-auto mt-8 max-w-5xl px-4 pb-12">
    <!-- Breadcrumbs -->
    <div class="flex items-center mb-6 text-sm">
        <a href="/housing" class="text-indigo-600 hover:text-indigo-800">
            <i class="fas fa-home"></i> Housing
        </a>
        <i class="fas fa-chevron-right mx-2 text-gray-400 text-xs"></i>
        <span class="text-gray-600">Listing Details</span>
    </div>

    <!-- Flash Message -->
    <?php if (session('success')): ?>
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-md flex items-center" role="alert">
            <i class="fas fa-check-circle text-green-500 mr-2"></i>
            <span><?= session('success') ?></span>
        </div>
    <?php endif; ?>

    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        <!-- Property Header -->
        <div class="bg-gradient-to-r from-indigo-600 to-purple-700 p-6 md:p-8 text-white">
            <div class="flex flex-col md:flex-row md:justify-between md:items-start">
                <div>
                    <h1 class="text-2xl md:text-3xl font-bold mb-1"><?= htmlspecialchars($housingPost->title) ?></h1>
                    <p class="flex items-center text-indigo-100 mb-3">
                        <i class="fas fa-map-marker-alt mr-1"></i>
                        <?= htmlspecialchars($housingPost->location) ?>
                    </p>
                </div>
                <div class="mt-4 md:mt-0 md:text-right">
                    <div class="bg-white text-indigo-800 inline-block px-4 py-2 rounded-lg font-bold text-xl mb-2">
                        $<?= number_format($housingPost->rent_amount, 0) ?>/month
                    </div>
                    <p class="text-indigo-100">
                        Available <?= $housingPost->available_from->format('M d, Y') ?>
                    </p>
                </div>
            </div>
        </div>
        
        <div class="p-6 md:p-8">
            <!-- Property Images Gallery -->
            <div class="mb-6">
                <?php if ($housingPost->photos && $housingPost->photos->count() > 0): ?>
                    <div class="bg-gray-100 p-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            <?php foreach ($housingPost->photos as $photo): ?>
                                <div class="aspect-w-16 aspect-h-9 overflow-hidden rounded-lg shadow-md">
                                    <img src="<?= $photo->getUrlAttribute() ?>" 
                                         alt="<?= htmlspecialchars($housingPost->title) ?>"
                                         class="w-full h-full object-cover hover:opacity-90 transition-opacity cursor-pointer"
                                         onclick="openImageModal(this.src)">
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="bg-gray-100 p-8 text-center">
                        <div class="text-gray-400 mb-2">
                            <i class="fas fa-image text-4xl"></i>
                        </div>
                        <p class="text-gray-600">No photos available for this property</p>
                    </div>
                <?php endif; ?>
            </div>
        
            <div class="p-6 md:p-8">
                <!-- Property Details -->
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <div class="lg:col-span-2">
                        <div class="bg-gray-50 p-6 rounded-xl mb-8">
                            <h2 class="text-xl font-semibold mb-6 text-gray-800 flex items-center">
                                <i class="fas fa-info-circle text-indigo-600 mr-2"></i>Overview
                            </h2>
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
                                <div class="bg-white p-4 rounded-lg shadow-sm text-center">
                                    <i class="fas fa-building text-indigo-600 text-xl mb-1"></i>
                                    <p class="text-sm text-gray-500">Property Type</p>
                                    <p class="font-semibold text-gray-800"><?= ucfirst(htmlspecialchars($housingPost->property_type)) ?></p>
                                </div>
                                <div class="bg-white p-4 rounded-lg shadow-sm text-center">
                                    <i class="fas fa-bed text-indigo-600 text-xl mb-1"></i>
                                    <p class="text-sm text-gray-500">Bedrooms</p>
                                    <p class="font-semibold text-gray-800"><?= $housingPost->bedrooms ?></p>
                                </div>
                                <div class="bg-white p-4 rounded-lg shadow-sm text-center">
                                    <i class="fas fa-bath text-indigo-600 text-xl mb-1"></i>
                                    <p class="text-sm text-gray-500">Bathrooms</p>
                                    <p class="font-semibold text-gray-800"><?= $housingPost->bathrooms ?></p>
                                </div>
                                <div class="bg-white p-4 rounded-lg shadow-sm text-center">
                                    <i class="fas fa-bolt text-indigo-600 text-xl mb-1"></i>
                                    <p class="text-sm text-gray-500">Utilities</p>
                                    <p class="font-semibold text-gray-800"><?= $housingPost->utilities_included ? 'Included' : 'Not included' ?></p>
                                </div>
                            </div>

                            <h2 class="text-xl font-semibold mb-4 text-gray-800 flex items-center">
                                <i class="fas fa-align-left text-indigo-600 mr-2"></i>Description
                            </h2>
                            <div class="text-gray-700 whitespace-pre-line bg-white p-5 rounded-lg shadow-sm">
                                <?= nl2br(htmlspecialchars($housingPost->description)) ?>
                            </div>
                        </div>

                        <!-- Posted by section for mobile -->
                        <div class="block lg:hidden bg-gray-50 p-6 rounded-xl mb-8">
                            <h2 class="text-xl font-semibold mb-4 text-gray-800 flex items-center">
                                <i class="fas fa-user text-indigo-600 mr-2"></i>Posted by
                            </h2>
                            <div class="flex items-center mb-4">
                                <div class="bg-indigo-100 rounded-full p-3 mr-4">
                                    <i class="fas fa-user-circle text-2xl text-indigo-600"></i>
                                </div>
                                <div>
                                    <h3 class="font-semibold text-gray-800"><?= htmlspecialchars($housingPost->user->name) ?></h3>
                                    <p class="text-sm text-gray-500">University Student</p>
                                </div>
                            </div>
                            <div class="space-y-3">
                                <a href="mailto:<?= htmlspecialchars($housingPost->user->email) ?>" class="flex items-center hover:bg-indigo-50 p-2 rounded transition-colors">
                                    <i class="fas fa-envelope text-indigo-600 mr-3 w-5"></i>
                                    <span class="text-indigo-700 hover:text-indigo-900"><?= htmlspecialchars($housingPost->user->email) ?></span>
                                </a>
                                <?php if ($housingPost->contact_phone): ?>
                                    <a href="tel:<?= htmlspecialchars($housingPost->contact_phone) ?>" class="flex items-center hover:bg-indigo-50 p-2 rounded transition-colors">
                                        <i class="fas fa-phone text-indigo-600 mr-3 w-5"></i>
                                        <span class="text-indigo-700 hover:text-indigo-900"><?= htmlspecialchars($housingPost->contact_phone) ?></span>
                                    </a>
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- Edit/Delete options if user is the owner (mobile) -->
                        <?php if (auth()->id() === $housingPost->user_id): ?>
                            <div class="block lg:hidden bg-gray-50 p-6 rounded-xl mb-6">
                                <h2 class="text-xl font-semibold mb-4 text-gray-800 flex items-center">
                                    <i class="fas fa-cog text-indigo-600 mr-2"></i>Manage Listing
                                </h2>
                                <div class="flex flex-col space-y-3">
                                    <a href="/housing/<?= $housingPost->id ?>/edit" class="bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded-lg transition-colors flex items-center justify-center">
                                        <i class="fas fa-edit mr-2"></i>Edit Post
                                    </a>
                                    <form action="/housing/<?= $housingPost->id ?>" method="POST" class="w-full" onsubmit="return confirm('Are you sure you want to delete this post?');">
                                        <?= csrf_field() ?>
                                        <input type="hidden" name="_method" value="DELETE">
                                        <button type="submit" class="bg-red-600 hover:bg-red-700 text-white py-2 px-4 rounded-lg transition-colors w-full flex items-center justify-center">
                                            <i class="fas fa-trash-alt mr-2"></i>Delete Post
                                        </button>
                                    </form>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>

                    <!-- Contact sidebar -->
                    <div class="lg:col-span-1">
                        <div class="hidden lg:block bg-gray-50 p-6 rounded-xl mb-8 sticky top-24">
                            <h2 class="text-xl font-semibold mb-4 text-gray-800 flex items-center">
                                <i class="fas fa-user text-indigo-600 mr-2"></i>Posted by
                            </h2>
                            <div class="flex items-center mb-6">
                                <div class="bg-indigo-100 rounded-full p-3 mr-4">
                                    <i class="fas fa-user-circle text-2xl text-indigo-600"></i>
                                </div>
                                <div>
                                    <h3 class="font-semibold text-gray-800"><?= htmlspecialchars($housingPost->user->name) ?></h3>
                                    <p class="text-sm text-gray-500">University Student</p>
                                </div>
                            </div>
                            <div class="space-y-3 mb-6">
                                <a href="mailto:<?= htmlspecialchars($housingPost->user->email) ?>" class="flex items-center hover:bg-indigo-50 p-2 rounded transition-colors">
                                    <i class="fas fa-envelope text-indigo-600 mr-3 w-5"></i>
                                    <span class="text-indigo-700 hover:text-indigo-900"><?= htmlspecialchars($housingPost->user->email) ?></span>
                                </a>
                                <?php if ($housingPost->contact_phone): ?>
                                    <a href="tel:<?= htmlspecialchars($housingPost->contact_phone) ?>" class="flex items-center hover:bg-indigo-50 p-2 rounded transition-colors">
                                        <i class="fas fa-phone text-indigo-600 mr-3 w-5"></i>
                                        <span class="text-indigo-700 hover:text-indigo-900"><?= htmlspecialchars($housingPost->contact_phone) ?></span>
                                    </a>
                                <?php endif; ?>
                            </div>
                            
                            <!-- Edit/Delete options if user is the owner (desktop) -->
                            <?php if (auth()->id() === $housingPost->user_id): ?>
                                <div class="border-t border-gray-200 pt-6">
                                    <h3 class="text-lg font-semibold mb-4 text-gray-800 flex items-center">
                                        <i class="fas fa-cog text-indigo-600 mr-2"></i>Manage Listing
                                    </h3>
                                    <div class="flex flex-col space-y-3">
                                        <a href="/housing/<?= $housingPost->id ?>/edit" class="bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded-lg transition-colors flex items-center justify-center">
                                            <i class="fas fa-edit mr-2"></i>Edit Post
                                        </a>
                                        <form action="/housing/<?= $housingPost->id ?>" method="POST" class="w-full" onsubmit="return confirm('Are you sure you want to delete this post?');">
                                            <?= csrf_field() ?>
                                            <input type="hidden" name="_method" value="DELETE">
                                            <button type="submit" class="bg-red-600 hover:bg-red-700 text-white py-2 px-4 rounded-lg transition-colors w-full flex items-center justify-center">
                                                <i class="fas fa-trash-alt mr-2"></i>Delete Post
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="mt-6">
        <a href="/housing" class="inline-flex items-center text-indigo-600 hover:text-indigo-800 transition-colors">
            <i class="fas fa-arrow-left mr-2"></i>
            Back to Housing Search
        </a>
    </div>
    
    <!-- Reviews Section -->
    <div class="mt-8 bg-white rounded-xl shadow-lg overflow-hidden">
        <div class="bg-gradient-to-r from-indigo-500 to-purple-600 p-6">
            <h2 class="text-2xl font-bold text-white flex items-center">
                <i class="fas fa-star mr-3"></i>Reviews
                <?php if (count($housingPost->approvedReviews) > 0): ?>
                    <span class="ml-2 text-sm bg-indigo-100 text-indigo-800 px-2 py-1 rounded-full">
                        <?= count($housingPost->approvedReviews) ?> <?= count($housingPost->approvedReviews) == 1 ? 'review' : 'reviews' ?>
                    </span>
                <?php endif; ?>
            </h2>
        </div>
        
        <div class="p-6">
            <?php if (count($housingPost->approvedReviews) > 0): ?>
                <!-- Review Summary -->
                <div class="flex items-center mb-6">
                    <div class="flex items-center bg-indigo-100 p-3 rounded-lg">
                        <div class="text-3xl font-bold text-indigo-700"><?= number_format($housingPost->avgRating, 1) ?></div>
                        <div class="ml-2">
                            <div class="flex">
                                <?php for ($i = 1; $i <= 5; $i++): ?>
                                    <?php if ($i <= round($housingPost->avgRating)): ?>
                                        <svg class="w-5 h-5 text-yellow-400 fill-current" viewBox="0 0 24 24">
                                            <path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"></path>
                                        </svg>
                                    <?php else: ?>
                                        <svg class="w-5 h-5 text-gray-300 fill-current" viewBox="0 0 24 24">
                                            <path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"></path>
                                        </svg>
                                    <?php endif; ?>
                                <?php endfor; ?>
                            </div>
                            <div class="text-sm text-gray-600"><?= count($housingPost->approvedReviews) ?> reviews</div>
                        </div>
                    </div>
                    
                    <div class="ml-auto">
                        <a href="/housing/<?= $housingPost->id ?>/reviews" class="text-indigo-600 hover:text-indigo-800">
                            See all reviews <i class="fas fa-arrow-right ml-1"></i>
                        </a>
                    </div>
                </div>
                
                <!-- Display most recent reviews -->
                <div class="space-y-6">
                    <?php foreach (array_slice($housingPost->approvedReviews->toArray(), 0, 3) as $review): ?>
                        <div class="border-b border-gray-200 pb-6 last:border-0 last:pb-0">
                            <div class="flex justify-between mb-2">
                                <div>
                                    <div class="flex mb-1">
                                        <?php for ($i = 1; $i <= 5; $i++): ?>
                                            <?php if ($i <= $review['overall_rating']): ?>
                                                <svg class="w-5 h-5 text-yellow-400 fill-current" viewBox="0 0 24 24">
                                                    <path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"></path>
                                                </svg>
                                            <?php else: ?>
                                                <svg class="w-5 h-5 text-gray-300 fill-current" viewBox="0 0 24 24">
                                                    <path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"></path>
                                                </svg>
                                            <?php endif; ?>
                                        <?php endfor; ?>
                                    </div>
                                    <div class="font-medium">
                                        <?= $review['anonymous'] ? 'Anonymous User' : htmlspecialchars($review['user']['name']) ?>
                                    </div>
                                </div>
                                <div class="text-sm text-gray-500">
                                    <?= date('M d, Y', strtotime($review['created_at'])) ?>
                                </div>
                            </div>
                            <p class="text-gray-700"><?= nl2br(htmlspecialchars($review['review_text'])) ?></p>
                        </div>
                    <?php endforeach; ?>
                </div>
                
                <div class="mt-6 text-center">
                    <a href="/housing/<?= $housingPost->id ?>/reviews" class="inline-block px-4 py-2 bg-indigo-100 text-indigo-700 rounded-lg hover:bg-indigo-200 transition-colors">
                        View all <?= count($housingPost->approvedReviews) ?> reviews
                    </a>
                </div>
            <?php else: ?>
                <div class="text-center py-8">
                    <div class="text-gray-400 mb-4">
                        <i class="fas fa-comment-alt text-5xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">No Reviews Yet</h3>
                    <p class="text-gray-600 mb-6">Be the first to share your experience with this property!</p>
                </div>
            <?php endif; ?>
            
            <!-- Review CTA -->
            <div class="mt-6 border-t border-gray-200 pt-6">
                <div class="flex flex-col md:flex-row items-center justify-between">
                    <div class="mb-4 md:mb-0">
                        <h3 class="text-lg font-semibold">Have you stayed at this property?</h3>
                        <p class="text-gray-600">Share your experience to help others!</p>
                    </div>
                    <?php if (auth()->check()): ?>
                        <?php if ($userHasReviewed): ?>
                            <a href="/housing/reviews/<?= $housingPost->id ?>/edit" class="px-6 py-2 bg-indigo-200 text-indigo-700 font-semibold rounded-lg hover:bg-indigo-300 transition-colors">
                                <i class="fas fa-edit mr-2"></i>Edit Your Review
                            </a>
                        <?php else: ?>
                            <a href="/housing/<?= $housingPost->id ?>/reviews/create" class="px-6 py-2 bg-indigo-600 text-white font-semibold rounded-lg hover:bg-indigo-700 transition-colors">
                                <i class="fas fa-star mr-2"></i>Write a Review
                            </a>
                        <?php endif; ?>
                    <?php else: ?>
                        <a href="/login" class="px-6 py-2 bg-indigo-600 text-white font-semibold rounded-lg hover:bg-indigo-700 transition-colors">
                            <i class="fas fa-sign-in-alt mr-2"></i>Log In to Review
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include(__DIR__ . '/../partials/tail.php'); ?>

<!-- Image Modal -->
<div id="imageModal" class="fixed inset-0 bg-black bg-opacity-80 z-50 hidden flex items-center justify-center p-4">
    <div class="relative max-w-4xl w-full">
        <button onclick="closeImageModal()" class="absolute right-0 top-0 -mt-12 text-white text-xl hover:text-gray-300">
            <i class="fas fa-times"></i> Close
        </button>
        <img id="modalImage" src="" alt="Property Image" class="max-h-[80vh] mx-auto rounded-lg">
    </div>
</div>

<script>
    function openImageModal(imgSrc) {
        document.getElementById('modalImage').src = imgSrc;
        document.getElementById('imageModal').classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
    }
    
    function closeImageModal() {
        document.getElementById('imageModal').classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
    }
    
    // Close modal when clicking outside the image
    document.getElementById('imageModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeImageModal();
        }
    });
    
    // Close modal with escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && !document.getElementById('imageModal').classList.contains('hidden')) {
            closeImageModal();
        }
    });
</script>