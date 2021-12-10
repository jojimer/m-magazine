@extends('layouts.app')

@section('content')
  <div class="search-result">
    @include('partials.page-header')

    @if (!have_posts())
      <div class="alert alert-warning">
        {{ __('Sorry, no results were found.', 'sage') }}
      </div>
    @endif

    @while(have_posts()) @php the_post() @endphp
      @include('partials.content-search')
    @endwhile

    {!! get_the_posts_navigation() !!}
  </div>
@endsection
