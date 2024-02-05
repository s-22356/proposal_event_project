@extends('layouts.public')
@section('page_title', 'First Proposal')
@section('content')
<div class="page-header">
    <div class="container">
        <div class="row align-items-top">
            <div class="col-md-12">
                <div class="col-md-12 text-end">
                    @if(Cookie::has('Profile_name'))
                    <small>
                        <h6 class="m-0 welcome-message">welcome <br/><span class="profile_name">{{  Cookie::get('Profile_name') }}</span></h6>
                    </small>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<div>
    <h1 class="wixui-rich-text__text">
        Make your <br>Proposals<br> Unforgettable<br>
        <button type="button" class="btn btn-secondary btn-lg">Find Proposals Categories</button>
    </h1>
</div>
@stop