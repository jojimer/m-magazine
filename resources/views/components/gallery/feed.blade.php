<div class="gallery-feed-block mm-gallery">
	<p class="h2">Month Of {{ $month[0]->name }} Preview</p>
	<div class="gallery-preview-images">
		<ol>
			@foreach($images as $index => $image)
				<li class="portrait" id="image-{{ $month[0]->name . "-" . $year[0]->name . "-" . $index }}">
					<img src="{{ $image['gallery_image'] }}" alt="image1">
					<div class="view-image">
						@fas_icon('search')
					</div>
				</li>
			@endforeach
		</ol>
	</div>
	<div class="gallery-preview-control">
		<ol>
			@php $all_images = count($images)-2; @endphp
			@for ($i = 1; $i <= $preview_count; $i++)
				@if($all_images >= $i)
					@php $class = ($i <= 3) ? '' : 'class=img-hidden'; @endphp
					<li {{ $class }}></li>
				@endif
			@endfor
		</ol>
	</div>
</div>