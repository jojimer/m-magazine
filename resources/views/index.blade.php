@extends('layouts.app')

@section('content')
  @if (App::slug() == 'home')
    @include('component::news.feed',[
      "data" => $news_list[0],
      "thumbnail" => App::get_news_single_field($news_list[0],'url_image','thumbnail'),
      "image_position" => App::get_news_single_field($news_list[0],'image_position','thumbnail'),
      "caption" => App::get_news_single_field($news_list[0],'excerpt'),
      "views" => App::get_news_single_field($news_list[0],'views'),
      "url" => get_permalink($news_list[0])
      ])
    @include('component::news.related', ["data" => $news_list])
    @include('component::gallery.hero', [
      "data" => $galleries[0],
      "hero" => App::get_gallery_single_field($galleries[0]->ID,"hero"),
      "url" => get_permalink($galleries[0]->ID)
    ])
    @include('component::gallery.preview',[
      "images" => App::get_gallery_single_field($galleries[0]->ID,"gallery_content",true),
      "preview_count" => App::get_gallery_single_field($galleries[0]->ID,"preview_count"),
      "year" => get_object_term_cache( $galleries[0]->ID, 'year' ),
      "month" => get_object_term_cache( $galleries[0]->ID, 'month' ),
      "url" => get_permalink($galleries[0]->ID)
    ])
    @php 
      // Product posts
      $products = App::get_shop_product_single_field($shop_products[0]->ID);
    @endphp

    {{-- Get Product Components --}}
    @if(!empty($products['hero']))
      @include('component::shop.hero',["hero" => $products['hero']])
    @endif
    @if(!empty($products['categories']))
      @include('component::shop.categories',["categories" => $products['categories']])
    @endif
    @if(!empty($products['products']))
      @include('component::shop.products',["products" => $products['products']])
    @endif

    @php
      // VIP Deals posts
      $deal_ID = $vip_deals[0]->ID;
      $vip_deal = App::get_vip_deal_field($deal_ID);
    @endphp

    {{-- Get VIP Deals Component --}}
    @if(!empty($vip_deal))
      @include('component::vip-deals.feed',[
        "deal" => $vip_deal,
        "tags" => get_object_term_cache( $deal_ID, 'tags' ),
        "url" => get_permalink($deal_ID)
      ])
    @endif

    @php
      // Field Report posts
      $field_report_images = App::get_field_report_field($field_report[0]->ID,'images');
      $fr_views = App::get_field_report_field($field_report[0]->ID,'views');
      $fr_excerpt = (strlen($field_report[0]->post_excerpt) > 195) ? substr($field_report[0]->post_excerpt, 0, 190) . '...' : $field_report[0]->post_excerpt;
    @endphp

    {{-- Get Field Report Components --}}
    @if(!empty($field_report[0]))
      @include('component::field-report.feed',[
        "data" => $field_report[0],
        "images" => $field_report_images,
        "tags" => get_object_term_cache( $field_report[0]->ID, 'tags' ),
        "views" => $fr_views,
        "url" => get_permalink($field_report[0]->ID),
        "author_avatar" => get_avatar_url($field_report[0]->post_author),
        "author_name" => get_the_author_meta( 'display_name', $field_report[0]->post_author ),
        "excerpt" => $fr_excerpt,
      ])
    @endif
  @endif
@endsection
