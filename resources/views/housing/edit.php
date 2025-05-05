<?php include(__DIR__ . '/../partials/head.php'); ?>
<?php include(__DIR__ . '/../partials/nav.php'); ?>

<div class="container mx-auto mt-8 max-w-3xl px-4 pb-12">
    <!-- Breadcrumbs -->
    <div class="flex items-center mb-6 text-sm">
        <a href="/housing" class="text-indigo-600 hover:text-indigo-800">
            <i class="fas fa-home"></i> Housing
        </a>
        <i class="fas fa-chevron-right mx-2 text-gray-400 text-xs"></i>
        <a href="/housing/<?= $housingPost->id ?>" class="text-indigo-600 hover:text-indigo-800">
            Listing Details
        </a>
        <i class="fas fa-chevron-right mx-2 text-gray-400 text-xs"></i>
        <span class="text-gray-600">Edit Listing</span>
    </div>

    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        <!-- Form Header -->
        <div class="bg-gradient-to-r from-indigo-600 to-purple-700 p-6 md:p-8 text-white">
            <h1 class="text-2xl md:text-3xl font-bold flex items-center">
                <i class="fas fa-edit mr-3"></i>
                Edit Housing Post
            </h1>
            <p class="text-indigo-100 mt-2">Update your rental listing information</p>
        </div>
    
        <div class="p-6 md:p-8">
            <form action="/housing/<?= $housingPost->id ?>" method="POST" class="space-y-6">
                <?= csrf_field() ?>
                
                <!-- Title Field -->
                <div>
                    <label class="block font-semibold text-gray-800 mb-2 flex items-center">
                        <i class="fas fa-heading text-indigo-600 mr-2"></i>Title
                    </label>
                    <input type="text" name="title" value="<?= htmlspecialchars($housingPost->title) ?>" 
                        class="w-full border border-gray-300 p-3 rounded-lg focus:ring-2 focus:ring-indigo-400 focus:border-indigo-500 focus:outline-none transition-colors" required>
                </div>
                
                <!-- Location Field -->
                <div>
                    <label class="block font-semibold text-gray-800 mb-2 flex items-center">
                        <i class="fas fa-map-marker-alt text-indigo-600 mr-2"></i>Location
                    </label>
                    <input type="text" name="location" value="<?= htmlspecialchars($housingPost->location) ?>" 
                        class="w-full border border-gray-300 p-3 rounded-lg focus:ring-2 focus:ring-indigo-400 focus:border-indigo-500 focus:outline-none transition-colors" required>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Rent Amount Field -->
                    <div>
                        <label class="block font-semibold text-gray-800 mb-2 flex items-center">
                            <i class="fas fa-dollar-sign text-indigo-600 mr-2"></i>Monthly Rent ($)
                        </label>
                        <input type="number" name="rent_amount" min="0" step="0.01" value="<?= $housingPost->rent_amount ?>" 
                            class="w-full border border-gray-300 p-3 rounded-lg focus:ring-2 focus:ring-indigo-400 focus:border-indigo-500 focus:outline-none transition-colors" required>
                    </div>
                    
                    <!-- Available From Field -->
                    <div>
                        <label class="block font-semibold text-gray-800 mb-2 flex items-center">
                            <i class="fas fa-calendar-alt text-indigo-600 mr-2"></i>Available From
                        </label>
                        <input type="date" name="available_from" value="<?= $housingPost->available_from->format('Y-m-d') ?>" 
                            class="w-full border border-gray-300 p-3 rounded-lg focus:ring-2 focus:ring-indigo-400 focus:border-indigo-500 focus:outline-none transition-colors" required>
                    </div>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Property Type Field -->
                    <div>
                        <label class="block font-semibold text-gray-800 mb-2 flex items-center">
                            <i class="fas fa-building text-indigo-600 mr-2"></i>Property Type
                        </label>
                        <select name="property_type" class="w-full border border-gray-300 p-3 rounded-lg focus:ring-2 focus:ring-indigo-400 focus:border-indigo-500 focus:outline-none transition-colors" required>
                            <option value="apartment" <?= $housingPost->property_type === 'apartment' ? 'selected' : '' ?>>Apartment</option>
                            <option value="house" <?= $housingPost->property_type === 'house' ? 'selected' : '' ?>>House</option>
                            <option value="room" <?= $housingPost->property_type === 'room' ? 'selected' : '' ?>>Room</option>
                            <option value="studio" <?= $housingPost->property_type === 'studio' ? 'selected' : '' ?>>Studio</option>
                        </select>
                    </div>
                    
                    <!-- Bedrooms Field -->
                    <div>
                        <label class="block font-semibold text-gray-800 mb-2 flex items-center">
                            <i class="fas fa-bed text-indigo-600 mr-2"></i>Bedrooms
                        </label>
                        <input type="number" name="bedrooms" min="0" value="<?= $housingPost->bedrooms ?>" 
                            class="w-full border border-gray-300 p-3 rounded-lg focus:ring-2 focus:ring-indigo-400 focus:border-indigo-500 focus:outline-none transition-colors" required>
                    </div>
                    
                    <!-- Bathrooms Field -->
                    <div>
                        <label class="block font-semibold text-gray-800 mb-2 flex items-center">
                            <i class="fas fa-bath text-indigo-600 mr-2"></i>Bathrooms
                        </label>
                        <input type="number" name="bathrooms" min="0" step="0.5" value="<?= $housingPost->bathrooms ?>" 
                            class="w-full border border-gray-300 p-3 rounded-lg focus:ring-2 focus:ring-indigo-400 focus:border-indigo-500 focus:outline-none transition-colors" required>
                    </div>
                </div>
                
                <!-- Contact Phone Field -->
                <div>
                    <label class="block font-semibold text-gray-800 mb-2 flex items-center">
                        <i class="fas fa-phone text-indigo-600 mr-2"></i>Contact Phone (optional)
                    </label>
                    <input type="tel" name="contact_phone" value="<?= htmlspecialchars($housingPost->contact_phone ?? '') ?>" 
                        class="w-full border border-gray-300 p-3 rounded-lg focus:ring-2 focus:ring-indigo-400 focus:border-indigo-500 focus:outline-none transition-colors">
                </div>
                
                <!-- Status Options -->
                <div class="bg-gray-50 p-5 rounded-lg space-y-3">
                    <div class="flex items-center">
                        <input type="hidden" name="utilities_included" value="0">
                        <input type="checkbox" name="utilities_included" id="utilities_included" value="1" <?= $housingPost->utilities_included ? 'checked' : '' ?> class="mr-2 h-5 w-5 text-indigo-600 focus:ring-indigo-500 rounded transition-colors">
                        <label for="utilities_included" class="font-semibold text-gray-800 flex items-center">
                            <i class="fas fa-bolt text-indigo-600 mr-2"></i>Utilities included in rent
                        </label>
                    </div>
                    
                    <div class="border-t border-gray-200 pt-3">
                        <div class="flex items-center">
                            <input type="hidden" name="is_available" value="0">
                            <input type="checkbox" name="is_available" id="is_available" value="1" <?= $housingPost->is_available ? 'checked' : '' ?> class="mr-2 h-5 w-5 text-indigo-600 focus:ring-indigo-500 rounded transition-colors">
                            <label for="is_available" class="font-semibold text-gray-800 flex items-center">
                                <i class="fas fa-check-circle text-green-600 mr-2"></i>This property is still available
                            </label>
                        </div>
                        <p class="text-sm text-gray-500 ml-7">Uncheck this if the property has been rented out</p>
                    </div>
                </div>
                
                <!-- Description Field -->
                <div>
                    <label class="block font-semibold text-gray-800 mb-2 flex items-center">
                        <i class="fas fa-align-left text-indigo-600 mr-2"></i>Description
                    </label>
                    <textarea name="description" rows="5" 
                        class="w-full border border-gray-300 p-3 rounded-lg focus:ring-2 focus:ring-indigo-400 focus:border-indigo-500 focus:outline-none transition-colors" required><?= htmlspecialchars($housingPost->description) ?></textarea>
                </div>
                
                <!-- Submit Button -->
                <div class="pt-6 flex flex-col md:flex-row md:justify-between space-y-4 md:space-y-0">
                    <a href="/housing/<?= $housingPost->id ?>" class="px-6 py-3 bg-gray-200 text-gray-700 font-semibold rounded-lg hover:bg-gray-300 transition-colors text-center">
                        <i class="fas fa-times mr-2"></i>Cancel
                    </a>
                    <button type="submit" class="px-8 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-bold rounded-lg hover:from-blue-700 hover:to-indigo-700 transition-colors flex items-center justify-center">
                        <i class="fas fa-save mr-2"></i>
                        Update Housing Post
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include(__DIR__ . '/../partials/tail.php'); ?>