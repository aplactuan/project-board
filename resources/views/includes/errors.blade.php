@if ($errors->{$bag ?? 'default'}->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->invitations->all() as $error)
                <li class="text-sm text-red-600">{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
