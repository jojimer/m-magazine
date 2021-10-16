@extends('layouts.app')

@section('content')
  @foreach($news_list as $news)
    @include('component::news.feed',
    [
      "data" => $news,
      "thumbnail" => App::get_news_single_field($news->ID,'url_image','thumbnail'),
      "image_position" => App::get_news_single_field($news->ID,'image_position','thumbnail'),
      "caption" => App::get_news_single_field($news->ID,'excerpt'),
      "views" => App::get_news_single_field($news->ID,'views'),
      "url" => get_permalink($news->ID)
    ])
  @endforeach
  @include('component::loader')
@endsection