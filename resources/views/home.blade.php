<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon Blog — ADIMI Prince</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { background-color: #F9F8FF; font-family: 'Inter', sans-serif; }
        .gradient-hero { background: linear-gradient(135deg, #7C3AED 0%, #A855F7 50%, #6366F1 100%); }
        .card-hover { transition: transform 0.2s ease, box-shadow 0.2s ease; }
        .card-hover:hover { transform: translateY(-4px); box-shadow: 0 12px 40px rgba(124, 58, 237, 0.15); }
    </style>
</head>
<body class="min-h-screen">

    <!-- Navbar -->
    <header class="bg-white shadow-sm sticky top-0 z-40">
        <div class="max-w-6xl mx-auto px-6 py-4 flex items-center justify-between">
            <a href="{{ route('home') }}" class="flex items-center space-x-2">
                <div class="w-8 h-8 bg-purple-600 rounded-lg flex items-center justify-center">
                    <span class="text-white font-bold text-sm">P</span>
                </div>
                <span class="text-xl font-bold text-gray-800">Blog<span class="text-purple-600">Prince</span></span>
            </a>
            <nav class="flex items-center space-x-8">
                <a href="{{ route('home') }}" class="text-purple-600 font-medium border-b-2 border-purple-600 pb-1">Accueil</a>

                <div class="relative group" id="articlesDropdown">
                    <a href="#" class="text-gray-600 hover:text-purple-600 font-medium transition dropdown-trigger flex items-center gap-1">
                        Articles
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </a>
                    <div class="absolute right-0 mt-3 w-72 bg-white rounded-xl shadow-xl border border-gray-100 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50 dropdown-menu">
                        <div class="p-2">
                            @foreach($posts as $post)
                                <a href="{{ route('posts.show', $post->id) }}" class="flex items-center px-3 py-2 text-gray-700 hover:bg-purple-50 hover:text-purple-600 rounded-lg transition">
                                    <span class="w-2 h-2 bg-purple-400 rounded-full mr-3"></span>
                                    {{ Str::limit($post->titre, 40) }}
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="relative group" id="aboutDropdown">
                    <a href="#" class="text-gray-600 hover:text-purple-600 font-medium transition dropdown-trigger">À propos</a>
                    <div class="absolute right-0 mt-3 w-80 bg-white rounded-xl shadow-xl border border-gray-100 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50 dropdown-menu">
                        <div class="p-5">
                            <div class="flex items-center mb-3">
                                <div class="w-14 h-14 bg-purple-600 rounded-full flex items-center justify-center text-white text-lg font-bold mr-4">AP</div>
                                <div>
                                    <h4 class="font-bold text-gray-800">ADIMI Prince</h4>
                                    <p class="text-purple-600 text-sm font-medium">Étudiant en génie informatique</p>
                                </div>
                            </div>
                            <p class="text-gray-600 text-sm leading-relaxed">Étudiant en 3e année en génie informatique et télécommunication à l'EPAC, Université d'Abomey Calavi au Bénin.</p>
                        </div>
                    </div>
                </div>
            </nav>
        </div>
    </header>

    <!-- Hero -->
    <section class="gradient-hero py-20 px-6">
        <div class="max-w-4xl mx-auto text-center">
            <span class="inline-block bg-white bg-opacity-20 text-white text-sm font-medium px-4 py-1 rounded-full mb-6">✨ Blog personnel</span>
            <h1 class="text-5xl font-bold text-white mb-6 leading-tight">Bienvenue sur<br><span class="text-yellow-300">BlogPrince</span></h1>
            <p class="text-purple-100 text-lg max-w-2xl mx-auto leading-relaxed">Un espace dédié à l'exploration de sujets variés — tech, études, expériences et bien plus encore.</p>
        </div>
    </section>

    <!-- Main Content -->
    <main class="max-w-6xl mx-auto px-6 py-12">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            <!-- Articles -->
            <div class="lg:col-span-2">
                <div class="flex items-center justify-between mb-8">
                    <h2 class="text-xl font-bold text-gray-800 flex items-center gap-2">
                        <span class="w-1 h-6 bg-purple-600 rounded-full inline-block"></span>
                        Articles récents
                    </h2>
                    <span class="text-sm text-gray-500">{{ $posts->count() }} article(s)</span>
                </div>

                @if($posts->count() > 0)
                    @foreach($posts as $post)
                        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden mb-6 card-hover">
                            @if($post->image)
                                <img src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->titre }}" class="w-full h-48 object-cover">
                            @else
                                <div class="w-full h-48 gradient-hero flex items-center justify-center">
                                    <span class="text-white text-4xl">📝</span>
                                </div>
                            @endif
                            <div class="p-6">
                                <div class="flex items-center justify-between mb-3">
                                    @if($post->categorie)
                                        <span class="bg-purple-100 text-purple-600 px-3 py-1 rounded-full text-xs font-semibold">{{ $post->categorie }}</span>
                                    @endif
                                    <span class="text-gray-400 text-xs">{{ \Carbon\Carbon::parse($post->created_at)->locale('fr')->isoFormat('D MMM YYYY') }}</span>
                                </div>
                                <h3 class="text-lg font-bold text-gray-800 mb-2 hover:text-purple-600 transition">
                                    <a href="{{ route('posts.show', $post->id) }}">{{ $post->titre }}</a>
                                </h3>
                                <p class="text-gray-500 text-sm mb-4 leading-relaxed">{{ Str::limit(strip_tags($post->contenu), 150) }}</p>
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center space-x-4 text-gray-400 text-sm">
                                        <span class="flex items-center gap-1">❤️ {{ $post->likes_count }}</span>
                                        <span class="flex items-center gap-1">💬 {{ $post->comments_count }}</span>
                                        <span class="flex items-center gap-1">👁️ {{ $post->vues }}</span>
                                    </div>
                                    <a href="{{ route('posts.show', $post->id) }}" class="bg-purple-600 hover:bg-purple-700 text-white text-sm font-medium px-4 py-2 rounded-lg transition">
                                        Lire →
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-12 text-center">
                        <span class="text-5xl mb-4 block">📭</span>
                        <p class="text-gray-500">Aucun article pour le moment.</p>
                    </div>
                @endif
            </div>

            <!-- Sidebar -->
            <div class="lg:col-span-1 space-y-6">

                <!-- Search -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5">
                    <div class="relative">
                        <input type="text" placeholder="Rechercher un article..." class="w-full px-4 py-3 pl-10 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-purple-500 text-sm">
                        <svg class="w-4 h-4 text-gray-400 absolute left-3 top-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                </div>

                <!-- About -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5">
                    <h3 class="text-sm font-bold text-gray-500 uppercase tracking-wider mb-4">À propos</h3>
                    <div class="text-center">
                        <div class="w-20 h-20 bg-purple-600 rounded-full flex items-center justify-center text-white text-2xl font-bold mx-auto mb-3">AP</div>
                        <h4 class="font-bold text-gray-800 text-lg">ADIMI Prince</h4>
                        <p class="text-purple-600 text-sm font-medium mb-3">Étudiant en génie informatique</p>
                        <p class="text-gray-500 text-sm leading-relaxed">3e année à l'EPAC, Université d'Abomey Calavi au Bénin. Ce blog est un projet de classe.</p>
                    </div>
                </div>

                <!-- Categories -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5">
                    <h3 class="text-sm font-bold text-gray-500 uppercase tracking-wider mb-4">Catégories</h3>
                    @if(!empty($categories))
                        <div class="space-y-2">
                            @foreach($categories as $category)
                                <div class="flex items-center justify-between p-2 hover:bg-purple-50 rounded-lg cursor-pointer transition group">
                                    <span class="text-gray-700 group-hover:text-purple-600 text-sm font-medium">{{ $category }}</span>
                                    <span class="bg-purple-100 text-purple-600 text-xs font-bold px-2 py-1 rounded-full">{{ $posts->where('categorie', $category)->count() }}</span>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-400 text-sm">Aucune catégorie disponible</p>
                    @endif
                </div>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t mt-12 py-8">
        <div class="max-w-6xl mx-auto px-6 text-center">
            <p class="text-gray-500 text-sm">© {{ date('Y') }} <span class="text-purple-600 font-semibold">BlogPrince</span> — ADIMI Prince. Tous droits réservés.</p>
        </div>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const dropdowns = document.querySelectorAll('[id$="Dropdown"]');
            dropdowns.forEach(dropdown => {
                const trigger = dropdown.querySelector('.dropdown-trigger');
                const menu = dropdown.querySelector('.dropdown-menu');
                trigger.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    dropdowns.forEach(d => {
                        if (d !== dropdown) {
                            d.querySelector('.dropdown-menu').classList.add('invisible');
                            d.querySelector('.dropdown-menu').classList.remove('visible');
                        }
                    });
                    menu.classList.toggle('invisible');
                    menu.classList.toggle('visible');
                });
                menu.addEventListener('click', function(e) { e.stopPropagation(); });
            });
            document.addEventListener('click', function() {
                dropdowns.forEach(dropdown => {
                    dropdown.querySelector('.dropdown-menu').classList.add('invisible');
                    dropdown.querySelector('.dropdown-menu').classList.remove('visible');
                });
            });
        });
    </script>
</body>
</html>