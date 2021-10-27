<div class="vip-deal-block" data-post-id="{{$ID}}" style="background-image: url({{ $deal['image'] }}); background-position: {{ $deal['image_position'] }};">
	<div>			
		<p class="vip-deal-main-text h1">{{ $deal['title'] }}</p>
		<p class="vip-deal-sub-category h4 font-weight-bold">{{ $deal['subtitle'] }}</p>
	</div>
	<div class="vip-icon">
		<img src="@asset('images/vip.jpg')" alt="profile-name">
	</div>
	<div class="call-to-action">
		<span>@fas_icon('eye') {{ $deal['views'] }}</span>	
		<a href="{{ $url }}" class="btn btn-danger text-white">{{ $deal['button_text'] }}</a>
	</div>
</div>