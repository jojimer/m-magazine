@extends('layouts.app')

@section('content')
  @while(have_posts()) 
  @php 
  	the_post();
  	$thumbnail = App::get_news_single_field($post->ID,'thumbnail');
    $image_src = App::get_news_single_field($post->ID,$thumbnail);
    $image = ($thumbnail === 'url_image') ? 'url("'.$image_src.'") 1x' : Utility::getImageSrcSet($image_src);
    Utility::updateViewCount($post->ID);
  @endphp
    @include('component::news.single',[
		"data" => $post,
		"tags" => get_object_term_cache( $post->ID, 'tags' ),
		"thumbnail" => $image,
		"image_position" => App::get_news_single_field($post->id,'image_position'),
		"excerpt" => App::get_news_single_field($post->id,'excerpt',true),
		"views" => App::get_news_single_field($post->id,'views'),
		"news_url" => App::get_news_single_field($post->id,'news_url'),
		"caption" => App::get_news_single_field($post->id,'caption')
    ])
  @endwhile
@endsection