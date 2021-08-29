{{--
  Template Name: News Template
--}}

@extends('layouts.app')

@section('content')
  @foreach($news_list as $news)
    @include('component::news.feed',["data" => $news,"thumbnail" => Page::thumbnail($news->ID,'large')])
  @endforeach
@endsection