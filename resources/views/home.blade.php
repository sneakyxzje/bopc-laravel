@extends('layouts.app')

@section('title', 'Home')

@section('content')
Hello world
<h2>1. Test Product + Category + Brand + Attributes</h2>
@foreach($products as $product)
<div style="margin-bottom: 20px; border: 1px solid #ccc; padding: 10px;">
    <strong>Product Name:</strong> {{ $product->name }} <br>
    <strong>Category:</strong> {{ $product->category->name }} <br>
    <strong>Brand:</strong> {{ $product->brand->name }} <br>
    <strong>Price:</strong> {{ number_format($product->price) }}đ <br>

    <strong>Product attributes:</strong>
    <ul>
        @foreach($product->attributes as $attr)
        <li>{{ $attr->name }}: {{ $attr->value }}</li>
        @endforeach
    </ul>
</div>
@endforeach

<hr>

<h2>2. Order Test</h2>
@if($firstOrder)
<p>Order Id:: #{{ $firstOrder->id }}</p>
<p>User Id:: {{ $firstOrder->user_id }}</p>
<p>Status: {{ $firstOrder->status }}</p>
<p>Product in order:</p>
<ul>
    @foreach($firstOrder->items as $item)
    <li>ID Product: {{ $item->product_id }} - Quantity: {{ $item->quantity }} - Price: {{ number_format($item->price) }}đ</li>
    @endforeach
</ul>
@else
<p>Order is null, need to seed data.</p>
@endif

@endsection