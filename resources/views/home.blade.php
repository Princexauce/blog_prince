<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon Blog</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            background-color: #F9F8FF;
        }
    </style>
</head>
<body class="min-h-screen">
    <!-- Header -->
    <header class="bg-white shadow-sm">
        <div class="max-w-6xl mx-auto px-4 py-4 flex items-center justify-between">
            <h1 class="text-2xl font-bold text-gray-800">Mon Blog</h1>
            <nav class="flex items-center space-x-6">
                <a href="{{ route('home') }}" class="text-gray-700 hover:text-purple-600">Accueil</a>
                
                <!-- Articles Dropdown -->
                <div class="relative group" id="articlesDropdown">
                    <a href="#" class="text-gray-700 hover:text-purple-600 py-2 dropdown-trigger">Articles</a>
                    <div class="absolute right-0 mt-2 w-64 bg-white rounded-lg shadow-lg opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50 dropdown-menu">
                        <ul class="py-2">
                            @foreach($posts as $post)
                                <li>
                                    <a href="{{ route('posts.show', $post->id) }}" class="block px-4 py-2 text-gray-700 hover:bg-purple-50 hover:text-purple-600">
                                        {{ $post->titre }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                
                <!-- À propos Dropdown -->
                <div class="relative group" id="aboutDropdown">
                    <a href="#" class="text-gray-700 hover:text-purple-600 py-2 dropdown-trigger">À propos</a>
                    <div class="absolute right-0 mt-2 w-80 bg-white rounded-lg shadow-lg opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50 dropdown-menu">
                        <div class="p-6">
                            <h3 class="text-lg font-bold text-gray-800 mb-2">À propos</h3>
                            <div class="flex items-center mb-4">
                                <div class="w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center mr-4">
                                    <span class="text-2xl">👨‍💻</span>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-gray-800">ADIMI Prince</h4>
                                    <p class="text-gray-500 text-sm">Étudiant en génie informatique</p>
                                </div>
                            </div>
                            <p class="text-gray-600 text-sm">Étudiant en 3e année en génie informatique et télécommunication à l'EPAC, Université d'Abomey Calavi au Bénin. Ce blog généraliste est un projet de classe.</p>
                        </div>
                    </div>
                </div>
            </nav>
        </div>
    </header>

    <!-- Welcome Section -->
    <section class="bg-white py-16">
        <div class="max-w-6xl mx-auto px-4 text-center">
            <h1 class="text-4xl font-bold text-gray-800 mb-4">Bienvenue sur mon blog personnel</h1>
            <p class="text-xl text-gray-600">Un espace dédié à l'exploration de sujets variés et à la discussion de thématiques intéressantes. Découvrez des articles sur divers domaines pour enrichir votre connaissance et stimuler votre curiosité.</p>
        </div>
    </section>

    <!-- Main Content -->
    <main class="max-w-6xl mx-auto px-4 py-12">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Articles Column -->
            <div class="lg:col-span-2">
                <h2 class="text-2xl font-bold text-gray-800 mb-6">ARTICLES RÉCENTS</h2>
                
                @if($posts->count() > 0)
                    @foreach($posts as $post)
                        <div class="bg-white rounded-lg shadow p-6 mb-6">
                            @if($post->categorie)
                                <span class="inline-block bg-purple-100 text-purple-600 px-3 py-1 rounded-full text-sm font-semibold mb-3">{{ $post->categorie }}</span>
                            @endif
                            <h3 class="text-xl font-bold text-gray-800 mb-2">{{ $post->titre }}</h3>
                            <p class="text-gray-500 text-sm mb-3">{{ \Carbon\Carbon::parse($post->created_at)->locale('fr')->isoFormat('D MMMM YYYY') }}</p>
                            <p class="text-gray-600 mb-4">{{ Str::limit(strip_tags($post->contenu), 200) }}</p>
                            
                            <div class="flex items-center space-x-6 text-gray-500 text-sm mb-4">
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 mr-1 text-red-500" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                    </svg>
                                    {{ $post->likes_count }}
                                </div>
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 mr-1 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                                    </svg>
                                    {{ $post->comments_count }}
                                </div>
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 mr-1 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                    {{ $post->vues }}
                                </div>
                            </div>
                            
                            <a href="{{ route('posts.show', $post->id) }}" class="text-purple-600 font-semibold hover:text-purple-800">Lire →</a>
                        </div>
                    @endforeach
                @else
                    <p class="text-gray-500">Aucun article pour le moment</p>
                @endif
            </div>

            <!-- Sidebar -->
            <div class="lg:col-span-1">
                <!-- Search -->
                <div class="bg-white rounded-lg shadow p-6 mb-6">
                    <div class="relative">
                        <input type="text" placeholder="Rechercher..." class="w-full px-4 py-3 pl-10 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500">
                        <svg class="w-5 h-5 text-gray-400 absolute left-3 top-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                </div>

                <!-- About -->
                <div class="bg-white rounded-lg shadow p-6 mb-6">
                    <h3 class="text-lg font-bold text-gray-800 mb-4">À propos</h3>
                    <div class="flex items-center mb-4">
                        <div class="w-16 h-16 rounded-full bg-purple-500 flex items-center justify-center text-white text-xl font-bold mr-4">
                            AP
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-800">ADIMI Prince</h4>
                            <p class="text-gray-500 text-sm">Étudiant en génie informatique</p>
                        </div>
                    </div>
                    <p class="text-gray-600 text-sm">Étudiant en 3e année en génie informatique et télécommunication à l'EPAC, Université d'Abomey Calavi au Bénin. Ce blog généraliste est un projet de classe.</p>
                </div>

                <!-- Categories -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-bold text-gray-800 mb-4">Catégories</h3>
                    <ul class="space-y-2">
                        @if(!empty($categories))
                            @foreach($categories as $category)
                                <li class="flex justify-between text-gray-600 hover:text-purple-600 cursor-pointer">
                                    <span>{{ $category }}</span>
                                    <span class="font-semibold">{{ $posts->where('categorie', $category)->count() }}</span>
                                </li>
                            @endforeach
                        @else
                            <li class="text-gray-500">Aucune catégorie disponible</li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t mt-12 py-8">
        <div class="max-w-6xl mx-auto px-4 text-center text-gray-500">
            <p>© {{ date('Y') }} Mon Blog. Tous droits réservés.</p>
        </div>
    </footer>

    <script>
        // Dropdown menu handling
        document.addEventListener('DOMContentLoaded', function() {
            const dropdowns = document.querySelectorAll('[id$="Dropdown"]');
            
            dropdowns.forEach(dropdown => {
                const trigger = dropdown.querySelector('.dropdown-trigger');
                const menu = dropdown.querySelector('.dropdown-menu');
                
                // Keep menu open on click
                trigger.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    
                    // Close all other dropdowns
                    dropdowns.forEach(d => {
                        if (d !== dropdown) {
                            d.querySelector('.dropdown-menu').classList.add('invisible');
                            d.querySelector('.dropdown-menu').classList.remove('visible');
                        }
                    });
                    
                    // Toggle current dropdown
                    menu.classList.toggle('invisible');
                    menu.classList.toggle('visible');
                });
                
                // Prevent menu from closing when clicking inside
                menu.addEventListener('click', function(e) {
                    e.stopPropagation();
                });
            });
            
            // Close all dropdowns when clicking outside
            document.addEventListener('click', function() {
                dropdowns.forEach(dropdown => {
                    const menu = dropdown.querySelector('.dropdown-menu');
                    menu.classList.add('invisible');
                    menu.classList.remove('visible');
                });
            });
        });
    </script>
</body>
</html>
