@extends('layouts.master')


@section('content')
    <link rel="stylesheet" href="/assets/vendor/dropify/css/dropify.min.css">

    <div class="container-fluid">
        <div class="block-header">
            <div class="row">
                <div class="col-lg-5 col-md-8 col-sm-12">
                    <h2>Photos</h2>
                </div>
                <div class="col-lg-7 col-md-4 col-sm-12 text-right">
                    <ul class="breadcrumb justify-content-end">
                        <button class="btn btn-primary me-1 mb-1" type="button" data-toggle="modal" data-target="#addphoto">
                            <span class="fa fa-plus me-1"></span> Add Photo
                        </button>
                    </ul>
                </div>
            </div>

            <div class="modal fade" id="addphoto" tabindex="-1" role="dialog">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="title" id="largeModalLabel">Modal title</h4>
                        </div>
                        <form action="{{ route('client_app_carts_add') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="">Upload Photo (Razmer: 127 - 98 )</label>
                                    <input type="file" name="photo" class="dropify" required>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col">
                                            <label for="">Name</label>
                                            <input type="text" name="name" class="form-control">
                                        </div>
                                        <div class="col">
                                            <label for="">Lg Name</label>
                                            <input type="text" name="lg_name" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col">
                                            <label for="">Price</label>
                                            <input type="text" name="price" class="form-control">
                                        </div>
                                        <div class="col">
                                            <label for="">Phone</label>
                                            <input class="form-control phone-number" type="text" name="phone">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="">Comment</label>
                                    <textarea name="comment" id="" class="form-control"></textarea>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary">SAVE CHANGES</button>
                                <button type="button" class="btn btn-danger" data-dismiss="modal">CLOSE</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="row clearfix">
                @foreach ($photos as $item)
                    <div class="col-lg-3 col-md-4 col-sm-12">
                        <div class="card">
                            <div class="file">
                                <a href="javascript:void(0);">
                                    <div class="image">
                                        <img src="{{asset($item->photo)}}" alt="img" class="img-fluid">
                                    </div>
                                </a>
                                <a href="" data-toggle="modal" data-target="#largeModal">
                                    <div class="file-name">
                                        <p class="m-b-5 text-muted">{{$item->name}}</p>
                                        <small>Size: 2MB <span class="date text-muted">{{$item->created_at->format('Y-m-d')}}</span></small>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="modal fade" id="largeModal" tabindex="-1" role="dialog">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="title" id="largeModalLabel">Modal title</h4>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <input type="file" class="dropify">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary">SAVE CHANGES</button>
                            <button type="button" class="btn btn-danger" data-dismiss="modal">CLOSE</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection

    @section('scripts')
        <script src="/assets/vendor/dropify/js/dropify.min.js"></script>
        <script src="/assets/js/pages/forms/dropify.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/3.3.4/jquery.inputmask.bundle.min.js"></script>

        <script>
            $(document).ready(function() {
                $('.phone-number').inputmask('(99)9999999');
            }); <
            script >
            @endsection
