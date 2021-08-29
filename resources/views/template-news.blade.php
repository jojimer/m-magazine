{{--
  Template Name: News Template
--}}

@extends('layouts.app')

@section('content')
  @foreach($news_list as $news)
    @include('component::news.feed',
    [
      "data" => $news,
      "thumbnail" => Page::get_acf_single_field($news->ID,'url_image','thumbnail'),
      "image_position" => Page::get_acf_single_field($news->ID,'image_position','thumbnail'),
      "caption" => Page::get_acf_single_field($news->ID,'caption'),
      "views" => Page::get_acf_single_field($news->ID,'views')
    ])
  @endforeach
@endsection