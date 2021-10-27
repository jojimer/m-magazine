<div class="news-preview row m-0 gx-1 mm-news">
	@php $news_posts = array_splice($data, 1, 3); @endphp
	@foreach($news_posts as $news)
		@php 
			$thumbnail = App::get_news_single_field($news->ID,'url_image','thumbnail');
			$image_position = App::get_news_single_field($news->ID,'image_position','thumbnail');
	      	$views = App::get_news_single_field($news->ID,'views');
	      	$url = get_permalink($news->ID);
	    @endphp
		<div class="col" style="background-image: url({{ $thumbnail }}); background-position: {{ $image_position }};" data-post-id="{{$news->ID}}">
			<div class="news-feed-control">
			<button class="btn save-bookmark-btn" title="Save">@far_icon('bookmark')</button>
				<a href="{{ $url }}" class="btn btn-primary open-link-btn">Read More</a>	
			</div>
			<h5 class="news-title">{{ $news->post_title }}</h5>
			<div class="news-meta">
				<div class="dv-wrap">
					<span>{{ date('F j, Y', strtotime($news->post_date)) }}</span>
					<span>@fas_icon('eye') {{ $views }}</span>
				</div>
			</div>
		</div>
	@endforeach
</div>

@php wp_reset_postdata(); @endphp