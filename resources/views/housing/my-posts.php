<?php include(__DIR__ . '/../partials/head.php'); ?>
<?php include(__DIR__ . '/../partials/nav.php'); ?>

<div class="container mx-auto mt-8 max-w-6xl px-4 pb-12">
    <!-- Breadcrumbs -->
    <div class="flex items-center mb-6 text-sm">
        <a href="/housing" class="text-indigo-600 hover:text-indigo-800">
            <i class="fas fa-home"></i> Housing
        </a>
        <i class="fas fa-chevron-right mx-2 text-gray-400 text-xs"></i>
        <span class="text-gray-600">My Listings</span>
    </div>

    <div class="flex flex-col md:flex-row items-center justify-between mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-800 flex items-center">
                <i class="fas fa-clipboard-list text-indigo-600 mr-3"></i>
                My Housing Posts
            </h1>
            <p class="text-gray-600 mt-1">Manage your rental listings</p>
        </div>
        <a href="/housing/create" class="mt-4 md:mt-0 bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-6 rounded-lg transition-colors flex items-center">
            <i class="fas fa-plus-circle mr-2"></i>
            New Housing Post
        </a>
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

    <!-- Housing Posts Dashboard -->
    <?php if(count($housingPosts) > 0): ?>
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <!-- Dashboard Stats -->
            <div class="bg-gray-50 p-6 border-b">
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div class="bg-white p-4 rounded-lg shadow-sm">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-500">Total Posts</p>
                                <p class="text-2xl font-bold text-gray-800"><?= count($housingPosts) ?></p>
                            </div>
                            <div class="bg-indigo-100 p-3 rounded-full">
                                <i class="fas fa-list text-indigo-600"></i>
                            </div>
                        </div>
                    </div>
                    
                    <div class="bg-white p-4 rounded-lg shadow-sm">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-500">Active Listings</p>
                                <p class="text-2xl font-bold text-green-600">
                                    <?= count(array_filter($housingPosts->toArray(), function($post) { return $post['is_available']; })) ?>
                                </p>
                            </div>
                            <div class="bg-green-100 p-3 rounded-full">
                                <i class="fas fa-check-circle text-green-600"></i>
                            </div>
                        </div>
                    </div>
                    
                    <div class="bg-white p-4 rounded-lg shadow-sm">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-500">Inactive Listings</p>
                                <p class="text-2xl font-bold text-red-600">
                                    <?= count(array_filter($housingPosts->toArray(), function($post) { return !$post['is_available']; })) ?>
                                </p>
                            </div>
                            <div class="bg-red-100 p-3 rounded-full">
                                <i class="fas fa-times-circle text-red-600"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Listings Table -->
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Property Details</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Location</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Price</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        <?php foreach ($housingPosts as $post): ?>
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        <div class="bg-indigo-100 p-2 rounded-lg mr-3 text-indigo-700">
                                            <?php if ($post->property_type === 'apartment'): ?>
                                                <i class="fas fa-building"></i>
                                            <?php elseif ($post->property_type === 'house'): ?>
                                                <i class="fas fa-home"></i>
                                            <?php elseif ($post->property_type === 'room'): ?>
                                                <i class="fas fa-door-open"></i>
                                            <?php else: ?>
                                                <i class="fas fa-warehouse"></i>
                                            <?php endif; ?>
                                        </div>
                                        <div>
                                            <a href="/housing/<?= $post->id ?>" class="text-indigo-600 hover:text-indigo-900 font-medium">
                                                <?= htmlspecialchars(substr($post->title, 0, 40)) ?>
                                                <?= strlen($post->title) > 40 ? '...' : '' ?>
                                            </a>
                                            <div class="text-xs text-gray-500 mt-1">
                                                <?= $post->bedrooms ?> bed, <?= $post->bathrooms ?> bath • <?= ucfirst($post->property_type) ?>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-600">
                                    <div class="flex items-center">
                                        <i class="fas fa-map-marker-alt text-gray-400 mr-1"></i>
                                        <?= htmlspecialchars(substr($post->location, 0, 25)) ?>
                                        <?= strlen($post->location) > 25 ? '...' : '' ?>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-sm font-medium">
                                    <div class="text-green-600">$<?= number_format($post->rent_amount, 0) ?>/mo</div>
                                    <div class="text-xs text-gray-500">
                                        From <?= $post->available_from->format('M j, Y') ?>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <?php if ($post->is_available): ?>
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800 flex items-center w-fit">
                                            <i class="fas fa-circle text-xs mr-1"></i>Available
                                        </span>
                                    <?php else: ?>
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800 flex items-center w-fit">
                                            <i class="fas fa-circle text-xs mr-1"></i>Not Available
                                        </span>
                                    <?php endif; ?>
                                </td>
                                <td class="px-6 py-4 text-sm font-medium">
                                    <div class="flex items-center space-x-3">
                                        <a href="/housing/<?= $post->id ?>" class="text-gray-600 hover:text-gray-900" title="View">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="/housing/<?= $post->id ?>/edit" class="text-blue-600 hover:text-blue-900" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="/housing/<?= $post->id ?>" method="POST" onsubmit="return confirm('Are you sure you want to delete this post? This action cannot be undone.');" class="inline">
                                            <?= csrf_field() ?>
                                            <input type="hidden" name="_method" value="DELETE">
                                            <button type="submit" class="text-red-600 hover:text-red-900" title="Delete">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    <?php else: ?>
        <div class="bg-white rounded-xl shadow-lg p-8 text-center">
            <img src="https://cdn-icons-png.flaticon.com/512/6134/6134065.png" alt="No listings" class="w-32 h-32 mx-auto mb-6 opacity-50">
            <h2 class="text-xl font-semibold text-gray-700 mb-2">No Housing Posts Yet</h2>
            <p class="text-gray-600 mb-6">You haven't posted any housing listings yet. Ready to rent out a property?</p>
            <a href="/housing/create" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 px-8 rounded-lg transition-colors inline-flex items-center">
                <i class="fas fa-plus-circle mr-2"></i>
                Create Your First Housing Post
            </a>
        </div>
    <?php endif; ?>
</div>

<?php include(__DIR__ . '/../partials/tail.php'); ?>