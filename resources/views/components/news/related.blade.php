<div class="news-preview row m-0 gx-1 mm-news">
	@php $news_posts = array_splice($data, 1, 3); @endphp
	@foreach($news_posts as $news)
		<div class="col" style="background-image: url({{ Page::thumbnail($news->ID,'medium') }});">
			<h2 class="news-title">{{ $news->post_title }}</h2>
			<div class="news-meta">
				<div class="dv-wrap">
					<span>{{ date('F j, Y', strtotime($news->post_date)) }}</span>
					<span>@fas_icon('eye') 32</span>
				</div>
			</div>
		</div>
	@endforeach
</div>

@php wp_reset_postdata(); @endphp