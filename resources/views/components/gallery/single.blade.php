<div class="gallery-single-wrap">
	<div class="gallery-single-close single-close d-none"><a href="/" class="single-previous-url text-dark">@fas_icon('arrow-left')</a></div>
	<div class="gallery-single-title">
		<div>
			<h1 class="gallery-title text-dark">{{ $data->post_title }}</h1>
			<div class="gallery-single-tags">
				<p>
					@php 
			            $output = '';
			            foreach($tags as $tag) {
		                    $output .= '<small class="gallery-tags"><a href="'. esc_url( get_term_link( $tag )). '">#'.$tag->name.'</a></small>';
		                }
		                foreach($month as $m) {
		                    $output .= '<small class="gallery-month"><a href="'. esc_url( get_term_link( $m )). '">#'.$m->name.'</a></small>';
		                }
		                foreach($year as $y) {
		                    $output .= '<small class="gallery-year"><a href="'. esc_url( get_term_link( $y )). '">#'.$y->name.'</a></small>';
		                }
			            echo $output;
					@endphp					
				</p>
			</div>
		</div>
		<div class="gallery-single-bookmark-wrap">
			<button class="btn save-bookmark-btn" title="Save">@far_icon('bookmark')</button>
			<span class="bookmark-views-wrap">@fas_icon('eye') {{ $views }}</span>
			<span class="gallery-single-date">{{ date('F j, Y', strtotime($data->post_date)) }}</span>
		</div>		
	</div>	
	<section class="masonry-wrap">
	@foreach($images as $index => $image)
	  <img src="{{ $image['gallery_image'] }}" alt="{{ $image['image_caption'] }}" />
	@endforeach
	</section>	
</div>
<div class="single-lightbox"></div>
<div class="image-lightbox">  
  <div class="filter"></div>
  <div class="arrowr"></div>
  <div class="arrowl"></div>
  <div class="close"></div>
  <div class="img-container"></div>
  <div class="title"></div>
</div>

@php wp_reset_postdata(); @endphp