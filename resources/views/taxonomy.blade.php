@extends('layouts.app')

@section('content')
    {{-- Get Random Content --}}
    @php 
    	$output = '';
    	echo '<h1 class="taxonomy-term-title">#'.str_replace('-', ' ',get_query_var('term')).'</h1>';
    @endphp
    @foreach($random_content as $random)
      @php
        switch($random->post_type) {
            case 'news':
                $output .= App::get_news_template($random);
            break;
            case 'gallery':
                $output .= App::get_gallery_template($random);
            break;
            case 'shop-product':
                $output .= App::get_shop_template($random);
            break;
            case 'field-report':
                $output .= App::get_field_report_template($random);
            break;
            case 'vip-deal':
                $output .= App::get_vip_deal_template($random);
            break;
        }
      @endphp
    @endforeach
    @php echo $output; @endphp
    @include('component::loader')
@endsection
