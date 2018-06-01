@extends('layouts.app')

@section('content')

@php
$page_limit = 10;
$page_no = $request->get('page');

$ua_parent_page = \App\Model\Base\Page::where('link', $it->link)
	->where('context_id', 2)
	->first();
$ru_parent_page = \App\Model\Base\Page::where('link', $it->link)
	->where('context_id', 3)
	->first();

if (isset($page_no)) {
	$news = App\Model\Base\Page::where('parent_id', $ua_parent_page->id)
		->orWhere('parent_id', $ua_parent_page)
		->offset($page_limit * ($page_no - 1))
		->orderBy('created_at', 'DESC')
		->paginate($page_limit);
} 
else {
	$news = App\Model\Base\Page::where('parent_id', $ua_parent_page->id)
		->orWhere('parent_id', $ru_parent_page->id)
		->orderBy('created_at', 'DESC')
		->paginate($page_limit);
}

@endphp

<div id="dark__container" class="dark__container"></div>

<div class="products__container default__container">
	@foreach($news as $article)
		@include('partsNews.newsItem', $article)
	@endforeach
</div>

@if(isset($news))
	<div class="pagination__container default__container">
	<div class="text-center">
	<ul class="pagination text-center">
									<li class="page-item">
				<span aria-current="page" class="page-numbers current">1</span>
			</li>
						<li class="page-item">
			<a class="page-numbers" href="http://test-myrig.ru/news?page=2" data-wpel-link="internal" style="display: block">2</a>
		</li>
						<li>
			<span class="page-numbers dots">…</span>
		</li>
						<li class="page-item">
			<a class="page-numbers" href="http://test-myrig.ru/news?page=132" data-wpel-link="internal" style="display: block">132</a>
		</li>
		<li class="page-item">
			<a class="next page-numbers page-link" href="http://test-myrig.ru/news?page=2" data-wpel-link="internal" aria-label="Next" style="display: block">
				<span aria-hidden="true">&rang;</span>
			</a>
		</li>
			</ul>
</div>
	</div>
@endif

@endsection
