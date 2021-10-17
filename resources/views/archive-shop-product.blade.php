@extends('layouts.app')

@section('content')    
    @foreach($shop_products as $products)
        @php $product = App::get_shop_product_single_field($products->ID); @endphp
        @if(!empty($product['hero']))
            @include('component::shop.hero',["hero" => $product['hero']])
        @endif
        @if(!empty($product['categories']))
            @include('component::shop.categories',["categories" => $product['categories']])
        @endif
        @if(!empty($product['products']))
            @include('component::shop.products',["products" => $product['products']])
        @endif
    @endforeach
    @include('component::loader')
@endsection