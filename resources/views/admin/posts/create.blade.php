<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Créer un article - Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
    <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
    <style>
        body {
            background-color: #F9F8FF;
        }
        #editor {
            height: 400px;
            background: white;
        }
        .ql-container {
            font-size: 16px;
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
            <a href="{{ route('admin.posts.create') }}" class="flex items-center px-6 py-3 bg-purple-600 border-l-4 border-purple-400 ml-3">
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
        <h1 class="text-2xl font-bold text-gray-800 mb-8">Créer un article</h1>

        @if(session('success'))
            <div class="mb-4 p-3 bg-green-100 border border-green-400 text-green-700 rounded">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                <strong>Erreurs:</strong>
                <ul class="list-disc list-inside mt-2">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="bg-white rounded-lg shadow p-6">
            <form method="POST" action="{{ route('admin.posts.store') }}" id="postForm">
                @csrf
                <div class="mb-6">
                    <label class="block text-gray-700 text-sm font-semibold mb-2">Titre</label>
                    <input type="text" name="titre" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500">
                </div>

                <div class="mb-6">
                    <label class="block text-gray-700 text-sm font-semibold mb-2">Catégorie</label>
                    <input type="text" name="categorie" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500" placeholder="Ex: React, CSS, TypeScript...">
                </div>

                <div class="mb-6">
                    <label class="block text-gray-700 text-sm font-semibold mb-2">Contenu</label>
                    <div id="editor" class="border border-gray-300 rounded-lg"></div>
                    <input type="hidden" name="contenu" id="contenuInput">
                </div>

                <div class="flex justify-end">
                    <a href="{{ route('admin.dashboard') }}" class="mr-4 px-6 py-3 text-gray-600 hover:text-gray-800">Annuler</a>
                    <button type="submit" class="bg-purple-500 hover:bg-purple-600 text-white font-semibold py-3 px-6 rounded-lg transition">Créer l'article</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        var quill = new Quill('#editor', {
            theme: 'snow',
            modules: {
                toolbar: [
                    ['bold', 'italic', 'underline', 'strike'],
                    ['blockquote', 'code-block'],
                    [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                    [{ 'header': [1, 2, 3, 4, 5, 6, false] }],
                    ['link', 'video'],
                    ['clean']
                ]
            }
        });

        // Avant de soumettre le formulaire
        document.getElementById('postForm').addEventListener('submit', function(e) {
            const content = quill.root.innerHTML;
            
            if (!content || content === '<p><br></p>') {
                e.preventDefault();
                alert('Veuillez écrire du contenu');
                return false;
            }
            
            document.getElementById('contenuInput').value = content;
        });
    </script>
</body>
</html>
