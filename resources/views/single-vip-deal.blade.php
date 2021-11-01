@extends('layouts.app')

@section('content')
  @while(have_posts()) 
  @php 
  	the_post();
  @endphp
    @include('component::vip-deals.single',[
		"data" => $post,
		"tags" => get_object_term_cache( $post->ID, 'tags' ),
		"vip_deal" => App::get_vip_deal_field($post->ID),
		"vip_url" => get_permalink($post->ID),
    ])
  @endwhile
@endsection