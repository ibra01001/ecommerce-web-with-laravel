<a href="{{ url('/') }}" class="flex items-center">
    @if($currentLogoUrl)
        <img src="{{ $currentLogoUrl }}" alt="Site Logo" class="h-12">
    @else
        <span class="text-xl font-bold">{{ config('app.name') }}</span>
    @endif
</a>