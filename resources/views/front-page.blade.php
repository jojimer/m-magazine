@extends('layouts.app')

@section('content')
	<div class="row" id="top-feed">
		<div class="col-3">
		<div class="blue-box-component">
			@include('component::profile-box')
				@divider('pt-3 pb-4')
			@include('component::filter-box')
				@divider('pt-2 pb-4')
		</div>
		</div>
		<div class="col-9">
			Feed
		</div>
	</div>
@endsection
