@php
    $current_page = $paginator->currentPage();
    $last_page = $paginator->lastPage();
@endphp
<div class="text-center">
    <ul class="pagination text-center">
        @if($current_page > 1)
        <li>
            <a class="prev page-numbers" href="{{ $paginator->previousPageUrl() }}" data-wpel-link="internal"><i class="article-arrow article-arrow-left"></i></a>
        </li>
        <li>
            <a class="page-numbers" href="{{ $paginator->url(1) }}" data-wpel-link="internal">1</a>
        </li>
        @endif
        @if($current_page > 2)
        <li>
            <span class="page-numbers dots">…</span>
        </li>
        <li>
            <a class="page-numbers" href="{{ $paginator->url($current_page - 1) }}" data-wpel-link="internal">{{ $current_page - 1 }}</a>
        </li>
        @endif
        <li>
            <span aria-current="page" class="page-numbers current">{{ $current_page }}</span>
        </li>
        @if(($current_page + 1) < $paginator->lastPage())
        <li>
            <a class="page-numbers" href="{{ $paginator->url($current_page + 1) }}" data-wpel-link="internal">{{ $current_page + 1 }}</a>
        </li>
        @endif
        @if(($paginator->lastPage() - $current_page) > 2)
        <li>
            <span class="page-numbers dots">…</span>
        </li>
        @endif
        @if($current_page !== $last_page)
        <li>
            <a class="page-numbers" href="{{ $paginator->url($last_page) }}" data-wpel-link="internal">{{ $last_page }}</a>
        </li>
        <li>
            <a class="next page-numbers" href="{{ $paginator->nextPageUrl() }}" data-wpel-link="internal"><i class="article-arrow article-arrow-right"></i></a>
        </li>
        @endif
    </ul>
</div>