<x-app-layout>
    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        <div class="lg:flex items-center mb-3 justify-between py-4">
            <h2 class="text-gray-500 font-normal text-m">My Projects</h2>
            <a href="/projects/create" class="btn btn-blue">Create Project</a>
        </div>

        <div class="space-y-2 lg:grid lg:grid-cols-3 lg:gap-4">
            @forelse ($projects as $project)
                <div class="p-5 bg-white rounded shadow">
                    <h3 class="font-normal text-xl py-4 mb-6 -ml-5  border-l-4 border-blue-400 pl-5 mb-3">
                        {{ $project->title }}
                    </h3>
                    <div class="text-gray-500">{{ Str::limit($project->description, 100) }}</div>
                </div>
            @empty
                <div>No projects yet</div>
            @endforelse
        </div>
    </div>
</x-app-layout>
