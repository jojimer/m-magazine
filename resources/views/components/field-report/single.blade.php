<div class="field-report-single-wrap">
	<div class="field-report-single-close single-close d-none"><a href="/" class="single-previous-url text-dark">@fas_icon('arrow-left')</a></div>
	<div class="field-report-single-title">
		<div>
			<h1 class="field-report-title text-dark">{{ $data->post_title }}</h1>
			<div class="field-report-single-tags">
				<p>
		            @foreach($tags as $tag)
		            	@php $href = esc_url( get_term_link( $tag )); @endphp
	                    <small class="field-report-tags"><a href="{{ $href }}">#{{ $tag->name }}</a></small>
	                @endforeach				
				</p>
			</div>
		</div>
		<div class="field-report-single-bookmark-wrap">
			<button class="btn save-bookmark-btn" title="Save">@far_icon('bookmark')</button>
			<span class="bookmark-views-wrap">@fas_icon('eye') {{ $views }}</span>
			<span class="field-report-single-date">{{ date('F j, Y', strtotime($data->post_date)) }}</span>
		</div>		
	</div>
	<section class="fr-content my-5">
		<p class="text-justify">{{ $data->post_excerpt }}</p>
	</section>
	<section class="masonry-wrap">
	@foreach($images as $index => $image)
	  <img class="lozad"  data-placeholder-background="rgba(0, 0, 0, 0.2)" data-src="{{ Utility::acf_thumbnail($image['image'],'large') }}" alt="{{ $image['title'] }}" />
	@endforeach
	</section>
	<section class="fr-author-info bg-secondary my-5 p-5">
		<h3 class="text-right mb-5">About the Author</h3>
		<div class="fr-author">			
			<div class="fr-author-details">
				<span class="profile-picture">
					<img class="lozad"  data-placeholder-background="rgba(0, 0, 0, 0.2)" data-src="{{ $author_avatar }}" alt="{{ $author_name }}">
				</span>
				<p class="h5 font-weight-bold mt-2 mb-0">{{ $author_name }}</p>
				<p class="font-weight-light">Author</p>
			</div>
			<p class="author-bio">{{ $author_bio }}</p>
		</div>
	</section>
	@php comments_template('/partials/comments.blade.php') @endphp
</div>
<div class="single-lightbox"></div>
<div class="fr-image-lightbox">  
  <div class="filter"></div>
  <div class="arrowr"></div>
  <div class="arrowl"></div>
  <div class="close"></div>
  <div class="img-container"></div>
  <div class="title d-none"></div>
</div>

@php wp_reset_postdata(); @endphp