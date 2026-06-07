<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $post->titre }} - Mon Blog</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            background-color: #F9F8FF;
        }
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
        <div class="bg-white rounded-lg shadow p-6 mb-8">
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
            
            <button id="likeButton" onclick="handleLikeAction()" class="bg-purple-500 hover:bg-purple-600 text-white font-semibold py-3 px-6 rounded-lg transition">
                ❤️ J'aime cet article
            </button>
        </div>

        <!-- Comments Section -->
        <div class="bg-white rounded-lg shadow p-6 mb-8">
            <h3 class="text-lg font-bold text-gray-800 mb-6">Commentaires ({{ $post->comments_count }})</h3>
            
            @if(session('comment_success'))
                <div class="mb-4 p-3 bg-green-100 border border-green-400 text-green-700 rounded">
                    {{ session('comment_success') }}
                </div>
            @endif

            @if(session('comment_error'))
                <div class="mb-4 p-3 bg-red-100 border border-red-400 text-red-700 rounded">
                    {{ session('comment_error') }}
                </div>
            @endif

            <!-- Add Comment Button -->
            <button onclick="openCommentModal()" class="bg-purple-500 hover:bg-purple-600 text-white font-semibold py-3 px-6 rounded-lg transition mb-6">
                💬 Ajouter un commentaire
            </button>

            <!-- Comments List -->
            @if($comments->count() > 0)
                @foreach($comments as $comment)
                    <div class="border-b pb-6 mb-6 last:border-0">
                        <div class="flex items-start mb-3">
                            <div class="w-10 h-10 rounded-full bg-purple-500 flex items-center justify-center text-white font-bold mr-3">
                                {{ strtoupper(substr($comment->pseudo, 0, 2)) }}
                            </div>
                            <div>
                                <p class="font-semibold text-gray-800">{{ $comment->pseudo }}</p>
                                <p class="text-gray-500 text-sm">{{ \Carbon\Carbon::parse($comment->created_at)->locale('fr')->isoFormat('D MMMM YYYY à HH:mm') }}</p>
                            </div>
                        </div>
                        <p class="text-gray-700 mb-3">{{ $comment->contenu }}</p>
                        
                        <!-- Reply Button -->
                        <button onclick="openReplyModal({{ $comment->id }})" class="text-purple-600 text-sm hover:text-purple-800">
                            Répondre
                        </button>

                        <!-- Replies -->
                        @if($comment->replies->count() > 0)
                            <div class="ml-12 mt-4 space-y-4">
                                @foreach($comment->replies as $reply)
                                    <div class="border-l-2 border-purple-200 pl-4">
                                        <div class="flex items-start mb-2">
                                            <div class="w-8 h-8 rounded-full bg-purple-400 flex items-center justify-center text-white font-bold mr-3 text-sm">
                                                {{ strtoupper(substr($reply->pseudo, 0, 2)) }}
                                            </div>
                                            <div>
                                                <p class="font-semibold text-gray-800 text-sm">{{ $reply->pseudo }}</p>
                                                <p class="text-gray-500 text-xs">{{ \Carbon\Carbon::parse($reply->created_at)->locale('fr')->isoFormat('D MMMM YYYY à HH:mm') }}</p>
                                            </div>
                                        </div>
                                        <p class="text-gray-700 text-sm">{{ $reply->contenu }}</p>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                @endforeach
            @else
                <p class="text-gray-500">Aucun commentaire pour le moment. Soyez le premier à commenter !</p>
            @endif
        </div>
    </main>

    <!-- Like Modal -->
    <div id="likeModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
        <div class="bg-white rounded-lg p-6 w-full max-w-md mx-4">
            <h3 id="likeModalTitle" class="text-xl font-bold text-gray-800 mb-4">Liker cet article</h3>
            <form id="likeForm" method="POST" action="{{ route('likes.store', $post->id) }}">
                @csrf
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-semibold mb-2">Pseudo</label>
                    <input type="text" name="pseudo" id="likePseudo" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500">
                </div>
                <div class="mb-6">
                    <label class="block text-gray-700 text-sm font-semibold mb-2">Email</label>
                    <input type="email" name="email" id="likeEmail" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500">
                </div>
                <div class="flex justify-end space-x-3">
                    <button type="button" onclick="closeLikeModal()" class="px-4 py-2 text-gray-600 hover:text-gray-800">Annuler</button>
                    <button type="submit" class="bg-purple-500 hover:bg-purple-600 text-white font-semibold py-2 px-6 rounded-lg">Liker</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Comment Modal -->
    <div id="commentModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
        <div class="bg-white rounded-lg p-6 w-full max-w-md mx-4">
            <h3 class="text-xl font-bold text-gray-800 mb-4">Ajouter un commentaire</h3>
            <form method="POST" action="{{ route('comments.store', $post->id) }}">
                @csrf
                <input type="hidden" name="parent_id" id="parent_id" value="">
                <div id="userInfoFields" class="mb-4">
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-semibold mb-2">Pseudo</label>
                        <input type="text" name="pseudo" id="commentPseudo" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500">
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-semibold mb-2">Email</label>
                        <input type="email" name="email" id="commentEmail" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500">
                    </div>
                </div>
                <div class="mb-6">
                    <label class="block text-gray-700 text-sm font-semibold mb-2">Commentaire</label>
                    <textarea name="contenu" rows="4" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500"></textarea>
                </div>
                <div class="flex justify-end space-x-3">
                    <button type="button" onclick="closeCommentModal()" class="px-4 py-2 text-gray-600 hover:text-gray-800">Annuler</button>
                    <button type="submit" class="bg-purple-500 hover:bg-purple-600 text-white font-semibold py-2 px-6 rounded-lg">Envoyer</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        const postId = {{ $post->id }};
        const serverHasLiked = {{ $hasLiked ? 'true' : 'false' }};

        // Initialize localStorage with server data
        function initializeLikeStatus() {
            let likedPosts = JSON.parse(localStorage.getItem('liked_posts') || '[]');
            const index = likedPosts.indexOf(postId);
            
            if (serverHasLiked && index === -1) {
                likedPosts.push(postId);
                localStorage.setItem('liked_posts', JSON.stringify(likedPosts));
            } else if (!serverHasLiked && index !== -1) {
                likedPosts.splice(index, 1);
                localStorage.setItem('liked_posts', JSON.stringify(likedPosts));
            }
        }

        // Check if user has liked this post
        function hasLikedPost() {
            const likedPosts = JSON.parse(localStorage.getItem('liked_posts') || '[]');
            return likedPosts.includes(postId);
        }

        // Save like status
        function saveLikeStatus(liked) {
            let likedPosts = JSON.parse(localStorage.getItem('liked_posts') || '[]');
            if (liked) {
                if (!likedPosts.includes(postId)) {
                    likedPosts.push(postId);
                }
            } else {
                likedPosts = likedPosts.filter(id => id !== postId);
            }
            localStorage.setItem('liked_posts', JSON.stringify(likedPosts));
        }

        // Update like button appearance
        function updateLikeButton() {
            const likeButton = document.getElementById('likeButton');
            if (hasLikedPost()) {
                likeButton.innerHTML = '💔 Retirer le j\'aime';
                likeButton.classList.remove('bg-purple-500', 'hover:bg-purple-600');
                likeButton.classList.add('bg-red-500', 'hover:bg-red-600');
            } else {
                likeButton.innerHTML = '❤️ J\'aime cet article';
                likeButton.classList.remove('bg-red-500', 'hover:bg-red-600');
                likeButton.classList.add('bg-purple-500', 'hover:bg-purple-600');
            }
        }

        // Handle like button click
        function handleLikeAction() {
            const userInfo = getUserInfo();
            
            if (hasLikedPost()) {
                // Unlike - remove like directly
                if (userInfo.email) {
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = '{{ route('likes.destroy', $post->id) }}';
                    
                    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;
                    if (csrfToken) {
                        const csrfInput = document.createElement('input');
                        csrfInput.type = 'hidden';
                        csrfInput.name = '_token';
                        csrfInput.value = csrfToken;
                        form.appendChild(csrfInput);
                    }
                    
                    const emailInput = document.createElement('input');
                    emailInput.type = 'hidden';
                    emailInput.name = 'email';
                    emailInput.value = userInfo.email;
                    form.appendChild(emailInput);
                    
                    document.body.appendChild(form);
                    form.submit();
                } else {
                    openLikeModal();
                }
            } else {
                // Like - check if user info is already known
                if (userInfo.pseudo && userInfo.email) {
                    // Submit like directly without modal
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = '{{ route('likes.store', $post->id) }}';
                    
                    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;
                    if (csrfToken) {
                        const csrfInput = document.createElement('input');
                        csrfInput.type = 'hidden';
                        csrfInput.name = '_token';
                        csrfInput.value = csrfToken;
                        form.appendChild(csrfInput);
                    }
                    
                    const pseudoInput = document.createElement('input');
                    pseudoInput.type = 'hidden';
                    pseudoInput.name = 'pseudo';
                    pseudoInput.value = userInfo.pseudo;
                    form.appendChild(pseudoInput);
                    
                    const emailInput = document.createElement('input');
                    emailInput.type = 'hidden';
                    emailInput.name = 'email';
                    emailInput.value = userInfo.email;
                    form.appendChild(emailInput);
                    
                    document.body.appendChild(form);
                    form.submit();
                } else {
                    openLikeModal();
                }
            }
        }

        function openLikeModal() {
            const userInfo = getUserInfo();
            const likePseudo = document.getElementById('likePseudo');
            const likeEmail = document.getElementById('likeEmail');

            if (userInfo.pseudo && userInfo.email) {
                likePseudo.value = userInfo.pseudo;
                likeEmail.value = userInfo.email;
            }

            document.getElementById('likeModal').classList.remove('hidden');
            document.getElementById('likeModal').classList.add('flex');
        }

        function closeLikeModal() {
            document.getElementById('likeModal').classList.add('hidden');
            document.getElementById('likeModal').classList.remove('flex');
        }

        // Get user info from localStorage
        function getUserInfo() {
            const pseudo = localStorage.getItem('blog_pseudo');
            const email = localStorage.getItem('blog_email');
            return { pseudo, email };
        }

        // Save user info to localStorage
        function saveUserInfo(pseudo, email) {
            localStorage.setItem('blog_pseudo', pseudo);
            localStorage.setItem('blog_email', email);
        }

        function openCommentModal() {
            const userInfo = getUserInfo();
            const userInfoFields = document.getElementById('userInfoFields');
            const commentPseudo = document.getElementById('commentPseudo');
            const commentEmail = document.getElementById('commentEmail');

            document.getElementById('parent_id').value = '';

            if (userInfo.pseudo && userInfo.email) {
                // Masquer les champs utilisateur et pré-remplir
                userInfoFields.classList.add('hidden');
                commentPseudo.value = userInfo.pseudo;
                commentEmail.value = userInfo.email;
                commentPseudo.required = false;
                commentEmail.required = false;
            } else {
                // Afficher les champs utilisateur
                userInfoFields.classList.remove('hidden');
                commentPseudo.value = '';
                commentEmail.value = '';
                commentPseudo.required = true;
                commentEmail.required = true;
            }

            document.getElementById('commentModal').classList.remove('hidden');
            document.getElementById('commentModal').classList.add('flex');
        }

        function closeCommentModal() {
            document.getElementById('commentModal').classList.add('hidden');
            document.getElementById('commentModal').classList.remove('flex');
        }

        function openReplyModal(commentId) {
            const userInfo = getUserInfo();
            const userInfoFields = document.getElementById('userInfoFields');
            const commentPseudo = document.getElementById('commentPseudo');
            const commentEmail = document.getElementById('commentEmail');

            document.getElementById('parent_id').value = commentId;

            if (userInfo.pseudo && userInfo.email) {
                // Masquer les champs utilisateur et pré-remplir
                userInfoFields.classList.add('hidden');
                commentPseudo.value = userInfo.pseudo;
                commentEmail.value = userInfo.email;
                commentPseudo.required = false;
                commentEmail.required = false;
            } else {
                // Afficher les champs utilisateur
                userInfoFields.classList.remove('hidden');
                commentPseudo.value = '';
                commentEmail.value = '';
                commentPseudo.required = true;
                commentEmail.required = true;
            }

            document.getElementById('commentModal').classList.remove('hidden');
            document.getElementById('commentModal').classList.add('flex');
        }

        // Handle like form submission
        document.getElementById('likeForm').addEventListener('submit', function(e) {
            const pseudo = document.getElementById('likePseudo').value;
            const email = document.getElementById('likeEmail').value;
            saveUserInfo(pseudo, email);
            saveLikeStatus(true);
        });

        // Close modals when clicking outside
        document.getElementById('likeModal').addEventListener('click', function(e) {
            if (e.target === this) closeLikeModal();
        });

        document.getElementById('commentModal').addEventListener('click', function(e) {
            if (e.target === this) closeCommentModal();
        });

        // Initialize like status from server data on page load
        initializeLikeStatus();
        
        // Initialize like button on page load
        updateLikeButton();

        // Dropdown menu handling
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
    </script>
</body>
</html>
