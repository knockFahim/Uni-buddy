<?php include(__DIR__ . '/../../partials/head.php'); ?>
<?php include(__DIR__ . '/../../partials/nav.php'); ?>

<div class="container mx-auto px-4 py-8">
    <div class="max-w-3xl mx-auto">
        <h1 class="text-3xl font-bold text-center text-indigo-700 mb-8">Your Roommate Preferences</h1>
        
        <div class="bg-white p-6 rounded-lg shadow-lg">
            <?php if ($preferences->id): ?>
                <div class="mb-6 flex justify-between items-center">
                    <div>
                        <h2 class="text-2xl font-semibold"><?= auth()->user()->name ?></h2>
                        <p class="text-gray-600"><?= auth()->user()->email ?></p>
                    </div>
                    
                    <div>
                        <?php if ($preferences->has_roommate_preferences): ?>
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                <svg class="mr-1.5 h-2 w-2 text-green-500" fill="currentColor" viewBox="0 0 8 8">
                                    <circle cx="4" cy="4" r="3" />
                                </svg>
                                Looking for Roommate
                            </span>
                        <?php else: ?>
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-gray-100 text-gray-800">
                                <svg class="mr-1.5 h-2 w-2 text-gray-500" fill="currentColor" viewBox="0 0 8 8">
                                    <circle cx="4" cy="4" r="3" />
                                </svg>
                                Not Looking for Roommate
                            </span>
                        <?php endif; ?>
                    </div>
                </div>
                
                <div class="border-t border-gray-200 py-4">
                    <h3 class="text-lg font-semibold mb-3">Basic Preferences</h3>
                    
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-4 mb-6">
                        <div>
                            <p class="text-sm text-gray-600">Gender Preference</p>
                            <p class="font-medium">
                                <?php
                                    switch ($preferences->preferred_gender) {
                                        case 'male':
                                            echo 'Male roommates';
                                            break;
                                        case 'female':
                                            echo 'Female roommates';
                                            break;
                                        default:
                                            echo 'Any gender';
                                    }
                                ?>
                            </p>
                        </div>
                        
                        <div>
                            <p class="text-sm text-gray-600">Smoking</p>
                            <p class="font-medium">
                                <?= $preferences->smoking_allowed ? 'Allowed' : 'Not allowed' ?>
                            </p>
                        </div>
                        
                        <div>
                            <p class="text-sm text-gray-600">Pets</p>
                            <p class="font-medium">
                                <?= $preferences->pets_allowed ? 'Allowed' : 'Not allowed' ?>
                            </p>
                        </div>
                        
                        <?php if ($preferences->preferred_location): ?>
                            <div>
                                <p class="text-sm text-gray-600">Preferred Location</p>
                                <p class="font-medium"><?= htmlspecialchars($preferences->preferred_location) ?></p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                
                <div class="border-t border-gray-200 py-4">
                    <h3 class="text-lg font-semibold mb-3">Budget</h3>
                    
                    <div class="grid grid-cols-2 gap-4 mb-6">
                        <?php if ($preferences->budget_min): ?>
                            <div>
                                <p class="text-sm text-gray-600">Minimum Budget</p>
                                <p class="font-medium">$<?= number_format($preferences->budget_min, 2) ?></p>
                            </div>
                        <?php endif; ?>
                        
                        <?php if ($preferences->budget_max): ?>
                            <div>
                                <p class="text-sm text-gray-600">Maximum Budget</p>
                                <p class="font-medium">$<?= number_format($preferences->budget_max, 2) ?></p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                
                <div class="border-t border-gray-200 py-4">
                    <h3 class="text-lg font-semibold mb-3">Lifestyle Preferences</h3>
                    
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-4 mb-6">
                        <div>
                            <p class="text-sm text-gray-600">Sleeping Habits</p>
                            <p class="font-medium">
                                <?= $preferences->early_bird ? 'Early riser' : 'Night owl' ?>
                            </p>
                        </div>
                        
                        <div>
                            <p class="text-sm text-gray-600">Study Environment</p>
                            <p class="font-medium">
                                <?= $preferences->quiet_study ? 'Prefers quiet' : 'Flexible' ?>
                            </p>
                        </div>
                        
                        <div>
                            <p class="text-sm text-gray-600">Partying</p>
                            <p class="font-medium">
                                <?= $preferences->partying ? 'Enjoys partying' : 'Prefers quiet' ?>
                            </p>
                        </div>
                        
                        <?php if (isset($preferences->cleanliness_level)): ?>
                            <div>
                                <p class="text-sm text-gray-600">Cleanliness</p>
                                <div class="flex items-center">
                                    <?php for ($i = 1; $i <= 5; $i++): ?>
                                        <span class="<?= $i <= $preferences->cleanliness_level ? 'text-yellow-400' : 'text-gray-300' ?>">★</span>
                                    <?php endfor; ?>
                                </div>
                            </div>
                        <?php endif; ?>
                        
                        <?php if (isset($preferences->social_level)): ?>
                            <div>
                                <p class="text-sm text-gray-600">Social Level</p>
                                <div class="flex items-center">
                                    <?php for ($i = 1; $i <= 5; $i++): ?>
                                        <span class="<?= $i <= $preferences->social_level ? 'text-yellow-400' : 'text-gray-300' ?>">★</span>
                                    <?php endfor; ?>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                
                <?php if ($preferences->shared_items): ?>
                    <div class="border-t border-gray-200 py-4">
                        <h3 class="text-lg font-semibold mb-3">Willing to Share</h3>
                        
                        <div class="flex flex-wrap gap-2">
                            <?php foreach (json_decode($preferences->shared_items, true) ?: [] as $item): ?>
                                <span class="px-2 py-1 bg-indigo-100 text-indigo-700 rounded-full text-sm">
                                    <?= htmlspecialchars($item) ?>
                                </span>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endif; ?>
                
                <?php if ($preferences->additional_preferences): ?>
                    <div class="border-t border-gray-200 py-4">
                        <h3 class="text-lg font-semibold mb-3">Additional Notes</h3>
                        <div class="bg-gray-50 p-3 rounded-md">
                            <p><?= nl2br(htmlspecialchars($preferences->additional_preferences)) ?></p>
                        </div>
                    </div>
                <?php endif; ?>
                
                <div class="mt-6 flex justify-between">
                    <a href="/roommate/preferences/edit" class="px-4 py-2 bg-indigo-100 text-indigo-700 rounded-md hover:bg-indigo-200">
                        Edit Preferences
                    </a>
                    
                    <a href="/roommate/matches" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">
                        Find Matches
                    </a>
                </div>
            <?php else: ?>
                <div class="py-8 text-center">
                    <svg class="mx-auto h-16 w-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                    </svg>
                    <h2 class="mt-2 text-lg font-medium text-gray-900">No Preferences Set</h2>
                    <p class="mt-1 text-sm text-gray-500">You haven't set your roommate preferences yet.</p>
                    <div class="mt-6">
                        <a href="/roommate/preferences/edit" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">
                            Set Your Preferences
                        </a>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php include(__DIR__ . '/../../partials/footer.php'); ?>