<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $post->titre }} - BlogPrince</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { background-color: #F9F8FF; font-family: 'Inter', sans-serif; }
        .post-content img {
            max-width: 100%;
            height: auto;
            border-radius: 0.5rem;
            margin: 1.5rem auto;
            display: block;
        }
    </style>
</head>
<body class="min-h-screen">

    <!-- Header -->
    <header class="bg-white shadow-sm sticky top-0 z-40">
        <div class="max-w-6xl mx-auto px-6 py-4 flex items-center justify-between">
            <a href="{{ route('home') }}" class="flex items-center space-x-2">
                <div class="w-8 h-8 bg-purple-600 rounded-lg flex items-center justify-center">
                    <span class="text-white font-bold text-sm">P</span>
                </div>
                <span class="text-xl font-bold text-gray-800">Blog<span class="text-purple-600">Prince</span></span>
            </a>
            <div class="flex items-center gap-6">
            <nav class="flex items-center space-x-8">
                <a href="{{ route('home') }}" class="text-gray-600 hover:text-purple-600 font-medium transition">Accueil</a>

                <div class="relative group" id="articlesDropdown">
                    <a href="#" class="text-gray-600 hover:text-purple-600 font-medium transition dropdown-trigger flex items-center gap-1">
                        Articles
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </a>
                    <div class="absolute right-0 mt-3 w-72 bg-white rounded-xl shadow-xl border border-gray-100 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50 dropdown-menu">
                        <div class="p-2">
                            @foreach($posts as $p)
                                <a href="{{ route('posts.show', $p->id) }}" class="flex items-center px-3 py-2 text-gray-700 hover:bg-purple-50 hover:text-purple-600 rounded-lg transition">
                                    <span class="w-2 h-2 bg-purple-400 rounded-full mr-3"></span>
                                    {{ Str::limit($p->titre, 40) }}
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
            @include('partials.auth-nav')
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="max-w-4xl mx-auto px-4 py-12">
        <!-- Post Header -->
        @if($post->categorie)
            <span class="inline-block bg-purple-100 text-purple-600 px-3 py-1 rounded-full text-sm font-semibold mb-4">{{ $post->categorie }}</span>
        @endif
        <h1 class="text-4xl font-bold text-gray-800 mb-4">{{ $post->titre }}</h1>
        <p class="text-gray-500 mb-8">{{ \Carbon\Carbon::parse($post->created_at)->locale('fr')->isoFormat('D MMMM YYYY') }}</p>

        <!-- Post Image -->
        @if($post->image)
            <img src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->titre }}" class="w-full rounded-lg mb-8">
        @endif

        <!-- Post Content -->
        <div class="post-content prose prose-lg max-w-none text-gray-700 mb-12">
            {!! $post->contenu !!}
        </div>

        <!-- Engagement Stats -->
        <div class="flex items-center space-x-6 text-gray-500 text-sm mb-8 pb-8 border-b">
            <div class="flex items-center">
                <svg class="w-5 h-5 mr-1 text-red-500" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                </svg>
                {{ $post->likes_count }} likes
            </div>
            <div class="flex items-center">
                <svg class="w-5 h-5 mr-1 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                </svg>
                {{ $post->comments_count }} commentaires
            </div>
            <div class="flex items-center">
                <svg class="w-5 h-5 mr-1 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                </svg>
                {{ $post->vues }} vues
            </div>
        </div>

        <!-- Like Section -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-8">
            <h3 class="text-lg font-bold text-gray-800 mb-4">Liker cet article</h3>

            @if(session('like_success'))
                <div class="mb-4 p-3 bg-green-100 border border-green-400 text-green-700 rounded">
                    {{ session('like_success') }}
                </div>
            @endif

            @if(session('like_error'))
                <div class="mb-4 p-3 bg-red-100 border border-red-400 text-red-700 rounded">
                    {{ session('like_error') }}
                </div>
            @endif

            @auth
                @if($hasLiked)
                    <form method="POST" action="{{ route('likes.destroy', $post->id) }}">
                        @csrf
                        <button type="submit" class="bg-red-500 hover:bg-red-600 text-white font-semibold py-3 px-6 rounded-lg transition">
                            💔 Retirer le j'aime
                        </button>
                    </form>
                @else
                    <form method="POST" action="{{ route('likes.store', $post->id) }}">
                        @csrf
                        <button type="submit" class="bg-purple-600 hover:bg-purple-700 text-white font-semibold py-3 px-6 rounded-lg transition">
                            ❤️ J'aime cet article
                        </button>
                    </form>
                @endif
            @else
                <button type="button" onclick="openAuthModal()" class="bg-purple-600 hover:bg-purple-700 text-white font-semibold py-3 px-6 rounded-lg transition">
                    ❤️ J'aime cet article
                </button>
            @endauth
        </div>

        <!-- Comments Section -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-8">
            <h3 class="text-lg font-bold text-gray-800 mb-6">Commentaires ({{ $post->comments_count }})</h3>

            @if(session('comment_success'))
                <div class="mb-4 p-3 bg-green-100 border border-green-400 text-green-700 rounded">
                    {{ session('comment_success') }}
                </div>
            @endif

            <button type="button" onclick="handleCommentClick()" class="bg-purple-600 hover:bg-purple-700 text-white font-semibold py-3 px-6 rounded-lg transition mb-6">
                💬 Ajouter un commentaire
            </button>

            <!-- Comments List -->
            @if($comments->count() > 0)
                <div class="space-y-6">
                    @foreach($comments as $comment)
                        <div class="border-b pb-6 last:border-0">
                            @include('posts.partials.comment-item', ['comment' => $comment, 'depth' => 0])
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-500">Aucun commentaire pour le moment. Soyez le premier à commenter !</p>
            @endif
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t mt-12 py-8">
        <div class="max-w-6xl mx-auto px-6 text-center">
            <p class="text-gray-500 text-sm">© {{ date('Y') }} <span class="text-purple-600 font-semibold">BlogPrince</span> — ADIMI Prince. Tous droits réservés.</p>
        </div>
    </footer>

    <!-- Auth Required Modal -->
    <div id="authModal" class="fixed inset-0 bg-black/50 hidden items-center justify-center z-50 p-4">
        <div class="bg-white rounded-2xl w-full max-w-md shadow-2xl overflow-hidden">
            <div class="bg-gradient-to-r from-purple-600 to-indigo-600 px-6 py-8 text-center">
                <div class="w-14 h-14 bg-white/20 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-white">Accès membre requis</h3>
            </div>
            <div class="px-6 py-6 text-center">
                <p class="text-gray-600 leading-relaxed mb-6">
                    Pour participer à la discussion, veuillez vous connecter à votre compte.
                    <span class="block mt-2 text-gray-500 text-sm">Nouveau sur BlogPrince ? L'inscription ne prend qu'un instant.</span>
                </p>
                <div class="flex flex-col sm:flex-row gap-3 justify-center">
                    <a href="{{ route('login', ['redirect' => url()->current()]) }}" class="bg-purple-600 hover:bg-purple-700 text-white font-semibold py-3 px-6 rounded-xl transition">
                        Se connecter
                    </a>
                    <a href="{{ route('register', ['redirect' => url()->current()]) }}" class="border-2 border-purple-600 text-purple-600 hover:bg-purple-50 font-semibold py-3 px-6 rounded-xl transition">
                        Créer un compte
                    </a>
                </div>
                <button type="button" onclick="closeAuthModal()" class="mt-5 text-sm text-gray-400 hover:text-gray-600 transition">
                    Continuer la lecture
                </button>
            </div>
        </div>
    </div>

    @auth
    <!-- Comment Modal -->
    <div id="commentModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
        <div class="bg-white rounded-2xl p-6 w-full max-w-md mx-4">
            <h3 id="commentModalTitle" class="text-xl font-bold text-gray-800 mb-4">Ajouter un commentaire</h3>
            <p class="text-sm text-gray-500 mb-4">Publié en tant que <strong class="text-purple-600">{{ Auth::user()->name }}</strong></p>
            <form method="POST" action="{{ route('comments.store', $post->id) }}">
                @csrf
                <input type="hidden" name="parent_id" id="parent_id" value="">
                <div class="mb-6">
                    <label class="block text-gray-700 text-sm font-semibold mb-2">Commentaire</label>
                    <textarea name="contenu" rows="4" required class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-purple-500"></textarea>
                </div>
                <div class="flex justify-end space-x-3">
                    <button type="button" onclick="closeCommentModal()" class="px-4 py-2 text-gray-600 hover:text-gray-800">Annuler</button>
                    <button type="submit" class="bg-purple-600 hover:bg-purple-700 text-white font-semibold py-2 px-6 rounded-lg">Envoyer</button>
                </div>
            </form>
        </div>
    </div>
    @endauth

    <script>
        const isAuthenticated = @json(auth()->check());

        function openAuthModal() {
            document.getElementById('authModal').classList.remove('hidden');
            document.getElementById('authModal').classList.add('flex');
        }

        function closeAuthModal() {
            document.getElementById('authModal').classList.add('hidden');
            document.getElementById('authModal').classList.remove('flex');
        }

        function handleCommentClick() {
            if (isAuthenticated) {
                openCommentModal();
            } else {
                openAuthModal();
            }
        }

        function handleReplyClick(commentId, authorName = null) {
            if (isAuthenticated) {
                openReplyModal(commentId, authorName);
            } else {
                openAuthModal();
            }
        }

        document.addEventListener('click', function(e) {
            const replyBtn = e.target.closest('.js-reply-btn');
            if (replyBtn) {
                handleReplyClick(replyBtn.dataset.commentId, replyBtn.dataset.authorName || null);
            }
        });

        function toggleReplies(commentId, hiddenCount) {
            const extra = document.getElementById('replies-extra-' + commentId);
            const toggle = document.getElementById('replies-toggle-' + commentId);

            if (!extra || !toggle) {
                return;
            }

            const isHidden = extra.classList.contains('hidden');
            extra.classList.toggle('hidden');

            if (isHidden) {
                toggle.textContent = 'Masquer ' + hiddenCount + ' réponse' + (hiddenCount > 1 ? 's' : '');
            } else {
                toggle.textContent = 'Afficher ' + hiddenCount + ' autre' + (hiddenCount > 1 ? 's' : '') + ' réponse' + (hiddenCount > 1 ? 's' : '');
            }
        }

        function openCommentModal() {
            const parentInput = document.getElementById('parent_id');
            const modal = document.getElementById('commentModal');
            const title = document.getElementById('commentModalTitle');

            if (!modal || !parentInput || !title) {
                openAuthModal();
                return;
            }

            parentInput.value = '';
            title.textContent = 'Ajouter un commentaire';
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function closeCommentModal() {
            const modal = document.getElementById('commentModal');
            if (!modal) {
                return;
            }
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }

        function openReplyModal(commentId, authorName) {
            const parentInput = document.getElementById('parent_id');
            const modal = document.getElementById('commentModal');
            const title = document.getElementById('commentModalTitle');

            if (!modal || !parentInput || !title) {
                openAuthModal();
                return;
            }

            parentInput.value = commentId;
            title.textContent = authorName
                ? 'Répondre à ' + authorName
                : 'Répondre au commentaire';
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        document.getElementById('authModal').addEventListener('click', function(e) {
            if (e.target === this) closeAuthModal();
        });

        @auth
        document.getElementById('commentModal').addEventListener('click', function(e) {
            if (e.target === this) closeCommentModal();
        });
        @endauth

        // Dropdown handling
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
    </script>
</body>
</html>