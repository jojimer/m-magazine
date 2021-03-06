<div class="products-block" data-post-id="{{$ID}}">
	@foreach($products as $product)
		<div class="product bg-lozad" data-src="url('{{ Utility::acf_thumbnail($product['image'],'medium_large') }}') 1x">
		 	<div class="cta-product">
		 		<div class="cta-product-text">
		 			<span>{{ $product['subtitle'] }}</span>
		 		    <p class="h2">{{ $product['title'] }}</p>
		 		</div>
		 		<div class="cta-product-button">
		 		    <a href="{{ $product['button_url'] }}" class="btn btn-secondary text-white">
		 		    	{{ $product['button_text'] }}
		 			</a>
		 	    </div>
			</div>
		</div>
	@endforeach
</div>