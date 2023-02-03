<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ $project->path() }}" method="POST" class="space-y-8 divide-y divide-gray-200">
                        @csrf
                        @method('PATCH')
                        <div class="space-y-8 divide-y divide-gray-200 sm:space-y-5">
                            <div class="space-y-6 sm:space-y-5">
                                <div class="space-y-6 sm:space-y-5">
                                    <div class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4 sm:border-t sm:border-gray-200 sm:pt-5">
                                        <label for="title" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">Title</label>
                                        <div class="mt-1 sm:col-span-2 sm:mt-0">
                                            <div class="flex max-w-lg rounded-md shadow-sm">
                                                <input type="text"
                                                       name="title"
                                                       class="block w-full min-w-0 flex-1 rounded-none rounded-r-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                                       value="{{ $project->title }}"
                                                >
                                            </div>
                                        </div>
                                    </div>

                                    <div class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4 sm:border-t sm:border-gray-200 sm:pt-5">
                                        <label for="description" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">Description</label>
                                        <div class="mt-1 sm:col-span-2 sm:mt-0">
                                            <textarea name="description"
                                                      rows="3"
                                                      class="block w-full max-w-lg rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">{{ $project->description }}</textarea>
                                            <p class="mt-2 text-sm text-gray-500">Write a few sentences about the project.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="pt-5">
                            <div class="flex justify-end space-x-8">
                                <a href="{{ $project->path() }}"
                                   class="btn"
                                >
                                    Cancel
                                </a>
                                <button type="submit"
                                        class="btn btn-blue"
                                >
                                    Save
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
