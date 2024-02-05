@extends('layouts.public')
@section('page_title', 'Sign Up')
@section('content')

<div class="page-header">
    <div class="container">
        <div class="row align-items-center">
            <div class="col">
                <h3 class="page-title">SIGN UP</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item">&nbsp;</li><li>&nbsp;</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="page-wrapper">
    <div class="content container">
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                    <div class="form-group mb-3">
                                <div class="row">
                                    <div class="col-md-8">
                                        <label for="">Mobile Number<span class="required">*</span></label>
                                        <div class="mb-3 input-group">
                                            <div class="input-group-text">+91</div>
                                                <input type="text" class="form-control" id="mobileNo" placeholder="Enter Mobile Number">
                                        </div>
                                    </div>
                                    <div class="md-3">
                                        <div class="">&nbsp;</div>
                                        <button type="button" class="btn btn-custom btn-get-register">Register</button>
                                    </div>
                                    
                                </div>
                            </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@stop