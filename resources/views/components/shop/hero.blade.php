<div class="shop-hero-block" data-post-id="{{$ID}}">
	<div class="hero-wrap" style="background-image: url({{ $hero['image'] }});">
		<div class="call-to-action {{ $hero['text_and_button_position'] }}">
			<p class="product-sub-category">{{ $hero['subtitle'] }}</p>
			<p class="product-main-text">{{ $hero['title'] }}</p>
			<a href="{{ $hero['button_url'] }}" class="btn btn-warning text-white">{{ $hero['button_text'] }}</a>
		</div>
	</div>
</div>