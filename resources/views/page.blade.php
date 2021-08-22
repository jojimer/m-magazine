@extends('layouts.app')

@section('content')
  <div class="row g-2 mt-5" id="top-feed">
    <div class="col-3">
    <div class="blue-box-component">
      @include('component::profile-box')
        @divider('pt-3 pb-4')
      @include('component::filter-box')
        @divider('pt-2 pb-4')
      @include('component::chatroom-box')
        @divider('pt-2 pb-3')
    </div>
    </div>
    <div class="col-9">
      @if (Page::slug() == 'home')
        @include('component::news.feed')
        @include('component::gallery.feed')
        @include('component::shop.hero')
        @include('component::shop.gender-block')
        @include('component::field-report.feed')
      @elseif (Page::slug() == 'news')
        @include('component::news.feed')
      @elseif (Page::slug() == 'gallery')
        @include('component::gallery.feed')
      @elseif (Page::slug() == 'shop')
        @include('component::shop.hero')
        @include('component::shop.gender-block')
      @elseif (Page::slug() == 'field-report')
        @include('component::field-report.feed')
      @endif


    </div>
  </div>
@endsection
