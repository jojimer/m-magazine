@extends('layouts.app')

@section('content')    
    @foreach($shop_products as $products)
        @php $product = App::get_shop_product_single_field($products->ID); @endphp
        @include('component::shop.hero',["hero" => $product['hero']])
        @include('component::shop.categories',["categories" => $product['categories']])
        @include('component::shop.products',["products" => $product['products']])
    @endforeach
    @include('component::loader')
@endsection