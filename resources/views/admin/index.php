<?php include(__DIR__ . '/../partials/head.php'); ?>
<?php include(__DIR__ . '/../partials/nav.php'); ?>

<div class="container mx-auto px-4 py-8">
    <div class="max-w-5xl mx-auto">
        <h1 class="text-3xl font-bold text-center text-indigo-700 mb-8">Admin Dashboard</h1>
        
        <!-- Flash Message -->
        <?php if (session('success')): ?>
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-md flex items-center" role="alert">
                <i class="fas fa-check-circle text-green-500 mr-2"></i>
                <span><?= session('success') ?></span>
            </div>
        <?php endif; ?>
        
        <!-- Admin Sections -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            <!-- Housing Management Section -->
            <div class="bg-white p-6 rounded-lg shadow-lg">
                <div class="flex items-center mb-4">
                    <div class="bg-indigo-100 rounded-full p-3 mr-4">
                        <i class="fas fa-home text-2xl text-indigo-600"></i>
                    </div>
                    <h2 class="text-xl font-semibold">Housing Management</h2>
                </div>
                
                <div class="space-y-4">
                    <a href="/admin/housing/reviews/moderation" class="flex items-center p-3 rounded-lg bg-gray-50 hover:bg-indigo-50 transition-colors">
                        <div class="rounded-full bg-yellow-100 p-2 mr-3">
                            <i class="fas fa-star text-yellow-600"></i>
                        </div>
                        <div>
                            <h3 class="font-medium">Review Moderation</h3>
                            <p class="text-sm text-gray-600">Approve or reject user submitted reviews</p>
                        </div>
                        <i class="fas fa-chevron-right ml-auto text-gray-400"></i>
                    </a>
                    
                    <a href="/housing" class="flex items-center p-3 rounded-lg bg-gray-50 hover:bg-indigo-50 transition-colors">
                        <div class="rounded-full bg-green-100 p-2 mr-3">
                            <i class="fas fa-search text-green-600"></i>
                        </div>
                        <div>
                            <h3 class="font-medium">View All Listings</h3>
                            <p class="text-sm text-gray-600">Browse all housing listings</p>
                        </div>
                        <i class="fas fa-chevron-right ml-auto text-gray-400"></i>
                    </a>
                </div>
            </div>
            
            <!-- User Management Section -->
            <div class="bg-white p-6 rounded-lg shadow-lg">
                <div class="flex items-center mb-4">
                    <div class="bg-purple-100 rounded-full p-3 mr-4">
                        <i class="fas fa-users text-2xl text-purple-600"></i>
                    </div>
                    <h2 class="text-xl font-semibold">User Management</h2>
                </div>
                
                <div class="space-y-4">
                    <a href="#" class="flex items-center p-3 rounded-lg bg-gray-50 hover:bg-purple-50 transition-colors">
                        <div class="rounded-full bg-blue-100 p-2 mr-3">
                            <i class="fas fa-user-cog text-blue-600"></i>
                        </div>
                        <div>
                            <h3 class="font-medium">Manage Users</h3>
                            <p class="text-sm text-gray-600">View and edit user accounts</p>
                        </div>
                        <i class="fas fa-chevron-right ml-auto text-gray-400"></i>
                    </a>
                </div>
            </div>
        </div>
        
        <!-- System Status -->
        <div class="bg-white p-6 rounded-lg shadow-lg">
            <div class="flex items-center mb-4">
                <div class="bg-blue-100 rounded-full p-3 mr-4">
                    <i class="fas fa-chart-line text-2xl text-blue-600"></i>
                </div>
                <h2 class="text-xl font-semibold">System Status</h2>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="bg-gray-50 p-4 rounded-lg">
                    <div class="text-sm text-gray-500 mb-1">Pending Reviews</div>
                    <div class="text-2xl font-bold text-indigo-600">
                        <?php
                            // This would be replaced with actual count from controller
                            echo \App\Models\HousingReview::where('is_approved', false)->count();
                        ?>
                    </div>
                </div>
                
                <div class="bg-gray-50 p-4 rounded-lg">
                    <div class="text-sm text-gray-500 mb-1">Total Housing Listings</div>
                    <div class="text-2xl font-bold text-indigo-600">
                        <?php
                            // This would be replaced with actual count from controller
                            echo \App\Models\HousingPost::count();
                        ?>
                    </div>
                </div>
                
                <div class="bg-gray-50 p-4 rounded-lg">
                    <div class="text-sm text-gray-500 mb-1">Total Users</div>
                    <div class="text-2xl font-bold text-indigo-600">
                        <?php
                            // This would be replaced with actual count from controller
                            echo \App\Models\User::count();
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include(__DIR__ . '/../partials/tail.php'); ?>