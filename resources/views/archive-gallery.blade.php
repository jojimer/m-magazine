@extends('layouts.app')

@section('content')
	@foreach($galleries as $gallery)
		@php 
			echo App::get_gallery_template($gallery); 
		@endphp
	@endforeach
	@include('component::loader')
@endsection