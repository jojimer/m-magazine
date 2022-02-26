<div class="shop-categories" data-post-id="{{$ID}}">
	@foreach($categories as $category)
		<div class="sgb bg-lozad" data-src="url('{{ Utility::acf_thumbnail($category['image'],'medium_large') }}') 1x">
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