@php
    $current_page = $paginator->currentPage();
    $last_page = $paginator->lastPage();
@endphp
<div class="text-center">
    <ul class="pagination text-center">
        @if($current_page > 1)
        <li class="page-item">
            <a class="prev page-numbers page-link" href="{{ $paginator->previousPageUrl() }}" data-wpel-link="internal" aria-label="Previous" style="left: 0;">
                <span aria-hidden="true">&lang;</span>
            </a>
        </li>
        <li class="page-item">
            <a class="page-numbers" href="{{ $paginator->url(1) }}" data-wpel-link="internal" style="display: block">1</a>
        </li>
        @endif
        @if($current_page > 2)
        <li>
            <span class="page-numbers dots">…</span>
        </li>
        <li class="page-item">
            <a class="page-numbers" href="{{ $paginator->url($current_page - 1) }}" data-wpel-link="internal" style="display: block">{{ $current_page - 1 }}</a>
        </li>
        @endif
        <li class="page-item">
            <span aria-current="page" class="page-numbers current">{{ $current_page }}</span>
        </li>
        @if(($current_page + 1) < $paginator->lastPage())
        <li class="page-item">
            <a class="page-numbers" href="{{ $paginator->url($current_page + 1) }}" data-wpel-link="internal" style="display: block">{{ $current_page + 1 }}</a>
        </li>
        @endif
        @if(($paginator->lastPage() - $current_page) > 2)
        <li>
            <span class="page-numbers dots">…</span>
        </li>
        @endif
        @if($current_page !== $last_page)
        <li class="page-item">
            <a class="page-numbers" href="{{ $paginator->url($last_page) }}" data-wpel-link="internal" style="display: block">{{ $last_page }}</a>
        </li>
        <li class="page-item">
            <a class="next page-numbers page-link" href="{{ $paginator->nextPageUrl() }}" data-wpel-link="internal" aria-label="Next" style="display: block">
                <span aria-hidden="true">&rang;</span>
            </a>
        </li>
        @endif
    </ul>
</div>