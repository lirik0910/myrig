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
var_dump($news); die;

@endphp

<div id="dark__container" class="dark__container"></div>

<div class="products__container default__container">
	@foreach($news as $article)
		@include('partsNews.newsItem', $article)
	@endforeach
</div>

<div class="pagination__container default__container">
	@isset($news)
		{{ $news->links() }}
	@endisset
</div>

@endsection
