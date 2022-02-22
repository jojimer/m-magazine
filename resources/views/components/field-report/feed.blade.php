<div class="field-report-block {{ $display }}" data-post-id="{{$data->ID}}">
	<div class="content-preview bg-lozad" data-src="{{ $images[0]['image'] }}">
		<div class="fr-view-counter">@fas_icon('eye') {{ $views }}</div>
		<div class="fr-main-info-wrap">
			<div class="profile-picture">
				<img class="lozad" data-src="{{ $author_avatar }}" alt="{{ $author_name }}">
			</div>				
			<div class="fr-info">
				<p class="h2">{{ $data->post_title }}</p>
				<p class="h5 font-weight-bold">{{ $author_name }}</p>
				<p class="font-weight-light mt-1">Author</p>
			</div>
			<div class="fr-date">
				<p class="font-weight-light">
					{{ date('F j, Y', strtotime($data->post_date)) }}
				</p>
			</div>
		</div>
	</div>
	<div class="content-meta-info">
		<div class="content-excerpt">
			<p class="font-weight-bold">Excerpt</p>
			<p class="text-left mb-2">
				{{ $excerpt }}
			<span class="fr-see-more"><a class="text-dark" href="{{ $url }}">See More @fas_icon('arrow-right')</a>
		</div>
		@if(count($tags) > 0)
		<div class="content-tags">			
			<p class="font-weight-bold">Tags</p>
			<p class="fr-tags">
				@foreach($tags as $tag)
					@php $href = esc_url( get_term_link( $tag )); @endphp
					<span><a class="fr-tag-link" href="{{ $href }}">#{{$tag->name}}</a></span>
				@endforeach
			</p>
		</div>
		@endif
		@if($images)
		<div class="content-images-preview">
			<p class="font-weight-bold">More Images</p>
			<ul>
				@foreach($images as $i => $image)
					@if($i < 7)
						<li>
							<img class="img-prev lozad" data-placeholder-background="rgba(0, 0, 0, 0.2)" data-src="{{ $image['image'] }}" alt="{{ $data->post_title }} {{ $i }}">
						</li>
					@endif		
				@endforeach
				<li><a class="text-dark" href="{{ $url }}">View More</a></li>
			</ul>
		</div>
		@endif
	</div>
</div>