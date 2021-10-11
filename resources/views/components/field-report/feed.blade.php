<div class="field-report-block">
	@php		
		$excerpt = (strlen($data->post_excerpt) > 195) ? substr($data->post_excerpt, 0, 190) . '...' : $data->post_excerpt;
		$author_name = get_the_author_meta( 'display_name', $data->post_author );
		$author_avatar = get_avatar_url($data->post_author);
		//var_dump($images);
	@endphp
	<div class="content-preview" style="background-image: url({{ $images[0]['image'] }});">
		<div class="fr-main-info-wrap">
			<div class="profile-picture">
				<img src="{{ $author_avatar }}" alt="pp">
			</div>				
			<div class="fr-info">
				<p class="h2">{{ $data->post_title }}</p>
				<p class="h5 font-weight-bold">{{ $author_name }}</p>
				<p class="font-weight-light">Author</p>
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
			<span class="fr-see-more">See More</span>
			</p>
		</div>
		<div class="content-tags">
			<p class="font-weight-bold">Tags</p>
			<p class="fr-tags">
				@foreach($tags as $tag)
					<span>#{{$tag->name}}</span>
				@endforeach
			</p>
		</div>
		<div class="content-images-preview">
			<p class="font-weight-bold">More Images</p>
			<ul>
				@foreach($images as $i => $image)
					@if($i < 7)
						<li>
							<img class="img-prev" src="{{ $image['image'] }}" alt="{{ $data->post_title }} {{ $i }}">
						</li>
					@endif		
				@endforeach
				<li>View More</li>
			</ul>
		</div>
	</div>
</div>