@extends('layouts.app')

@section('content')    
    @foreach($shop_products as $products)
        @php
            echo App::get_shop_template($products);
        @endphp
    @endforeach
    @include('component::loader')
@endsection