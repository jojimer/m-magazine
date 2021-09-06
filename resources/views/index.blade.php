@extends('layouts.app')

@section('content')
      @if (App::slug() == 'home')
        @include('component::news.feed',[
          "data" => $news_list[0],
          "thumbnail" => App::get_acf_single_field($news_list[0],'url_image','thumbnail'),
          "image_position" => App::get_acf_single_field($news_list[0],'image_position','thumbnail'),
          "caption" => App::get_acf_single_field($news_list[0],'excerpt'),
          "views" => App::get_acf_single_field($news_list[0],'views'),
          "url" => get_permalink($news_list[0])
          ])
        @include('component::news.related', ["data" => $news_list])
        @include('component::gallery.feed')
        @include('component::shop.hero')
        @include('component::shop.gender-block')
        @include('component::field-report.feed')        
      @endif
@endsection
