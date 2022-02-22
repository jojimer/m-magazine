@extends('layouts.app')

@section('content')
  @php acf_form_head(); @endphp
  <div id="primary">
		<div id="content" role="main">
				
		@php acf_form([
				'post_id' => 'new_post',
        		'new_post' => array(
            		'post_type'     => 'field-report',
            		'post_status'   => 'publish'
        			),
        	'submit_value'  => 'Add Post']); 
        @endphp

		</div><!-- #content -->
	</div><!-- #primary -->
@endsection
