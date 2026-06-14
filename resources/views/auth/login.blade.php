<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion — BlogPrince</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { background-color: #F9F8FF; font-family: 'Inter', sans-serif; }
    </style>
    @include('auth.partials.form-utils')
</head>
<body class="min-h-screen flex items-center justify-center px-4">
    <div class="w-full max-w-md">
        <div class="text-center mb-8">
            <a href="{{ route('home') }}" class="inline-flex items-center space-x-2">
                <div class="w-10 h-10 bg-purple-600 rounded-lg flex items-center justify-center">
                    <span class="text-white font-bold">P</span>
                </div>
                <span class="text-2xl font-bold text-gray-800">Blog<span class="text-purple-600">Prince</span></span>
            </a>
            <p class="text-gray-500 mt-3">Connectez-vous pour liker et commenter</p>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
            @if(session('success'))
                <div class="mb-4 p-3 bg-green-100 border border-green-400 text-green-700 rounded-lg text-sm">
                    {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div class="mb-4 p-3 bg-red-100 border border-red-400 text-red-700 rounded-lg text-sm">
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('login.post') }}" novalidate>
                @csrf
                @if($redirect)
                    <input type="hidden" name="redirect" value="{{ $redirect }}">
                @endif

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-semibold mb-2">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" required autofocus
                        placeholder="exemple@gmail.com"
                        class="auth-input w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-purple-500">
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-semibold mb-2">Mot de passe</label>
                    @include('auth.partials.password-field', [
                        'id' => 'login-password',
                        'name' => 'password',
                        'placeholder' => 'Votre mot de passe',
                        'required' => true,
                    ])
                </div>

                <div class="mb-6">
                    <label class="flex items-center text-sm text-gray-600">
                        <input type="checkbox" name="remember" class="mr-2 rounded border-gray-300 text-purple-600 focus:ring-purple-500">
                        Se souvenir de moi
                    </label>
                </div>

                <button type="submit" class="w-full bg-purple-600 hover:bg-purple-700 text-white font-semibold py-3 rounded-xl transition">
                    Se connecter
                </button>
            </form>

            <p class="text-center text-sm text-gray-500 mt-6">
                Pas encore de compte ?
                <a href="{{ route('register', $redirect ? ['redirect' => $redirect] : []) }}" class="text-purple-600 font-semibold hover:underline">S'inscrire</a>
            </p>
        </div>

        <p class="text-center mt-6">
            <a href="{{ route('home') }}" class="text-sm text-gray-500 hover:text-purple-600">← Retour à l'accueil</a>
        </p>
    </div>
</body>
</html>
