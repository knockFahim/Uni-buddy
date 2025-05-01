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
                        <?= $housingPost->available_from->format('Available from F j, Y') ?>
                    </p>
                </div>
            </div>
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
    
    <div class="mt-6">
        <a href="/housing" class="inline-flex items-center text-indigo-600 hover:text-indigo-800 transition-colors">
            <i class="fas fa-arrow-left mr-2"></i>
            Back to Housing Search
        </a>
    </div>
</div>

<?php include(__DIR__ . '/../partials/tail.php'); ?>