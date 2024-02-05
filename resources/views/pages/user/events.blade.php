@extends('layouts.public')
@section('page_title', 'Propose Events Packages')
@section('content')


    <div class="container mt-5">
    <h1 class="page-title mb-4">Proposal Event Packages</h1>
    @if(Session::has('success'))
			<div class="alert alert-success" id="successAlert">
				{{ Session::get('success') }}
				@php
					Session::forget('success')
				@endphp
			</div>
		@endif
    <div class="row">
      <div class="col-md-4">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Classic Package</h5>
            <ul class="card-text">
              <li>Event coordination and planning</li>
              <li>Venue selection assistance</li>
              <li>Basic decoration services</li>
            </ul>
            <p class="card-text">Price: <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-currency-rupee" viewBox="0 0 16 16">
                <path d="M4 3.06h2.726c1.22 0 2.12.575 2.325 1.724H4v1.051h5.051C8.855 7.001 8 7.558 6.788 7.558H4v1.317L8.437 14h2.11L6.095 8.884h.855c2.316-.018 3.465-1.476 3.688-3.049H12V4.784h-1.345c-.08-.778-.357-1.335-.793-1.732H12V2H4z"/>
                </svg>3000
            </p>
            <a href="{{ route('stripe.checkout',['price'  =>  3000,'product'  =>  'classic','package_id'  =>  '1']) }}" class="btn btn-primary">Select Package</a>
          </div>
        </div>
      </div>

      <div class="col-md-4">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Premium Package</h5>
            <ul class="card-text">
              <li>Comprehensive event coordination and planning</li>
              <li>Venue selection and booking</li>
              <li>Enhanced decoration services</li>
            </ul>
            <p class="card-text">Price: <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-currency-rupee" viewBox="0 0 16 16">
                    <path d="M4 3.06h2.726c1.22 0 2.12.575 2.325 1.724H4v1.051h5.051C8.855 7.001 8 7.558 6.788 7.558H4v1.317L8.437 14h2.11L6.095 8.884h.855c2.316-.018 3.465-1.476 3.688-3.049H12V4.784h-1.345c-.08-.778-.357-1.335-.793-1.732H12V2H4z"/>
                </svg>4500
            </p>
            <a href="{{ route('stripe.checkout',['price'  =>  4500,'product'  =>  'premium','package_id'  =>  '2']) }}" class="btn btn-primary">Select Package</a>
          </div>
        </div>
      </div>

      <div class="col-md-4">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Premium Gold Package</h5>
            <ul class="card-text">
              <li>Full-service event coordination and planning</li>
              <li>Premium venue selection and booking</li>
              <li>Luxurious decoration and theme customization</li>
            </ul>
            <p class="card-text">Price: <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-currency-rupee" viewBox="0 0 16 16">
                    <path d="M4 3.06h2.726c1.22 0 2.12.575 2.325 1.724H4v1.051h5.051C8.855 7.001 8 7.558 6.788 7.558H4v1.317L8.437 14h2.11L6.095 8.884h.855c2.316-.018 3.465-1.476 3.688-3.049H12V4.784h-1.345c-.08-.778-.357-1.335-.793-1.732H12V2H4z"/>
                </svg>6000
            </p>
            <a href="{{ route('stripe.checkout',['price'  =>  6000,'product'  =>  'premium gold','package_id'  =>  '3']) }}" class="btn btn-primary">Select Package</a>
          </div>
        </div>
      </div>
    </div>
  </div>
  
@stop