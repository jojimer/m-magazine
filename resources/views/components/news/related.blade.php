<div class="news-preview row m-0 gx-1 mm-news">
	@php $news_posts = array_splice($data, 1, 3); @endphp
	@foreach($news_posts as $news)
		@php 
			$thumbnail = Page::get_acf_single_field($news->ID,'url_image','thumbnail');
			$image_position = Page::get_acf_single_field($news->ID,'image_position','thumbnail');
	      	$views = Page::get_acf_single_field($news->ID,'views');
	    @endphp
		<div class="col" style="background-image: url({{ $thumbnail }}); background-position: {{ $image_position }};">
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