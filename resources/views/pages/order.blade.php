@extends('layout.app')
@section('title', 'Orders')

@section('content')
<div class="cart-sec pt-3 pb-5 ">
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="shipping-contact">
                    <h1>{{ session('response') }}</h1>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
