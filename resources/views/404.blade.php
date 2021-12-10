@extends('layouts.app')

@section('content')
  @if (!have_posts())
    <div class="page-not-found">
      <h1 class="four-zero-four">404</h1>
      <div class="alert alert-warning text-center h3">
        {{ __('Sorry, but the page you were trying to view does not exist.', 'sage') }}
      </div>
    </div>
  @endif
@endsection
