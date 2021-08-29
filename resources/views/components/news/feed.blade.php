<div class="news-headline-block mm-news" style="background-image: url({{ $thumbnail }}); background-position: {{ $image_position }};">
	<h2 class="news-title">{{ $data->post_title }}</h2>
	<div class="news-info px-4">
		<div class="news-excerpt">{{ $caption }}</div>
		<div class="news-meta">
			<p class="h6">Latest News</p>
			<div class="dv-wrap">
				<span>{{ date('F j, Y', strtotime($data->post_date)) }}</span>
				<span>@fas_icon('eye') {{ $views }}</span>
			</div>
		</div>
	</div>
</div>

@php wp_reset_postdata(); @endphp