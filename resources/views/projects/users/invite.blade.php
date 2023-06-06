<div class="card mt-2 px-4 py-10">
    <form action="{{ route('projects.invite', $project) }}" method="POST" class="space-y-2">
        @csrf
        <div>
            <input type="text" name="email" class="w-full rounded" placeholder="Enter Email">
        </div>
        <div class="flex justify-end">
            <button type="submit" class="btn btn-blue">Invite</button>
        </div>
    </form>
    @include("includes.errors")
</div>
