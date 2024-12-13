
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestionnaire de Tâches</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold mb-8">Nameless TODO APP</h1>

        <div class="mb-8 bg-white p-6 rounded-lg shadow">
            <form action="{{ route('tasks.store') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label for="title" class="block text-sm font-medium text-gray-700">Nouvelle tâche</label>
                    <input type="text" name="title" id="title" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    @error('title')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700">
                    Ajouter
                </button>
            </form>
        </div>

        <!-- Liste des tâches -->
        <div class="bg-white rounded-lg shadow">
            @forelse ($tasks as $task)
                <div class="flex items-center justify-between p-4 border-b last:border-b-0">
                    <div class="flex items-center space-x-4">
                        <span class="text-lg {{ $task->status === 'Terminée' ? 'line-through text-gray-400' : '' }}">
                            {{ $task->title }}
                        </span>
                        <span class="px-2 py-1 text-sm rounded-full {{ $task->status === 'Terminée' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                            {{ $task->status }}
                        </span>
                    </div>
                    <div class="flex space-x-2">
                        @if($task->status !== 'Terminée')
                            <form action="{{ route('tasks.update', $task) }}" method="POST" class="inline">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="bg-green-500 text-white px-3 py-1 rounded hover:bg-green-600">
                                    Terminer
                                </button>
                            </form>
                        @endif
                        <form action="{{ route('tasks.destroy', $task) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600">
                                Supprimer
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <p class="p-4 text-gray-500">Aucune tâche pour le moment.</p>
            @endforelse
        </div>
    </div>
</body>
</html>

