<div class="shop-categories" data-post-id="{{$ID}}">
	@foreach($categories as $category)
		<div class="sgb" style="background-image: url({{ $category['image'] }});">
		 	<div class="cta-category">
		 		<div class="cta-category-text">
		 			<span>{{ $category['subtitle'] }}</span>
		 		    <p class="h2">{{ $category['title'] }}</p>
		 		</div>
		 		<div class="cta-category-button">
		 		    <a href="{{ $category['button_url'] }}" class="btn btn-warning text-white">{{ $category['button_text'] }}</a>
		 	    </div>
			</div>
		</div>
	@endforeach
</div>