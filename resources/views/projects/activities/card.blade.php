<div class="card mt-2 p-4">
    <ul>
        @foreach($project->activities as $activity)
            <li>@include('projects.activities.' . $activity->description )</li>
        @endforeach
    </ul>
</div>
