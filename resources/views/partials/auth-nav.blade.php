<div class="flex items-center space-x-3">
    @auth
        <span class="text-sm text-gray-600 hidden sm:inline">Bonjour, <strong class="text-purple-600">{{ Auth::user()->name }}</strong></span>
        <form method="POST" action="{{ route('logout') }}" class="inline">
            @csrf
            <button type="submit" class="text-sm text-gray-600 hover:text-purple-600 font-medium transition">Déconnexion</button>
        </form>
    @else
        <a href="{{ route('login', ['redirect' => url()->current()]) }}" class="text-sm text-gray-600 hover:text-purple-600 font-medium transition">Connexion</a>
        <a href="{{ route('register', ['redirect' => url()->current()]) }}" class="text-sm bg-purple-600 hover:bg-purple-700 text-white font-medium px-4 py-2 rounded-lg transition">Inscription</a>
    @endauth
</div>
