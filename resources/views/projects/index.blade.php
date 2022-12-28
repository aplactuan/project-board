<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class=overflow-hidden">
                <div class="flex items-center justify-between my-5">
                    <h2 class="text-gray-500 text-lg">My Projects</h2>
                    <a href="#" class="btn btn-blue">Add Projects</a>
                </div>
                <div>
                    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
                        @forelse($projects as $project)
                            <div class="col-span-1 divide-y divide-gray-200 rounded-lg bg-white shadow">
                                <div class="flex w-full items-center justify-between space-x-6 p-6">
                                    <div class="flex-1 truncate">
                                        <div class="flex items-center space-x-3">
                                            <h3 class="truncate text-m font-medium text-gray-900 font-bold">{{ $project->title }}</h3>
                                        </div>
                                        <p class="mt-1 text-gray-500">{{ $project->description }}</p>
                                    </div>
                                </div>
                                <div>

                                </div>
                            </div>
                        @empty
                            <li>
                                <div>
                                    No Project Created
                                </div>
                            </li>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
