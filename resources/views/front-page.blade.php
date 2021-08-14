@extends('layouts.app')

@section('content')
	<div class="row g-2" id="top-feed">
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
			@include('component::news.headline')
		</div>
	</div>
@endsection
