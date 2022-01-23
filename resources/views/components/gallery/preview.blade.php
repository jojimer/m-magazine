<div class="gallery-preview-block mm-gallery">
	<p class="h2">Month Of {{ $month[0]->name }} Preview</p>
	<div class="gallery-preview-images" id="imagesContainer">
		<ol class="gallery-slider-wrap">
			@foreach($images as $index => $image)
				@if($index < $preview_count)
					<li class="portrait gallery-slide">
						<img class="lozad" data-placeholder-background="rgba(0, 0, 0, 0.2)" data-src="{{ $image['gallery_image'] }}" alt="{{ $image['image_caption'] }}">
						<div class="view-image" id="image-{{ $month[0]->name . "-" . $year[0]->name . "-" . $index }}">
							<a class="text-white" href="{{ $url }}">@fas_icon('search')</a>
						</div>
					</li>
				@endif
			@endforeach
			<li class="preview-image-btn bg-light"><a href="{{ $url }}" class="btn btn-dark btn-lg">View All</a></li>
		</ol>
	</div>
	<div class="gallery-preview-control">
		<ol>
			@php 
				$images_count = count($images);
				$count = ($preview_count > $images_count) ? $images_count : $preview_count; 
			@endphp
			@for ($i = 0; $i <= $count; $i++)
				@if($count >= $i)
					@php $class = ($i <= 2) ? '' : 'class=img-hidden'; @endphp
					<li data-index="{{$i}}" {{ $class }}></li>
				@endif
			@endfor
		</ol>
	</div>
</div>