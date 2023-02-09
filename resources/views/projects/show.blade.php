<x-app-layout>
    <main>
        <div class="max-w-7xl mx-auto lg:px-8 py-12 sm:px-6">
            <div class="lg:flex items-center mb-3 justify-between py-4">
                <p class="font-normal text-lg">
                    <a href="/projects">My Projects</a> / {{ $project->title }}
                </p>
                <a href="{{ $project->path() . '/edit' }}" class="btn btn-blue">Edit Project</a>
            </div>
            <div class="lg:flex">
                <div class="mb-4 lg:w-3/4 space-y-4">
                    <h3 class="font-lg mb-3 text-gray-500">Tasks</h3>
                    <div class="space-y-2">
                        @foreach($project->tasks as $task)
                            <div class="card p-4">
                                {{ $task->body }}
                            </div>
                        @endforeach
                            <div class="card p-4">
                                <form action="{{ $project->path() . '/tasks' }}" method="POST">
                                    @csrf
                                    <div class="flex justify-between space-x-2">
                                        <x-text-input
                                            name="body"
                                            class="block w-full pl-4 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                            placeholder="Add Task"
                                        />
                                        <button type="submit" class="btn btn-blue">Add</button>
                                    </div>

                                </form>
                            </div>
                    </div>
                    <h3 class="font-lg mb-3 text-gray-500">General Notes</h3>
                    <textarea class="card w-full" style="min-height: 200px">{{ $project->notes }}</textarea>

                </div>
                <div class="lg:w-1/4 px-2">
                    <div class="card p-4">
                        {{ $project->title }}
                        {{ $project->description }}
                    </div>
                </div>
            </div>
            <div>
                <a href="/projects" class="btn btn-blue">Go back</a>
            </div>
        </div>

    </main>
</x-app-layout>
