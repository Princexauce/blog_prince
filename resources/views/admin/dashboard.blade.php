<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            background-color: #F9F8FF;
        }
    </style>
</head>
<body class="flex min-h-screen">
    <!-- Sidebar -->
    <div class="w-64 bg-gray-900 text-white flex flex-col">
        <div class="p-6">
            <h1 class="text-xl font-bold">Mon Blog</h1>
            <p class="text-gray-400 text-sm">Espace admin</p>
        </div>
        
        <nav class="flex-1">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center px-6 py-3 bg-purple-600 border-l-4 border-purple-400">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                </svg>
                Dashboard
            </a>
            <a href="{{ route('admin.posts.index') }}" class="flex items-center px-6 py-3 text-gray-300 hover:bg-gray-800">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                Articles
            </a>
            <a href="{{ route('admin.posts.create') }}" class="flex items-center px-6 py-3 text-gray-300 hover:bg-gray-800 ml-3">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Créer article
            </a>
            <a href="{{ route('admin.comments') }}" class="flex items-center px-6 py-3 text-gray-300 hover:bg-gray-800">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                </svg>
                Commentaires
            </a>
            <a href="{{ route('admin.likes') }}" class="flex items-center px-6 py-3 text-gray-300 hover:bg-gray-800">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                </svg>
                Likes
            </a>
        </nav>
        
        <div class="p-6">
            <form method="POST" action="{{ route('admin.logout') }}">
                @csrf
                <button type="submit" class="flex items-center text-gray-300 hover:text-white">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                    </svg>
                    Déconnexion
                </button>
            </form>
        </div>
    </div>

    <!-- Main Content -->
    <div class="flex-1 p-8">
        <h1 class="text-2xl font-bold text-gray-800 mb-8">Dashboard</h1>

        <!-- Stats -->
        <div class="grid grid-cols-4 gap-6 mb-8">
            <div class="bg-white rounded-lg p-6 shadow">
                <p class="text-gray-500 text-sm">Total Articles</p>
                <p class="text-3xl font-bold text-gray-800">{{ $stats['total_posts'] }}</p>
            </div>
            <div class="bg-white rounded-lg p-6 shadow">
                <p class="text-gray-500 text-sm">Total Vues</p>
                <p class="text-3xl font-bold text-gray-800">{{ $stats['total_vues'] }}</p>
            </div>
            <div class="bg-white rounded-lg p-6 shadow">
                <p class="text-gray-500 text-sm">Total Likes</p>
                <p class="text-3xl font-bold text-gray-800">{{ $stats['total_likes'] }}</p>
            </div>
            <div class="bg-white rounded-lg p-6 shadow">
                <p class="text-gray-500 text-sm">Total Commentaires</p>
                <p class="text-3xl font-bold text-gray-800">{{ $stats['total_comments'] }}</p>
            </div>
        </div>

        <!-- Recent Posts -->
        <div class="bg-white rounded-lg shadow mb-8">
            <div class="p-6 border-b flex justify-between items-center">
                <h2 class="text-lg font-semibold text-gray-800">Articles récents</h2>
                <a href="{{ route('admin.posts.create') }}" class="bg-purple-500 hover:bg-purple-600 text-white font-semibold py-2 px-4 rounded-lg text-sm transition">
                    + Nouvel article
                </a>
            </div>
            <div class="p-6">
                @if($recentPosts->count() > 0)
                    @foreach($recentPosts as $post)
                        <div class="flex items-center justify-between py-3 border-b last:border-0">
                            <div class="flex-1">
                                <p class="font-semibold text-gray-800">{{ $post->titre }}</p>
                                <p class="text-sm text-gray-500">{{ \Carbon\Carbon::parse($post->created_at)->locale('fr')->isoFormat('D MMMM YYYY') }}</p>
                                @if($post->categorie)
                                    <span class="inline-block bg-purple-100 text-purple-600 px-2 py-1 rounded text-xs mt-1">{{ $post->categorie }}</span>
                                @endif
                            </div>
                            <div class="flex items-center space-x-2 ml-4">
                                <a href="{{ route('admin.posts.edit', $post->id) }}" class="text-blue-500 hover:text-blue-700">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                </a>
                                <form method="POST" action="{{ route('admin.posts.destroy', $post->id) }}" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cet article ?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-700">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                @else
                    <p class="text-gray-500">Aucun article pour le moment</p>
                @endif
            </div>
        </div>

        <!-- Recent Comments -->
        <div class="bg-white rounded-lg shadow mb-8">
            <div class="p-6 border-b">
                <h2 class="text-lg font-semibold text-gray-800">Derniers commentaires</h2>
            </div>
            <div class="p-6">
                @if($recentComments->count() > 0)
                    @foreach($recentComments as $comment)
                        <div class="flex items-center justify-between py-3 border-b last:border-0">
                            <div>
                                <p class="font-semibold text-gray-800">{{ $comment->pseudo }}</p>
                                <p class="text-sm text-gray-500">{{ $comment->post->titre }}</p>
                                <p class="text-sm text-gray-600">{{ Str::limit($comment->contenu, 50) }}</p>
                            </div>
                            <form method="POST" action="{{ route('admin.comments.destroy', $comment->id) }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:text-red-700">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                </button>
                            </form>
                        </div>
                    @endforeach
                @else
                    <p class="text-gray-500">Aucun commentaire pour le moment</p>
                @endif
            </div>
        </div>

        <!-- Recent Likes -->
        <div class="bg-white rounded-lg shadow">
            <div class="p-6 border-b">
                <h2 class="text-lg font-semibold text-gray-800">Personnes qui ont liké</h2>
            </div>
            <div class="p-6">
                @if($recentLikes->count() > 0)
                    @foreach($recentLikes as $like)
                        <div class="flex items-center py-3 border-b last:border-0">
                            <svg class="w-5 h-5 text-red-500 mr-3" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                            </svg>
                            <div>
                                <p class="font-semibold text-gray-800">{{ $like->pseudo }}</p>
                                <p class="text-sm text-gray-500">{{ $like->email }}</p>
                                <p class="text-sm text-gray-600">{{ $like->post->titre }}</p>
                            </div>
                        </div>
                    @endforeach
                @else
                    <p class="text-gray-500">Aucun like pour le moment</p>
                @endif
            </div>
        </div>
    </div>
</body>
</html>
