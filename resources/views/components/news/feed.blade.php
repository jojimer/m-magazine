<div class="news-headline-block mm-news" style="background-image: url({{ $thumbnail }});">
	<h2 class="news-title">{{ $data->post_title }}</h2>
	<div class="news-info px-4">
		<div class="news-excerpt">{{ $data->post_excerpt }}</div>
		<div class="news-meta">
			<p class="h6">Latest News</p>
			<div class="dv-wrap">
				<span>{{ date('F j, Y', strtotime($data->post_date)) }}</span>
				<span>@fas_icon('eye') 18</span>
			</div>
		</div>
	</div>
</div>

@php wp_reset_postdata(); @endphp