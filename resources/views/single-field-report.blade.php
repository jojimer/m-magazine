@extends('layouts.app')

@section('content')
    @while(have_posts()) 
	  @php 
	  	the_post();
	  @endphp
        @php 
            $fr_images = App::get_field_report_field($post->ID,'images');
            $fr_views = App::get_field_report_field($post->ID,'views');
            Utility::updateViewCount($post->ID);
        @endphp

        @include('component::field-report.single',[
            "data" => $post,
            "images" => $fr_images,
            "views" => $fr_views,
            "tags" => get_object_term_cache( $post->ID, 'tags' ),
            "url" => get_permalink($post->ID),
            "author_avatar" => get_avatar_url($post->post_author),
            "author_name" => get_the_author_meta( 'display_name', $post->post_author),
            "author_bio" => get_the_author_meta( 'user_description', $post->post_author ),
        ])
    @endwhile
@endsection