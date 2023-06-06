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
                                <form method="POST" action="{{ route('project.task.update', compact('project', 'task')) }}">
                                    @csrf
                                    @method('PATCH')
                                    <div class="flex items-center space-x-3">
                                        <x-text-input
                                            class="w-full p-2 {{ $task->completed ? 'text-gray-400' : '' }}"
                                            name="body"
                                            value="{{ $task->body }}"
                                        />
                                        <input class="w-4 h-4"
                                               type="checkbox"
                                               name="completed"
                                               @if($task->completed) checked @endif
                                               onChange="this.form.submit()"
                                        />
                                    </div>
                                </form>

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
                    <form method="POST" action="{{ $project->path()  }}">
                        @method('PATCH')
                        @csrf
                        <div>
                            <textarea class="card w-full" name="notes" style="min-height: 200px">{{ $project->notes }}</textarea>
                        </div>
                        <div>
                            <button type="submit" class="btn btn-blue">Save Notes</button>
                        </div>
                    </form>
                    @include("includes.errors")
                </div>
                <div class="lg:w-1/4 px-2">
                    <div class="card p-4">
                        <h2 class="font-bold mb-3">{{ $project->title }}</h2>
                        <p>{{ $project->description }}</p>
                        <div class="mt-4 flex justify-end">
                            <form action="" method="POST">
                                @method('DELETE')
                                <button type="submit" class="text-sm text-blue-500">Delete</button>
                            </form>
                        </div>

                    </div>
                    @include('projects.activities.card')
                    @include('projects.users.invite')
                </div>
            </div>
        </div>

    </main>
</x-app-layout>
