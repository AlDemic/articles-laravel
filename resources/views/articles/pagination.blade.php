<div class="articles__pagination">
    @if($articles->previousPageUrl() || $articles->hasMorePages())
        @for($i = 1; $i <= $articles->lastPage(); $i++)
            <a href="{{ $articles->url($i) }}" class="{{ $articles->currentPage() == $i ? 'disabled' : '' }}">{{ $i }}</a>
        @endfor
    @endif
</div>