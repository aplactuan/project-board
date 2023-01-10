<x-app-layout>
    <x-slot name="header">

    </x-slot>

    <main>
        <div class="lg:flex max-w-7xl mx-auto sm:px-6 lg:px-8 py-12">
            <div class="mb-4 lg:w-3/4 space-y-4">
                <h3 class="font-lg mb-3 text-gray-500">Tasks</h3>
                <div class="space-y-2">
                    @foreach($project->tasks as $task)
                        <div class="card p-4">
                            {{ $task->body }}
                        </div>
                    @endforeach
                </div>
                <h3 class="font-lg mb-3 text-gray-500">General Notes</h3>
                <div class="card">{{ $project->notes }}</div>
            </div>
            <div class="lg:w-1/4 px-2">
                <div class="card p-4">
                    {{ $project->title }}
                    {{ $project->description }}
                </div>
            </div>
        </div>
    </main>
</x-app-layout>
