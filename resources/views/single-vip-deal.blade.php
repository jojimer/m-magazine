@extends('layouts.app')

@section('content')
  @while(have_posts()) 
  @php 
  	the_post();
    Utility::updateViewCount($post->ID);
    $vip_deal = App::get_vip_deal_field($post->ID);
  @endphp
    @include('component::vip-deals.single',[
		"data" => $post,
		"tags" => get_object_term_cache( $post->ID, 'tags' ),
		"vip_deal" => $vip_deal["vip_deal"],
    "views" => $vip_deal["views"],
		"vip_url" => get_permalink($post->ID),
    ])
  @endwhile
@endsection