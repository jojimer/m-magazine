@extends('layouts.app')

@section('content')
    @foreach($field_report as $report)
        @php 
            $fr_images = App::get_field_report_field($report->ID,'images');        
            $fr_views = App::get_field_report_field($report->ID,'views');
            $excerpt = (strlen($report->post_excerpt) > 195) ? substr($report->post_excerpt, 0, 190) . '...' : $report->post_excerpt;
        @endphp

        @include('component::field-report.feed',[
            "data" => $report,
            "images" => $fr_images,
            "views" => $fr_views,
            "tags" => get_object_term_cache( $report->ID, 'tags' ),
            "url" => get_permalink($report->ID),
            "author_avatar" => get_avatar_url($report->post_author),
            "author_name" => get_the_author_meta( 'display_name', $report->post_author ),
            "excerpt" => $excerpt,
        ])
    @endforeach
@endsection