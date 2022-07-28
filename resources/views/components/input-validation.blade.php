@props(['for'])

@if ($errors->has($for))
    <p class="mt-1 text-sm text-red-800">{{ $errors->first($for) }}</p>
@endif
