@extends('layouts.app')

@section('content')
  @while(have_posts()) 
  @php 
  	the_post();
    Utility::updateViewCount($post->ID)
  @endphp
    @include('component::gallery.single',[
    	"data" => $post,
    	"tags" => get_object_term_cache( $post->ID, 'tags' ),
			"month" => get_object_term_cache( $post->ID, 'month' ),
			"year" => get_object_term_cache( $post->ID, 'year' ),
			"images" => App::get_gallery_single_field($post->ID,"gallery_content",true),
			"views" => App::get_gallery_single_field($post->ID,'views'),
    ])
  @endwhile
@endsection