<x-app-layout>
    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        <div class="flex items-center mb-3">
            <a href="/projects/create">Create Project</a>
        </div>
        <div class="flex">
            <div class="w-1/4">
                <h3>Title</h3>
                <div>Lorem Ipsum</div>
            </div>
            <div class="w-1/4">
                <h3>Title</h3>
                <div>Lorem Ipsum</div>
            </div>
            <div class="w-1/4">
                <h3>Title</h3>
                <div>Lorem Ipsum</div>
            </div>
            <div class="w-1/4">
                <h3>Title</h3>
                <div>Lorem Ipsum</div>
            </div>
            <div class="w-1/4">
                <h3>Title</h3>
                <div>Lorem Ipsum</div>
            </div>
            <div class="w-1/4">
                <h3>Title</h3>
                <div>Lorem Ipsum</div>
            </div>
        </div>
        <div class="flex">
            @forelse ($projects as $project)
                <div class="w-1/4 bg-white rounded shadow">
                    <h3>{{ $project->title }}</h3>
                    <div>{{ $project->description }}</div>
                </div>
            @empty
                <div>No projects yet</div>
            @endforelse
        </div>
    </div>
</x-app-layout>
