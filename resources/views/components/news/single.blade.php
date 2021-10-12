<div class="news-single-wrap">
	<div class="news-single-close single-close d-none"><a href="/" class="single-previous-url text-dark">@fas_icon('arrow-left')</a></div>
	<div class="news-single-title">
		<h1 class="news-title text-dark">{{ $data->post_title }}</h1>
		<div class="news-single-bookmark-wrap">
			<button class="btn save-bookmark-btn" title="Save">@far_icon('bookmark')</button>		
			<span>@fas_icon('eye') {{ $views }}</span>
		</div>
	</div>
	<div class="news-single-tags-date">
		<p>
			@foreach($tags as $tag)
				@php $href = esc_url( get_term_link( $tag )); @endphp
	            <small class="news-tags"><a href="{{ $href }}">#{{$tag->name}}</a></small>
			@endforeach
			<span>{{ date('F j, Y', strtotime($data->post_date)) }}</span>
		</p>
	</div>
	<div class="news-single-block" style="background-image: url({{ $thumbnail }}); background-position: {{ $image_position }};">
		<div class="external-link-wrap"><a class="external-link" href="{{ $news_url }}" target="_blank">@fas_icon('external-link-alt')</a></div>
		<div class="news-info px-4">
			<div class="news-excerpt">{{ $excerpt }}</div>
		</div>
	</div>
	<div class="news-single-content">
		<p>{{ $caption }}</p>
	</div>
	@php comments_template('/partials/comments.blade.php') @endphp
</div>
<div class="single-lightbox"></div>

@php wp_reset_postdata(); @endphp