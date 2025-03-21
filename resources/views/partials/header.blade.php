<div class="container mx-auto px-6 flex justify-between items-center">
    <h1 class="text-2xl font-bold text-gray-800">
        <a href="">Task Management</a>
    </h1>

    <nav class="flex items-center space-x-4">
        @auth
            <div class="flex items-center space-x-2">
                <span class="text-gray-700 font-medium">Hello, {{ Auth::user()->name }}</span>
                <form action="{{ route('logout') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="text-indigo-600 hover:text-indigo-500 font-medium">
                        Logout
                    </button>
                </form>
            </div>
        @else
            <a href="{{ route('login') }}" class="text-indigo-600 hover:text-indigo-500 font-medium">Login</a>
            <a href="{{ route('register') }}" class="text-indigo-600 hover:text-indigo-500 font-medium">Register</a>
        @endauth
    </nav>
</div>
