<?php include(__DIR__ . '/../partials/head.php'); ?>
<?php include(__DIR__ . '/../partials/nav.php'); ?>

<div class="container mx-auto mt-8 max-w-3xl px-4 pb-12">
    <!-- Breadcrumbs -->
    <div class="flex items-center mb-6 text-sm">
        <a href="/housing" class="text-indigo-600 hover:text-indigo-800">
            <i class="fas fa-home"></i> Housing
        </a>
        <i class="fas fa-chevron-right mx-2 text-gray-400 text-xs"></i>
        <span class="text-gray-600">Post New Housing</span>
    </div>

    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        <!-- Form Header -->
        <div class="bg-gradient-to-r from-indigo-600 to-purple-700 p-6 md:p-8 text-white">
            <h1 class="text-2xl md:text-3xl font-bold flex items-center">
                <i class="fas fa-plus-circle mr-3"></i>
                Post New Housing
            </h1>
            <p class="text-indigo-100 mt-2">Share your rental listing with university students</p>
        </div>
    
        <div class="p-6 md:p-8">
            <form action="/housing" method="POST" enctype="multipart/form-data" class="space-y-6" x-data="{ showHelp: false }">
                <?= csrf_field() ?>
                
                <!-- Form Tips -->
                <div class="mb-6 bg-blue-50 rounded-lg p-4 border border-blue-200">
                    <div class="flex justify-between items-center cursor-pointer" @click="showHelp = !showHelp">
                        <div class="flex items-center text-blue-700 font-medium">
                            <i class="fas fa-lightbulb text-yellow-500 mr-2 text-xl"></i>
                            <span>Tips for a great housing post</span>
                        </div>
                        <i class="fas" :class="showHelp ? 'fa-chevron-up' : 'fa-chevron-down'"></i>
                    </div>
                    
                    <div x-show="showHelp" class="mt-3 text-blue-800 text-sm">
                        <ul class="list-disc ml-5 space-y-1">
                            <li>Use a descriptive title that highlights key features</li>
                            <li>Include specific details about the location (proximity to campus, etc.)</li>
                            <li>Mention any special amenities like laundry, parking, or internet</li>
                            <li>Be clear about move-in dates and duration of availability</li>
                            <li>Include specific roommate preferences if applicable</li>
                        </ul>
                    </div>
                </div>
                
                <!-- Title Field -->
                <div>
                    <label class="block font-semibold text-gray-800 mb-2 flex items-center">
                        <i class="fas fa-heading text-indigo-600 mr-2"></i>Title
                    </label>
                    <input type="text" name="title" placeholder="e.g., Cozy 2 bedroom apartment near campus" 
                        class="w-full border border-gray-300 p-3 rounded-lg focus:ring-2 focus:ring-indigo-400 focus:border-indigo-500 focus:outline-none transition-colors" required>
                    <p class="text-sm text-gray-500 mt-1">A catchy title will attract more interest</p>
                </div>
                
                <!-- Location Field -->
                <div>
                    <label class="block font-semibold text-gray-800 mb-2 flex items-center">
                        <i class="fas fa-map-marker-alt text-indigo-600 mr-2"></i>Location
                    </label>
                    <input type="text" name="location" placeholder="e.g., 123 University Ave, City" 
                        class="w-full border border-gray-300 p-3 rounded-lg focus:ring-2 focus:ring-indigo-400 focus:border-indigo-500 focus:outline-none transition-colors" required>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Rent Amount Field -->
                    <div>
                        <label class="block font-semibold text-gray-800 mb-2 flex items-center">
                            <i class="fas fa-dollar-sign text-indigo-600 mr-2"></i>Monthly Rent ($)
                        </label>
                        <input type="number" name="rent_amount" min="0" step="0.01" 
                            class="w-full border border-gray-300 p-3 rounded-lg focus:ring-2 focus:ring-indigo-400 focus:border-indigo-500 focus:outline-none transition-colors" required>
                    </div>
                    
                    <!-- Available From Field -->
                    <div>
                        <label class="block font-semibold text-gray-800 mb-2 flex items-center">
                            <i class="fas fa-calendar-alt text-indigo-600 mr-2"></i>Available From
                        </label>
                        <input type="date" name="available_from" 
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
                            <option value="">Select type</option>
                            <option value="apartment">Apartment</option>
                            <option value="house">House</option>
                            <option value="room">Room</option>
                            <option value="studio">Studio</option>
                        </select>
                    </div>
                    
                    <!-- Bedrooms Field -->
                    <div>
                        <label class="block font-semibold text-gray-800 mb-2 flex items-center">
                            <i class="fas fa-bed text-indigo-600 mr-2"></i>Bedrooms
                        </label>
                        <input type="number" name="bedrooms" min="0" 
                            class="w-full border border-gray-300 p-3 rounded-lg focus:ring-2 focus:ring-indigo-400 focus:border-indigo-500 focus:outline-none transition-colors" required>
                    </div>
                    
                    <!-- Bathrooms Field -->
                    <div>
                        <label class="block font-semibold text-gray-800 mb-2 flex items-center">
                            <i class="fas fa-bath text-indigo-600 mr-2"></i>Bathrooms
                        </label>
                        <input type="number" name="bathrooms" min="0" step="0.5" 
                            class="w-full border border-gray-300 p-3 rounded-lg focus:ring-2 focus:ring-indigo-400 focus:border-indigo-500 focus:outline-none transition-colors" required>
                    </div>
                </div>
                
                <!-- Contact Phone Field -->
                <div>
                    <label class="block font-semibold text-gray-800 mb-2 flex items-center">
                        <i class="fas fa-phone text-indigo-600 mr-2"></i>Contact Phone (optional)
                    </label>
                    <input type="tel" name="contact_phone" placeholder="Your phone number" 
                        class="w-full border border-gray-300 p-3 rounded-lg focus:ring-2 focus:ring-indigo-400 focus:border-indigo-500 focus:outline-none transition-colors">
                    <p class="text-sm text-gray-500 mt-1">This will be visible to other students</p>
                </div>
                
                <!-- Utilities Field -->
                <div class="bg-gray-50 p-4 rounded-lg">
                    <div class="flex items-center mb-1">
                        <input type="hidden" name="utilities_included" value="0">
                        <input type="checkbox" name="utilities_included" id="utilities_included" value="1" class="mr-2 h-5 w-5 text-indigo-600 focus:ring-indigo-500 rounded transition-colors">
                        <label for="utilities_included" class="font-semibold text-gray-800 flex items-center">
                            <i class="fas fa-bolt text-indigo-600 mr-2"></i>Utilities included in rent
                        </label>
                    </div>
                    <p class="text-sm text-gray-500 ml-7">Check if water, electricity, gas, internet, etc. are included in the rent price</p>
                </div>
                
                <!-- Description Field -->
                <div>
                    <label class="block font-semibold text-gray-800 mb-2 flex items-center">
                        <i class="fas fa-align-left text-indigo-600 mr-2"></i>Description
                    </label>
                    <textarea name="description" rows="5" placeholder="Describe the property, amenities, rules, etc." 
                        class="w-full border border-gray-300 p-3 rounded-lg focus:ring-2 focus:ring-indigo-400 focus:border-indigo-500 focus:outline-none transition-colors" required></textarea>
                </div>
                
                <!-- Photos Field -->
                <div>
                    <label class="block font-semibold text-gray-800 mb-2 flex items-center">
                        <i class="fas fa-images text-indigo-600 mr-2"></i>Property Photos
                    </label>
                    <input type="file" name="photos[]" accept="image/*" multiple 
                        class="w-full border border-gray-300 p-3 rounded-lg focus:ring-2 focus:ring-indigo-400 focus:border-indigo-500 focus:outline-none transition-colors">
                    <p class="text-sm text-gray-500 mt-1">Upload up to 10 photos (5MB max per photo)</p>
                </div>
                
                <!-- Submit Button -->
                <div class="pt-6 flex flex-col md:flex-row md:justify-between space-y-4 md:space-y-0">
                    <a href="/housing" class="px-6 py-3 bg-gray-200 text-gray-700 font-semibold rounded-lg hover:bg-gray-300 transition-colors text-center">
                        <i class="fas fa-arrow-left mr-2"></i>Cancel
                    </a>
                    <button type="submit" class="px-8 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 text-white font-bold rounded-lg hover:from-indigo-700 hover:to-purple-700 transition-colors flex items-center justify-center">
                        <i class="fas fa-paper-plane mr-2"></i>
                        Post Housing Listing
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include(__DIR__ . '/../partials/tail.php'); ?>