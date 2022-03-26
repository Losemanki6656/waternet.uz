@extends('layouts.master')
@section('content')

    @if (\Session::has('msg'))  
        @if (Session::get('msg') == 1)
        <div class="alert alert-success" id="success-alert">A simple success alert—check it out!</div>
        @endif
    @endif

    <div class="container-fluid">
        <div class="card product_item">
            <div class="body">
                <div class="cp_img">
                    <img src="../assets/images/ecommerce/1.png" alt="Product" class="img-fluid" />
                    <div class="hover">
                        <a href="javascript:void(0);" class="btn btn-primary"><i class="icon-eye"></i></a>
                        <a href="javascript:void(0);" class="btn btn-primary"><i class="icon-basket"></i></a>
                    </div>
                </div>
                <div class="product_details">
                    <h5><a href="javascript:void(0);">Simple Black Clock</a></h5>
                    <ul class="product_price list-unstyled">
                        <li class="old_price">$16.00</li>
                        <li class="new_price">$13.00</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
@endpush
