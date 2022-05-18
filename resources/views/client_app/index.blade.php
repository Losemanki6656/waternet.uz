@extends('layouts.master')


@section('content')

<link rel="stylesheet" href="../assets/vendor/dropify/css/dropify.min.css">

<div class="container-fluid">
    <div class="block-header">
        <div class="row">
            <div class="col-lg-5 col-md-8 col-sm-12">
                <h2>Tovarlar</h2>
            </div>            
            <div class="col-lg-7 col-md-4 col-sm-12 text-right">
                <ul class="breadcrumb justify-content-end">
                    <a href="{{ route('users_create') }}" class="btn btn-primary me-1 mb-1" 
                    type="button" data-toggle="modal" data-target="#addphoto">
                        <span class="fa fa-plus me-1"></span> Add Photo
                    </a>
                </ul>
            </div>
        </div>

        <div class="modal fade" id="addphoto" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="title" id="largeModalLabel">Modal title</h4>
                    </div>
                    <div class="modal-body"> 
                        <div class="form-group">
                            <label for="">Rasmni yuklang</label>
                            <input type="file" name="photo" class="dropify">
                        </div>
                        <div class="form-group">
                            <label for="">Rasmni yuklang</label>
                            <input type="text" name="name" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="">Rasmni yuklang</label>
                            <input type="text" name="nameLg" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="">Rasmni yuklang</label>
                            <input type="text" name="comment" class="form-control">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary">SAVE CHANGES</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">CLOSE</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="row clearfix">
            <div class="col-lg-3 col-md-4 col-sm-12">
                <div class="card">
                    <div class="file">
                        <a href="javascript:void(0);" >
                            <div class="image">
                                <img src="../assets/images/image-gallery/5.jpg" alt="img" class="img-fluid">
                            </div>
                        </a>
                        <a href="" data-toggle="modal" data-target="#largeModal">
                            <div class="file-name">
                                <p class="m-b-5 text-muted">img21545ds.jpg</p>
                                <small>Size: 2MB <span class="date text-muted">Dec 11, 2017</span></small>
                            </div>
                        </a>
                    </div>
                </div>
            </div> 
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
@endsection