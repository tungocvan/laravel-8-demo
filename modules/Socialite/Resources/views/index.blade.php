@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Đăng nhập tài khoản</div>

                <div class="card-body">
                    <div class="row mb-0">                          
                        <div class="col-md-8 offset-md-4 mt-5">
                            <a href="{{route('facebook')}}" class="btn btn-primary mr-5">Login With Facebook</a>
                            <a href="{{route('google')}}" class="btn btn-primary">Login With Google</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
