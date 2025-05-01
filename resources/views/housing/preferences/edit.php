<?php include(__DIR__ . '/../../partials/head.php'); ?>
<?php include(__DIR__ . '/../../partials/nav.php'); ?>

<div class="container mx-auto px-4 py-8">
    <div class="max-w-3xl mx-auto">
        <h1 class="text-3xl font-bold text-center text-indigo-700 mb-8">Set Your Roommate Preferences</h1>
        
        <div class="bg-white p-6 rounded-lg shadow-lg">
            <form action="/roommate/preferences" method="POST" class="space-y-6">
                <?= csrf_field() ?>
                
                <div class="mb-6">
                    <div class="flex items-center">
                        <input type="checkbox" id="has_roommate_preferences" name="has_roommate_preferences" 
                               class="h-5 w-5 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded"
                               <?= $preferences->has_roommate_preferences ? 'checked' : '' ?>>
                        <label for="has_roommate_preferences" class="ml-2 block text-lg font-medium text-gray-700">
                            I am currently looking for a roommate
                        </label>
                    </div>
                    <p class="mt-1 text-sm text-gray-500">
                        Check this box if you want to be included in roommate matching. Other students will be able to see your basic profile information.
                    </p>
                </div>
                
                <div class="border-t border-gray-200 pt-6">
                    <h2 class="text-xl font-semibold text-gray-800 mb-4">Basic Preferences</h2>
                    
                    <div class="grid md:grid-cols-2 gap-6">
                        <div>
                            <label for="gender_preference" class="block text-sm font-medium text-gray-700 mb-1">Gender Preference</label>
                            <select name="gender_preference" id="gender_preference"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                                <option value="any" <?= $preferences->preferred_gender == 'any' ? 'selected' : '' ?>>Any gender is fine</option>
                                <option value="male" <?= $preferences->preferred_gender == 'male' ? 'selected' : '' ?>>Male</option>
                                <option value="female" <?= $preferences->preferred_gender == 'female' ? 'selected' : '' ?>>Female</option>
                            </select>
                        </div>
                        
                        <div>
                            <label for="smoking_preference" class="block text-sm font-medium text-gray-700 mb-1">Smoking Preference</label>
                            <select name="smoking_preference" id="smoking_preference"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                                <option value="no" <?= $preferences->smoking_allowed ? '' : 'selected' ?>>No smoking</option>
                                <option value="outdoors_only" <?= $preferences->smoking_allowed ? 'selected' : '' ?>>Outdoors only</option>
                                <option value="yes" <?= $preferences->smoking_allowed ? 'selected' : '' ?>>Smoking allowed</option>
                                <option value="indifferent">No preference</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="grid md:grid-cols-2 gap-6 mt-4">
                        <div>
                            <label for="pets_preference" class="block text-sm font-medium text-gray-700 mb-1">Pets Preference</label>
                            <select name="pets_preference" id="pets_preference"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                                <option value="no" <?= $preferences->pets_allowed ? '' : 'selected' ?>>No pets</option>
                                <option value="small_only">Small pets only</option>
                                <option value="yes" <?= $preferences->pets_allowed ? 'selected' : '' ?>>Pets allowed</option>
                                <option value="indifferent">No preference</option>
                            </select>
                        </div>
                        
                        <div>
                            <label for="preferred_location" class="block text-sm font-medium text-gray-700 mb-1">Preferred Location</label>
                            <input type="text" name="preferred_location" id="preferred_location" 
                                   value="<?= htmlspecialchars($preferences->preferred_location ?? '') ?>"
                                   placeholder="e.g., North Campus, Downtown"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        </div>
                    </div>
                </div>
                
                <div class="border-t border-gray-200 pt-6">
                    <h2 class="text-xl font-semibold text-gray-800 mb-4">Budget</h2>
                    
                    <div class="grid md:grid-cols-2 gap-6">
                        <div>
                            <label for="budget_min" class="block text-sm font-medium text-gray-700 mb-1">Minimum Budget ($)</label>
                            <input type="number" name="budget_min" id="budget_min" min="0" step="50"
                                   value="<?= $preferences->budget_min ?? '' ?>"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        </div>
                        
                        <div>
                            <label for="budget_max" class="block text-sm font-medium text-gray-700 mb-1">Maximum Budget ($)</label>
                            <input type="number" name="budget_max" id="budget_max" min="0" step="50"
                                   value="<?= $preferences->budget_max ?? '' ?>"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        </div>
                    </div>
                </div>
                
                <div class="border-t border-gray-200 pt-6">
                    <h2 class="text-xl font-semibold text-gray-800 mb-4">Lifestyle Preferences</h2>
                    
                    <div class="grid md:grid-cols-2 gap-6">
                        <div>
                            <label for="sleeping_habits" class="block text-sm font-medium text-gray-700 mb-1">Sleeping Habits</label>
                            <select name="sleeping_habits" id="sleeping_habits"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                                <option value="early_riser" <?= $preferences->early_bird ? 'selected' : '' ?>>Early riser</option>
                                <option value="night_owl" <?= !$preferences->early_bird ? 'selected' : '' ?>>Night owl</option>
                                <option value="indifferent">No preference</option>
                            </select>
                        </div>
                        
                        <div>
                            <label for="studying_habits" class="block text-sm font-medium text-gray-700 mb-1">Studying Environment</label>
                            <select name="studying_habits" id="studying_habits"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                                <option value="quiet" <?= $preferences->quiet_study ? 'selected' : '' ?>>Quiet study environment</option>
                                <option value="moderate">Moderate noise level</option>
                                <option value="noisy">Don't mind noise</option>
                                <option value="indifferent">No preference</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="grid md:grid-cols-2 gap-6 mt-4">
                        <div>
                            <label for="cleanliness_level" class="block text-sm font-medium text-gray-700 mb-1">Cleanliness Level</label>
                            <div class="flex items-center">
                                <span class="text-sm text-gray-500 mr-2">Relaxed</span>
                                <input type="range" name="cleanliness_level" id="cleanliness_level" min="1" max="5" 
                                       value="<?= $preferences->cleanliness_level ?? 3 ?>"
                                       class="w-full">
                                <span class="text-sm text-gray-500 ml-2">Very Neat</span>
                            </div>
                        </div>
                        
                        <div>
                            <label for="social_level" class="block text-sm font-medium text-gray-700 mb-1">Social Level</label>
                            <div class="flex items-center">
                                <span class="text-sm text-gray-500 mr-2">Private</span>
                                <input type="range" name="social_level" id="social_level" min="1" max="5"
                                       value="<?= $preferences->social_level ?? 3 ?>"
                                       class="w-full">
                                <span class="text-sm text-gray-500 ml-2">Very Social</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mt-4">
                        <label for="partying" class="flex items-center">
                            <input type="checkbox" id="partying" name="partying" 
                                   class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded"
                                   <?= $preferences->partying ? 'checked' : '' ?>>
                            <span class="ml-2 text-sm text-gray-700">I enjoy hosting/attending parties</span>
                        </label>
                    </div>
                </div>
                
                <div class="border-t border-gray-200 pt-6">
                    <h2 class="text-xl font-semibold text-gray-800 mb-4">Shared Items</h2>
                    
                    <div class="space-y-2">
                        <div class="text-sm text-gray-700 mb-2">Select items you're willing to share:</div>
                        
                        <?php 
                        $shared_items = json_decode($preferences->shared_items ?? '[]', true) ?: [];
                        $items = ['Kitchen appliances', 'TV/Entertainment', 'Furniture', 'Bathroom supplies', 'Groceries', 'Cooking duties'];
                        ?>
                        
                        <?php foreach ($items as $item): ?>
                            <label class="flex items-center">
                                <input type="checkbox" name="shared_items[]" value="<?= $item ?>" 
                                       class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded"
                                       <?= in_array($item, $shared_items) ? 'checked' : '' ?>>
                                <span class="ml-2 text-sm text-gray-700"><?= $item ?></span>
                            </label>
                        <?php endforeach; ?>
                    </div>
                </div>
                
                <div>
                    <label for="additional_notes" class="block text-sm font-medium text-gray-700 mb-1">Additional Notes</label>
                    <textarea name="additional_notes" id="additional_notes" rows="4" 
                              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500"
                              placeholder="Any other preferences or information you'd like potential roommates to know..."><?= htmlspecialchars($preferences->additional_preferences ?? '') ?></textarea>
                </div>
                
                <div class="flex justify-between">
                    <a href="/roommate/preferences" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300">Cancel</a>
                    <button type="submit" class="px-6 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">Save Preferences</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include(__DIR__ . '/../../partials/footer.php'); ?>