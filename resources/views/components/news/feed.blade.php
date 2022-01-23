<div class="news-feed-block mm-news bg-lozad" data-post-id="{{$data->ID}}" data-src="{{ $thumbnail }}" style="background-position: {{ $image_position }};">
	<div class="news-feed-control">
		<button class="btn save-bookmark-btn" title="Save">@far_icon('bookmark')</button>
		<a href="{{ $url }}" class="btn btn-primary open-link-btn">Read More</a>	
	</div>
	<h2 class="news-title">{{ $data->post_title }}</h2>
	<div class="news-info px-4">
		<div class="news-excerpt">{{ $caption }}</div>
		<div class="news-meta">
			<p class="h6">
				@php
					$tags = get_object_term_cache( $data->ID, 'tags' );
					$x = 0;
					foreach($tags as $tag){
						if($tag->name === 'latest-news' && $x === 0) {
							echo 'Latest News';
							$x = $x+1;
						}elseif($x === 0){
							echo $tag->name;
							$x = $x+1;
						}
					}					
				@endphp
			</p>
			<div class="dv-wrap">
				<span>{{ date('F j, Y', strtotime($data->post_date)) }}</span>
				<span>@fas_icon('eye') {{ $views }}</span>
			</div>
		</div>
	</div>
</div>

@php wp_reset_postdata(); @endphp