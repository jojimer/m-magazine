@extends('layouts.app')

@section('content')
      @if (Page::slug() == 'home')
        @include('component::news.feed',[
          "data" => $news_list[0],
          "thumbnail" => Page::get_acf_single_field($news_list[0],'url_image','thumbnail'),
          "image_position" => Page::get_acf_single_field($news_list[0],'image_position','thumbnail'),
          "caption" => Page::get_acf_single_field($news_list[0],'caption'),
          "views" => Page::get_acf_single_field($news_list[0],'views')
          ])
        @include('component::news.related', ["data" => $news_list])
        @include('component::gallery.feed')
        @include('component::shop.hero')
        @include('component::shop.gender-block')
        @include('component::field-report.feed')        
      @endif
@endsection
