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
      $products = App::get_shop_product_single_field($shop_products[0]->ID);
      $field_report_images = App::get_field_report_images($field_report[0]->ID);
    @endphp
    @include('component::shop.hero',["hero" => $products['hero']])
    @include('component::shop.categories',["categories" => $products['categories']])
    @include('component::shop.products',["products" => $products['products']])
    @include('component::field-report.feed',[
      "data" => $field_report[0],
      "images" => $field_report_images,
      "tags" => get_object_term_cache( $field_report[0]->ID, 'tags' )
    ])    
  @endif
@endsection
