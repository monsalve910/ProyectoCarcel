<nav class="bg-green-800 text-white shadow-lg">
    <div class="container mx-auto px-4">
        <div class="flex items-center justify-between py-4">
            <div class="flex items-center space-x-4">
                <a href="{{ route('guardia.dashboard') }}" class="font-bold text-xl">Cárcel El Redentor</a>
                <span class="text-sm text-green-200">Panel de Guardia</span>
            </div>
            <div class="flex items-center space-x-4">
                <a href="{{ route('prisioneros.index') }}" class="hover:text-green-200">Prisioneros</a>
                <a href="{{ route('visitantes.index') }}" class="hover:text-green-200">Visitantes</a>
                <a href="{{ route('visitas.index') }}" class="hover:text-green-200">Visitas</a>
                <form action="{{ route('logout') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="bg-red-600 hover:bg-red-700 px-4 py-2 rounded">Cerrar Sesión</button>
                </form>
            </div>
        </div>
    </div>
</nav>
