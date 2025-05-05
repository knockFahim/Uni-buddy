<?php include(__DIR__ . '/../partials/head.php'); ?>
<?php include(__DIR__ . '/../partials/nav.php'); ?>

<div class="container mx-auto px-4 py-8">
    <!-- Hero Section -->
    <div class="bg-gradient-to-r from-indigo-600 to-purple-700 rounded-xl shadow-xl mb-8 overflow-hidden">
        <div class="container mx-auto px-4 py-12 md:py-16">
            <div class="max-w-3xl mx-auto text-center">
                <h1 class="text-3xl md:text-4xl font-bold text-white mb-4">
                    Find Your Perfect University Housing
                </h1>
                <p class="text-indigo-100 text-lg mb-8">
                    Browse affordable rentals near your university and connect with fellow students looking for roommates
                </p>
            </div>
        </div>
    </div>
    
    <!-- Search Form Card -->
    <div class="bg-white rounded-xl shadow-lg mb-8 overflow-hidden transform transition-all">
        <div class="p-6">
            <h2 class="text-xl font-semibold text-gray-800 mb-6 flex items-center">
                <i class="fas fa-search text-indigo-600 mr-2"></i>
                Search Housing
            </h2>
            <form action="/housing" method="GET">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                    <div>
                        <label class="block font-medium text-gray-700 mb-2">
                            <i class="fas fa-map-marker-alt text-indigo-500 mr-1"></i> Location
                        </label>
                        <input type="text" name="location" placeholder="Any location" 
                            value="<?= isset($location) ? htmlspecialchars($location) : '' ?>"
                            class="w-full border border-gray-300 p-3 rounded-lg focus:ring-2 focus:ring-indigo-400 focus:border-indigo-500 focus:outline-none transition">
                    </div>
                    <div>
                        <label class="block font-medium text-gray-700 mb-2">
                            <i class="fas fa-dollar-sign text-indigo-500 mr-1"></i> Max Rent
                        </label>
                        <input type="number" name="max_rent" placeholder="Any price" 
                            value="<?= isset($maxRent) ? htmlspecialchars($maxRent) : '' ?>"
                            class="w-full border border-gray-300 p-3 rounded-lg focus:ring-2 focus:ring-indigo-400 focus:border-indigo-500 focus:outline-none transition">
                    </div>
                    <div>
                        <label class="block font-medium text-gray-700 mb-2">
                            <i class="fas fa-building text-indigo-500 mr-1"></i> Property Type
                        </label>
                        <select name="property_type" class="w-full border border-gray-300 p-3 rounded-lg focus:ring-2 focus:ring-indigo-400 focus:border-indigo-500 focus:outline-none transition">
                            <option value="">Any type</option>
                            <option value="apartment" <?= isset($propertyType) && $propertyType === 'apartment' ? 'selected' : '' ?>>Apartment</option>
                            <option value="house" <?= isset($propertyType) && $propertyType === 'house' ? 'selected' : '' ?>>House</option>
                            <option value="room" <?= isset($propertyType) && $propertyType === 'room' ? 'selected' : '' ?>>Room</option>
                            <option value="studio" <?= isset($propertyType) && $propertyType === 'studio' ? 'selected' : '' ?>>Studio</option>
                        </select>
                    </div>
                    <div>
                        <label class="block font-medium text-gray-700 mb-2">
                            <i class="fas fa-bed text-indigo-500 mr-1"></i> Min Bedrooms
                        </label>
                        <select name="bedrooms" class="w-full border border-gray-300 p-3 rounded-lg focus:ring-2 focus:ring-indigo-400 focus:border-indigo-500 focus:outline-none transition">
                            <option value="">Any</option>
                            <option value="1" <?= isset($bedrooms) && $bedrooms == 1 ? 'selected' : '' ?>>1+</option>
                            <option value="2" <?= isset($bedrooms) && $bedrooms == 2 ? 'selected' : '' ?>>2+</option>
                            <option value="3" <?= isset($bedrooms) && $bedrooms == 3 ? 'selected' : '' ?>>3+</option>
                            <option value="4" <?= isset($bedrooms) && $bedrooms == 4 ? 'selected' : '' ?>>4+</option>
                        </select>
                    </div>
                </div>
                <div class="mt-6 flex justify-center">
                    <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 px-8 rounded-full transition-colors flex items-center">
                        <i class="fas fa-search mr-2"></i> Search
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Flash Messages -->
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

    <!-- Housing Posts -->
    <h2 class="text-2xl font-bold text-gray-800 mb-6 flex items-center">
        <?php if(!empty($location) || !empty($maxRent) || !empty($propertyType) || !empty($bedrooms)): ?>
            <i class="fas fa-filter text-indigo-600 mr-2"></i> Search Results
        <?php else: ?>
            <i class="fas fa-home text-indigo-600 mr-2"></i> Available Housing
        <?php endif; ?>
    </h2>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <?php if(count($posts) > 0): ?>
            <?php foreach($posts as $post): ?>
                <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-lg transition-all card-hover">
                    <div class="p-6">
                        <div class="flex justify-between items-start mb-3">
                            <h3 class="text-xl font-bold text-indigo-700 hover:text-indigo-900 transition">
                                <a href="/housing/<?= $post->id ?>"><?= htmlspecialchars($post->title) ?></a>
                            </h3>
                            <span class="bg-green-100 text-green-800 text-sm px-3 py-1 rounded-full font-semibold">
                                $<?= number_format($post->rent_amount, 0) ?>
                            </span>
                        </div>
                        
                        <div class="text-sm text-gray-600 mb-4 flex items-center">
                            <i class="fas fa-user-circle text-gray-500 mr-1"></i>
                            <span><?= htmlspecialchars($post->user->name) ?></span>
                            <span class="mx-2">•</span>
                            <i class="fas fa-calendar text-gray-500 mr-1"></i>
                            <span>Available <?= $post->available_from->format('M d, Y') ?></span>
                        </div>
                        
                        <div class="mb-3 flex items-center text-gray-600">
                            <i class="fas fa-map-marker-alt text-indigo-500 mr-1"></i>
                            <span><?= htmlspecialchars($post->location) ?></span>
                        </div>
                        
                        <div class="flex flex-wrap gap-2 mb-4">
                            <span class="bg-indigo-100 text-indigo-800 text-xs px-2 py-1 rounded-full flex items-center">
                                <i class="fas fa-building mr-1"></i>
                                <?= ucfirst(htmlspecialchars($post->property_type)) ?>
                            </span>
                            <span class="bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded-full flex items-center">
                                <i class="fas fa-bed mr-1"></i>
                                <?= $post->bedrooms ?> <?= $post->bedrooms == 1 ? 'bed' : 'beds' ?>
                            </span>
                            <span class="bg-purple-100 text-purple-800 text-xs px-2 py-1 rounded-full flex items-center">
                                <i class="fas fa-bath mr-1"></i>
                                <?= $post->bathrooms ?> <?= $post->bathrooms == 1 ? 'bath' : 'baths' ?>
                            </span>
                            <?php if($post->utilities_included): ?>
                                <span class="bg-yellow-100 text-yellow-800 text-xs px-2 py-1 rounded-full flex items-center">
                                    <i class="fas fa-bolt mr-1"></i>
                                    Utilities included
                                </span>
                            <?php endif; ?>
                        </div>
                        <p class="text-gray-700 mb-4 line-clamp-2"><?= htmlspecialchars(substr($post->description, 0, 100)) ?>...</p>
                        <div class="flex justify-between items-center">
                            <a href="/housing/<?= $post->id ?>" class="inline-flex items-center text-indigo-600 hover:text-indigo-800">
                                View Details
                                <i class="fas fa-arrow-right ml-1 text-xs"></i>
                            </a>
                            <span class="text-sm text-gray-500"><?= time_ago($post->created_at) ?></span>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="col-span-3 bg-gray-50 border border-gray-200 rounded-lg p-8 text-center">
                <img src="https://cdn-icons-png.flaticon.com/512/6134/6134065.png" alt="No results" class="w-24 h-24 mx-auto mb-4 opacity-50">
                <p class="text-lg text-gray-600 mb-2">No housing posts found matching your criteria.</p>
                <p class="text-gray-500">Try adjusting your search filters or <a href="/housing/create" class="text-indigo-600 hover:text-indigo-800">post your own housing</a>.</p>
            </div>
        <?php endif; ?>
    </div>
    
    <div class="mt-8">
        <?php /* Pagination would go here */ ?>
    </div>
</div>

<?php
// Helper function to display time ago
function time_ago($timestamp) {
    $timestamp = strtotime($timestamp);
    $current_time = time();
    $diff = $current_time - $timestamp;
    
    if ($diff < 60) {
        return 'Just now';
    } elseif ($diff < 3600) {
        $minutes = round($diff / 60);
        return $minutes . ($minutes == 1 ? ' minute' : ' minutes') . ' ago';
    } elseif ($diff < 86400) {
        $hours = round($diff / 3600);
        return $hours . ($hours == 1 ? ' hour' : ' hours') . ' ago';
    } elseif ($diff < 604800) {
        $days = round($diff / 86400);
        return $days . ($days == 1 ? ' day' : ' days') . ' ago';
    } else {
        return date('M j, Y', $timestamp);
    }
}
?>

<?php include(__DIR__ . '/../partials/tail.php'); ?>