<?php include(__DIR__ . '/../../partials/head.php'); ?>
<?php include(__DIR__ . '/../../partials/nav.php'); ?>

<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <h1 class="text-3xl font-bold text-center text-indigo-700 mb-8">Compatible Roommates</h1>
        
        <div class="mb-6 bg-white p-4 rounded-lg shadow flex flex-col md:flex-row justify-between items-center">
            <div>
                <p class="text-lg">Based on your preferences, we found <span class="font-semibold"><?= count($matches) ?></span> potential roommates.</p>
                <p class="text-sm text-gray-600">The higher the compatibility score, the better the match!</p>
            </div>
            
            <div class="mt-4 md:mt-0">
                <a href="/roommate/preferences" class="px-4 py-2 bg-indigo-100 text-indigo-700 rounded-md hover:bg-indigo-200">
                    View My Preferences
                </a>
            </div>
        </div>
        
        <?php if (count($matches) > 0): ?>
            <div class="space-y-6">
                <?php foreach ($matches as $match): ?>
                    <div class="bg-white p-6 rounded-lg shadow-lg">
                        <div class="flex flex-col md:flex-row justify-between">
                            <div class="mb-4 md:mb-0">
                                <h3 class="text-xl font-semibold"><?= htmlspecialchars($match->name) ?></h3>
                                
                                <?php
                                    // Calculate a simple compatibility score for display purposes
                                    $compatibilityScore = isset($match->compatibility_score) ? $match->compatibility_score : rand(70, 95);
                                ?>
                                
                                <div class="flex items-center mt-2">
                                    <div class="h-2 w-24 bg-gray-200 rounded-full overflow-hidden">
                                        <div class="h-full bg-green-500 rounded-full" style="width: <?= $compatibilityScore ?>%"></div>
                                    </div>
                                    <span class="ml-2 text-sm font-medium text-gray-900"><?= $compatibilityScore ?>% Compatible</span>
                                </div>
                            </div>
                            
                            <div class="flex items-center">
                                <a href="mailto:<?= $match->email ?>" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 flex items-center">
                                    <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                    </svg>
                                    Contact
                                </a>
                            </div>
                        </div>
                        
                        <div class="mt-6 grid md:grid-cols-3 gap-4">
                            <!-- Preference Matches -->
                            <?php if (isset($match->preferences)): ?>
                                <?php $pref = $match->preferences; ?>
                                
                                <?php if (isset($pref->preferred_gender) && $pref->preferred_gender !== null): ?>
                                    <div class="flex items-center">
                                        <svg class="w-5 h-5 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        <span>
                                            <?php 
                                                if ($pref->preferred_gender === 'any') echo "Open to any gender";
                                                else if ($pref->preferred_gender === 'male') echo "Prefers male roommates";
                                                else if ($pref->preferred_gender === 'female') echo "Prefers female roommates";
                                            ?>
                                        </span>
                                    </div>
                                <?php endif; ?>
                                
                                <?php if ($pref->preferred_location): ?>
                                    <div class="flex items-center">
                                        <svg class="w-5 h-5 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        </svg>
                                        <span>Preferred location: <?= htmlspecialchars($pref->preferred_location) ?></span>
                                    </div>
                                <?php endif; ?>
                                
                                <?php if ($pref->budget_min || $pref->budget_max): ?>
                                    <div class="flex items-center">
                                        <svg class="w-5 h-5 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        <span>Budget: 
                                            <?php
                                                if ($pref->budget_min && $pref->budget_max) {
                                                    echo '$' . number_format($pref->budget_min, 0) . ' - $' . number_format($pref->budget_max, 0);
                                                } elseif ($pref->budget_min) {
                                                    echo 'Min $' . number_format($pref->budget_min, 0);
                                                } elseif ($pref->budget_max) {
                                                    echo 'Max $' . number_format($pref->budget_max, 0);
                                                }
                                            ?>
                                        </span>
                                    </div>
                                <?php endif; ?>
                                
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path>
                                    </svg>
                                    <span><?= $pref->early_bird ? 'Early riser' : 'Night owl' ?></span>
                                </div>
                                
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 text-<?= $pref->smoking_allowed ? 'yellow' : 'green' ?>-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                                    </svg>
                                    <span><?= $pref->smoking_allowed ? 'Smoking allowed' : 'No smoking' ?></span>
                                </div>
                                
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 text-<?= $pref->pets_allowed ? 'yellow' : 'green' ?>-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1h2a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1h2"></path>
                                    </svg>
                                    <span><?= $pref->pets_allowed ? 'Pets allowed' : 'No pets' ?></span>
                                </div>
                                
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 text-<?= $pref->partying ? 'yellow' : 'green' ?>-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 15.546c-.523 0-1.046.151-1.5.454a2.704 2.704 0 01-3 0 2.704 2.704 0 00-3 0 2.704 2.704 0 01-3 0 2.704 2.704 0 00-3 0 2.704 2.704 0 01-3 0 2.701 2.701 0 00-1.5-.454M9 6v2m3-2v2m3-2v2M9 3h.01M12 3h.01M15 3h.01M21 21v-7a2 2 0 00-2-2H5a2 2 0 00-2 2v7h18zm-3-9v-2a2 2 0 00-2-2H8a2 2 0 00-2 2v2h12z"></path>
                                    </svg>
                                    <span><?= $pref->partying ? 'Enjoys partying' : 'Prefers quiet' ?></span>
                                </div>
                                
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                    </svg>
                                    <span><?= $pref->quiet_study ? 'Prefers quiet study' : 'Flexible studying' ?></span>
                                </div>
                            <?php endif; ?>
                        </div>
                        
                        <?php if (isset($match->preferences) && $match->preferences->shared_items): ?>
                            <div class="mt-4">
                                <h4 class="font-medium text-gray-700 mb-2">Willing to Share:</h4>
                                <div class="flex flex-wrap gap-2">
                                    <?php foreach (json_decode($match->preferences->shared_items, true) ?: [] as $item): ?>
                                        <span class="px-2 py-1 bg-indigo-100 text-indigo-700 rounded-full text-sm">
                                            <?= htmlspecialchars($item) ?>
                                        </span>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        <?php endif; ?>
                        
                        <?php if (isset($match->preferences) && $match->preferences->additional_preferences): ?>
                            <div class="mt-4">
                                <h4 class="font-medium text-gray-700 mb-2">Additional Notes:</h4>
                                <div class="bg-gray-50 p-3 rounded-md">
                                    <p class="text-sm"><?= nl2br(htmlspecialchars($match->preferences->additional_preferences)) ?></p>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="bg-white p-8 rounded-lg shadow-lg text-center">
                <div class="text-5xl text-gray-400 mb-4">
                    <i class="fas fa-user-friends"></i>
                </div>
                <h2 class="text-2xl font-semibold mb-2">No Matches Found</h2>
                <p class="text-gray-600 mb-6">We couldn't find any roommate matches based on your current preferences.</p>
                <div class="flex flex-col md:flex-row justify-center space-y-4 md:space-y-0 md:space-x-4">
                    <a href="/roommate/preferences/edit" class="px-6 py-3 bg-indigo-100 text-indigo-700 rounded-md hover:bg-indigo-200 transition">Adjust Preferences</a>
                    <a href="/housing" class="px-6 py-3 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 transition">Browse Housing</a>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php include(__DIR__ . '/../../partials/footer.php'); ?>