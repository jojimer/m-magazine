@extends('layouts.app')

@section('content')
  @while(have_posts()) 
  @php 
  	the_post();
  @endphp
    @include('component::news.single',[
		"data" => $post,
		"tags" => get_object_term_cache( $post->ID, 'tags' ),
		"thumbnail" => App::get_acf_single_field($post->id,'url_image','thumbnail'),
		"image_position" => App::get_acf_single_field($post->id,'image_position','thumbnail'),
		"excerpt" => App::get_acf_single_field($post->id,'excerpt','',true),
		"views" => App::get_acf_single_field($post->id,'views'),
		"news_url" => App::get_acf_single_field($post->id,'news_url'),
		"caption" => App::get_acf_single_field($post->id,'caption')
    ])
  @endwhile
@endsection