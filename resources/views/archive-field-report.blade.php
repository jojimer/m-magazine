@extends('layouts.app')

@section('content')
    @foreach($field_report as $report)
        @php 
            echo App::get_field_report_template($report);
        @endphp
    @endforeach
    @include('component::loader')
@endsection