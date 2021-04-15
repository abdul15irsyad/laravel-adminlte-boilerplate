<div class="locale-switch text-sm">
    @forelse(config('app.available_locale') as $i => $locale)
    <a href="{{ route(Route::currentRouteName(),['locale'=>$locale['locale']]) }}">{{ $locale['text'] }}</a>
    @if($i < (count(config('app.available_locale'))-1))
     | 
    @endif
    @empty
    @endforelse
</div>