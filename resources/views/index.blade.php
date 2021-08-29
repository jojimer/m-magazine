@extends('layouts.app')

@section('content')
      @if (Page::slug() == 'home')
        @include('component::news.feed',["data" => $news_list[0], "thumbnail" => Page::thumbnail($news_list[0]->ID,'large')])
        @include('component::news.related', ["data" => $news_list])
        @include('component::gallery.feed')
        @include('component::shop.hero')
        @include('component::shop.gender-block')
        @include('component::field-report.feed')        
      @endif
@endsection
