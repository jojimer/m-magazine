@extends('layouts.app')

@section('content')
    @foreach($news_list as $news)
        @php
            echo App::get_news_template($news);
        @endphp
    @endforeach
    @include('component::loader')
@endsection