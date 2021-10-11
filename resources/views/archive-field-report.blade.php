@extends('layouts.app')

@section('content')
    @foreach($field_report as $report)
        @php 
            $fr_images = App::get_field_report_images($report->ID);
        @endphp

        @include('component::field-report.feed',[
            "data" => $report,
            "images" => $fr_images,
            "tags" => get_object_term_cache( $report->ID, 'tags' )
        ])
    @endforeach
@endsection