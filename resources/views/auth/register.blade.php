<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription — BlogPrince</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { background-color: #F9F8FF; font-family: 'Inter', sans-serif; }
    </style>
    @include('auth.partials.form-utils')
</head>
<body class="min-h-screen flex items-center justify-center px-4 py-12">
    <div class="w-full max-w-md">
        <div class="text-center mb-8">
            <a href="{{ route('home') }}" class="inline-flex items-center space-x-2">
                <div class="w-10 h-10 bg-purple-600 rounded-lg flex items-center justify-center">
                    <span class="text-white font-bold">P</span>
                </div>
                <span class="text-2xl font-bold text-gray-800">Blog<span class="text-purple-600">Prince</span></span>
            </a>
            <p class="text-gray-500 mt-3">Créez un compte pour liker et commenter</p>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
            @if($errors->any())
                <div class="mb-4 p-3 bg-red-100 border border-red-400 text-red-700 rounded-lg text-sm">
                    <ul class="list-disc list-inside">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('register.post') }}" novalidate>
                @csrf
                @if($redirect)
                    <input type="hidden" name="redirect" value="{{ $redirect }}">
                @endif

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-semibold mb-2">Nom / Pseudo</label>
                    <input type="text" name="name" value="{{ old('name') }}" required autofocus
                        class="auth-input w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-purple-500"
                        placeholder="Votre nom affiché">
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-semibold mb-2">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" required
                        placeholder="exemple@gmail.com"
                        class="auth-input w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-purple-500">
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-semibold mb-2">Mot de passe</label>
                    @include('auth.partials.password-field', [
                        'id' => 'register-password',
                        'name' => 'password',
                        'placeholder' => 'Minimum 8 caractères',
                        'required' => true,
                    ])
                </div>

                <div class="mb-6">
                    <label class="block text-gray-700 text-sm font-semibold mb-2">Confirmer le mot de passe</label>
                    @include('auth.partials.password-field', [
                        'id' => 'register-password-confirmation',
                        'name' => 'password_confirmation',
                        'placeholder' => 'Retapez votre mot de passe',
                        'required' => true,
                    ])
                </div>

                <button type="submit" class="w-full bg-purple-600 hover:bg-purple-700 text-white font-semibold py-3 rounded-xl transition">
                    Créer mon compte
                </button>
            </form>

            <p class="text-center text-sm text-gray-500 mt-6">
                Déjà inscrit ?
                <a href="{{ route('login', $redirect ? ['redirect' => $redirect] : []) }}" class="text-purple-600 font-semibold hover:underline">Se connecter</a>
            </p>
        </div>

        <p class="text-center mt-6">
            <a href="{{ route('home') }}" class="text-sm text-gray-500 hover:text-purple-600">← Retour à l'accueil</a>
        </p>
    </div>
</body>
</html>
