@extends('layouts.app')

@section('content')
	<div class="row" id="top-feed">
		<div class="col-3">
			@include('component::profile-box')
		</div>
		<div class="col-9">
			Feed
		</div>
	</div>
@endsection
