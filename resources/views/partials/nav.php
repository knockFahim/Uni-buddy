<?php use Illuminate\Support\Facades\Auth; ?>

<nav class="bg-gradient-to-r from-indigo-800 to-purple-900 text-white shadow-lg sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            <!-- Brand -->
            <div class="flex items-center">
                <a href="/thesis" class="flex items-center">
                    <i class="fas fa-graduation-cap text-2xl text-yellow-400 mr-2"></i>
                    <span class="text-2xl font-extrabold tracking-tight hover:text-yellow-300 transition">
                        Uni<span class="text-yellow-400">Buddy</span>
                    </span>
                </a>
            </div>

            <!-- Mobile menu button -->
            <div class="md:hidden" x-data="{ open: false }">
                <button @click="open = !open" class="text-white p-2 focus:outline-none">
                    <i class="fas fa-bars text-xl"></i>
                </button>
                
                <!-- Mobile Menu -->
                <div x-show="open" @click.outside="open = false" class="absolute top-16 right-0 left-0 bg-indigo-900 shadow-lg p-4">
                    <?php if (Auth::check()): ?>
                        <?php if (Auth::user()->is_admin): ?>
                            <a href="/admin" class="block py-2 text-yellow-400 hover:text-yellow-300 font-semibold">
                                <i class="fas fa-cog mr-1"></i>Admin Dashboard
                            </a>
                            <div class="border-t border-indigo-700 my-2"></div>
                        <?php endif; ?>
                        <a href="/thesis" class="block py-2 text-white hover:text-yellow-300">Thesis Dashboard</a>
                        <a href="/thesis/create" class="block py-2 text-white hover:text-yellow-300">Create Thesis Post</a>
                        <a href="/thesis/my-posts" class="block py-2 text-white hover:text-yellow-300">My Thesis Posts</a>
                        <a href="/thesis/requests" class="block py-2 text-white hover:text-yellow-300">Thesis Requests</a>
                        <div class="border-t border-indigo-700 my-2"></div>
                        <a href="/housing" class="block py-2 text-white hover:text-yellow-300">Find Housing</a>
                        <a href="/housing/create" class="block py-2 text-white hover:text-yellow-300">Post Housing</a>
                        <a href="/housing/my-posts" class="block py-2 text-white hover:text-yellow-300">My Housing Posts</a>
                        <div class="border-t border-indigo-700 my-2"></div>
                        <form action="/logout" method="POST">
                            <?= csrf_field() ?>
                            <button type="submit" class="block w-full text-left py-2 text-red-300 hover:text-red-400">Logout</button>
                        </form>
                    <?php else: ?>
                        <a href="/thesis" class="block py-2 text-white hover:text-yellow-300">Thesis</a>
                        <a href="/housing" class="block py-2 text-white hover:text-yellow-300">Housing</a>
                        <div class="border-t border-indigo-700 my-2"></div>
                        <a href="/login" class="block py-2 text-white hover:text-yellow-300">Login</a>
                        <a href="/register" class="block py-2 text-white hover:text-yellow-300">Register</a>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Desktop Navigation Links -->
            <div class="hidden md:flex space-x-6 items-center">
                <?php if (Auth::check()): ?>
                    <?php if (Auth::user()->is_admin): ?>
                        <a href="/admin" class="flex items-center px-3 py-1 bg-yellow-500 text-white rounded-md hover:bg-yellow-600 transition-colors">
                            <i class="fas fa-cog mr-1"></i>Admin
                        </a>
                    <?php endif; ?>
                    <div class="relative group" x-data="{ open: false }">
                        <button @click="open = !open" class="flex items-center space-x-1 hover:text-yellow-300 transition">
                            <i class="fas fa-book-open mr-1"></i>
                            <span>Thesis</span>
                            <i class="fas fa-chevron-down text-xs"></i>
                        </button>
                        <div x-show="open" @click.outside="open = false" class="absolute z-10 mt-2 w-48 rounded-md shadow-lg bg-white text-gray-800 overflow-hidden transition-all">
                            <div class="py-1">
                                <a href="/thesis" class="flex items-center px-4 py-2 hover:bg-indigo-100 transition-colors">
                                    <i class="fas fa-search text-indigo-600 mr-2"></i>Browse Thesis Posts
                                </a>
                                <a href="/thesis/create" class="flex items-center px-4 py-2 hover:bg-indigo-100 transition-colors">
                                    <i class="fas fa-plus text-indigo-600 mr-2"></i>Create Thesis Post
                                </a>
                                <a href="/thesis/my-posts" class="flex items-center px-4 py-2 hover:bg-indigo-100 transition-colors">
                                    <i class="fas fa-clipboard-list text-indigo-600 mr-2"></i>My Thesis Posts
                                </a>
                                <a href="/thesis/requests" class="flex items-center px-4 py-2 hover:bg-indigo-100 transition-colors">
                                    <i class="fas fa-envelope text-indigo-600 mr-2"></i>Thesis Requests
                                </a>
                            </div>
                        </div>
                    </div>
                    
                    <div class="relative group" x-data="{ open: false }">
                        <button @click="open = !open" class="flex items-center space-x-1 hover:text-yellow-300 transition">
                            <i class="fas fa-home mr-1"></i>
                            <span>Housing</span>
                            <i class="fas fa-chevron-down text-xs"></i>
                        </button>
                        <div x-show="open" @click.outside="open = false" class="absolute z-10 mt-2 w-48 rounded-md shadow-lg bg-white text-gray-800 overflow-hidden transition-all">
                            <div class="py-1">
                                <a href="/housing" class="flex items-center px-4 py-2 hover:bg-indigo-100 transition-colors">
                                    <i class="fas fa-search text-indigo-600 mr-2"></i>Find Housing
                                </a>
                                <a href="/housing/create" class="flex items-center px-4 py-2 hover:bg-indigo-100 transition-colors">
                                    <i class="fas fa-plus text-indigo-600 mr-2"></i>Post Housing
                                </a>
                                <a href="/housing/my-posts" class="flex items-center px-4 py-2 hover:bg-indigo-100 transition-colors">
                                    <i class="fas fa-clipboard-list text-indigo-600 mr-2"></i>My Housing Posts
                                </a>
                            </div>
                        </div>
                    </div>

                    <span class="text-gray-400">|</span>
                    
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" class="flex items-center hover:text-yellow-300 transition">
                            <i class="fas fa-user-circle text-xl mr-1"></i>
                            <span><?= htmlspecialchars(Auth::user()->name) ?></span>
                            <i class="fas fa-chevron-down text-xs ml-1"></i>
                        </button>
                        <div x-show="open" @click.outside="open = false" class="absolute right-0 z-10 mt-2 w-48 rounded-md shadow-lg bg-white overflow-hidden">
                            <form action="/logout" method="POST">
                                <?= csrf_field() ?>
                                <button type="submit" class="flex w-full items-center px-4 py-2 text-gray-800 hover:bg-red-100 transition-colors">
                                    <i class="fas fa-sign-out-alt text-red-600 mr-2"></i>Logout
                                </button>
                            </form>
                        </div>
                    </div>
                <?php else: ?>
                    <a href="/thesis" class="flex items-center hover:text-yellow-300 transition">
                        <i class="fas fa-book-open mr-1"></i>Thesis
                    </a>
                    <a href="/housing" class="flex items-center hover:text-yellow-300 transition">
                        <i class="fas fa-home mr-1"></i>Housing
                    </a>
                    <span class="text-gray-400">|</span>
                    <a href="/login" class="flex items-center hover:text-yellow-300 transition">
                        <i class="fas fa-sign-in-alt mr-1"></i>Login
                    </a>
                    <a href="/register" class="flex items-center px-4 py-1.5 rounded-md bg-yellow-500 hover:bg-yellow-600 text-white font-medium transition-colors">
                        <i class="fas fa-user-plus mr-1"></i>Register
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</nav>
