<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Likes - Admin</title>
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
            <a href="{{ route('admin.dashboard') }}" class="flex items-center px-6 py-3 text-gray-300 hover:bg-gray-800">
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
            <a href="{{ route('admin.likes') }}" class="flex items-center px-6 py-3 bg-purple-600 border-l-4 border-purple-400">
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
        <h1 class="text-2xl font-bold text-gray-800 mb-8">Tous les likes</h1>

        <div class="bg-white rounded-lg shadow">
            <div class="p-6">
                @if($likes->count() > 0)
                    @foreach($likes as $like)
                        <div class="flex items-center py-4 border-b last:border-0">
                            <svg class="w-6 h-6 text-red-500 mr-4" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                            </svg>
                            <div class="flex-1">
                                <p class="font-semibold text-gray-800">{{ $like->pseudo }}</p>
                                <p class="text-sm text-gray-500">{{ $like->email }}</p>
                                <p class="text-sm text-gray-600">Article: {{ $like->post->titre }}</p>
                                <p class="text-sm text-gray-400">{{ \Carbon\Carbon::parse($like->created_at)->locale('fr')->isoFormat('D MMMM YYYY à HH:mm') }}</p>
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
