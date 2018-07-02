@extends('layouts.app')

@section('content')

@php
$page_limit = 10;
$page_no = $request->get('page');
//var_dump($it->link); die;
$en_parent_page = \App\Model\Base\Page::where('link', $it->link)
	->whereHas('context', function ($q){
		$q->where('title', 'EN');
	})
	->first();
$ua_parent_page = \App\Model\Base\Page::where('link', $it->link)
	->whereHas('context', function ($q){
		$q->where('title', 'UA');
	})
	->first();
$ru_parent_page = \App\Model\Base\Page::where('link', $it->link)
	->whereHas('context', function ($q){
		$q->where('title', 'RU');
	})
	->first();

if (isset($page_no)) {
	if($locale == 'en'){
		$news = App\Model\Base\Page::where('published', 1)
			->where('parent_id', $en_parent_page->id)
			->offset($page_limit * ($page_no - 1))
			->orderBy('created_at', 'DESC')
			->paginate($page_limit);
	} else{
		$news = App\Model\Base\Page::where('published', 1)
			->where('parent_id', $ua_parent_page->id)
			->orWhere('parent_id', $ru_parent_page->id)
			->offset($page_limit * ($page_no - 1))
			->orderBy('created_at', 'DESC')
			->paginate($page_limit);
	}
} else {
	if($locale == 'en'){
		$news = App\Model\Base\Page::where('published', 1)
			->where('parent_id', $en_parent_page->id)
			->orderBy('created_at', 'DESC')
			->paginate($page_limit);
	} else{
		$news = App\Model\Base\Page::where('published', 1)
			->where('parent_id', $ua_parent_page->id)
			->orWhere('parent_id', $ru_parent_page->id)
			->orderBy('created_at', 'DESC')
			->paginate($page_limit);
	}

}



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
