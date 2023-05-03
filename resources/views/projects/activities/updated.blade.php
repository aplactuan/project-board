@if (count($activity->changes['after']) == 1)
    You updated the {{ array_key_first($activity->changes['after']) }} of the project
@else
    Project was updated
@endif
