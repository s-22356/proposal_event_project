@extends('layouts.public')
@section('page_title', 'Sign Up')
@section('content')

<div class="page-header">
    <div class="container">
        <div class="row align-items-center">
            <div class="col">
                <h3 class="page-title">SIGN IN</h3>
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
                                                <input type="text" class="form-control" id="loginMobileNo" placeholder="Enter Mobile Number">
                                        </div>
                                    </div>
                                    <div class="md-3">
                                        <div class="">&nbsp;</div>
                                        <button type="button" class="btn btn-custom btn-get-code">Get Secret Code</button>
                                    </div>
                                    <div class="form-group mb-3 hide otp_gen_resp">
                                        <div class="row">
                                            <div class="col-md-8">
                                                <label for="">Fullname <span class="required">*</span></label>
                                                <input type="text" class="form-control" id="fullname" name="fullname" maxlength="20" autocomplete="off" inputmode="text" title="Enter your full name" required>
                                            </div>
                                            <div class="col-md-8">
                                                <label for="security_pin">OTP <span class="required">*</span></label>
                                                <input type="text" class="form-control number" id="otp_num" name="otp_num" maxlength="6" minlength="6" autocomplete="off" inputmode="numeric" title="Enter 6 digit Security OTP" required>
                                            </div>
                                            <div class="col-md-4 text-end">
                                                <div class="">&nbsp;</div>
                                                <button type="button" class="btn btn-custom btn-verify-login-otp">Login</button>
                                            </div>
                                        </div>
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