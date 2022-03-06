<div class="vip-deal-single-wrap">
	<div class="vip-deal-single-close single-close d-none"><a href="/" class="single-previous-url text-dark">@fas_icon('arrow-left')</a></div>
	<div class="vip-deal-single-block bg-lozad" data-src="{{ Utility::getImageSrcSet($vip_deal['image'],'medium_large') }}" style="background-position: {{ $vip_deal['image_position'] }};">

		<div>			
			<p class="vip-deal-main-text h1">{{ $vip_deal['title'] }}</p>
			<p class="vip-deal-sub-category h4 font-weight-bold">{{ $vip_deal['subtitle'] }}</p>
		</div>
		<div class="vip-icon">
			<img class="lozad" data-placeholder-background="rgba(0, 0, 0, 0.2)" data-src="@asset('images/vip.jpg')" alt="profile-name">
		</div>
		<div class="call-to-action">
			<span>@fas_icon('eye') {{ $views }}</span>
		</div>
	</div>
	<div class="vip-deal-single-tags-date">
		<p>
			@foreach($tags as $tag)
				@php $href = esc_url( get_term_link( $tag )); @endphp
	            <small class="vip-deal-tags"><a href="{{ $href }}">#{{$tag->name}}</a></small>
			@endforeach
			<span>{{ date('F j, Y', strtotime($data->post_date)) }}</span>
		</p>
	</div>
	<div class="vip-deal-single-content">{{ $vip_deal['description'] }}</div>
	@php comments_template('/partials/comments.blade.php') @endphp
</div>
<div class="single-lightbox"></div>

@php wp_reset_postdata(); @endphp