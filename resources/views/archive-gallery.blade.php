@extends('layouts.app')

@section('content')
	@foreach($galleries as $gallery)
		@include('component::gallery.hero',[
			"data" => $gallery,
			"hero" => App::get_gallery_single_field($gallery->ID,"hero"),
			"url" => get_permalink($gallery->ID)
		])
	    @include('component::gallery.preview',[
	    	"images" => App::get_gallery_single_field($gallery->ID,"gallery_content",true),
	    	"preview_count" => App::get_gallery_single_field($gallery->ID,"preview_count"),
	    	"year" => get_object_term_cache( $gallery->ID, 'year' ),
	    	"month" => get_object_term_cache( $gallery->ID, 'month' ),
	    	"url" => get_permalink($gallery->ID)
	    ])
	@endforeach
@endsection