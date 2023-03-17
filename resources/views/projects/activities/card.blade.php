<div class="card mt-2 px-4 py-10">
    <ul class="space-y-2">
        @foreach($project->activities as $activity)
            <li class="text-sm">@include('projects.activities.' . $activity->description ) - {{ $activity->created_at->diffForHumans() }}</li>
        @endforeach
    </ul>
</div>
