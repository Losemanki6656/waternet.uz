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
                        <button class="btn btn-primary me-1 mb-1 mr-2" type="button" data-toggle="modal" data-target="#addphoto">
                            <span class="fa fa-plus me-1"></span> Add Photo Carts
                        </button>
                        <button class="btn btn-success me-1 mb-1" type="button" data-toggle="modal" data-target="#addphotoswiper">
                            <span class="fa fa-plus me-1"></span> Add Photo Swiper
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

            
            <div class="modal fade" id="addphotoswiper" tabindex="-1" role="dialog">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="title" id="largeModalLabel">Modal title</h4>
                        </div>
                        <form action="{{ route('client_app_swiper_add') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="">Upload Photo (Razmer: 388 - 160 )</label>
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
                <div class="col-lg-6 col-md-12">
                    <div class="row">
                        @foreach ($photos as $item)
                        <div class="col-lg-3 col-md-12">
                            <div class="card product_item">
                                <div class="body">
                                    <div class="cp_img">
                                        <img src="{{asset($item->photo)}}" alt="Product" class="img-fluid" />
                                        <div class="hover">
                                            <a href="javascript:void(0);" class="btn btn-primary" data-toggle="modal" data-target="#editphoto{{$item->id}}"><i class="icon-eye"></i> Edit</a>
                                            <a href="javascript:void(0);" class="btn btn-danger" data-toggle="modal" data-target="#deletephoto{{$item->id}}"><i class="icon-basket"></i> Delete</a>
                                        </div>
                                    </div>
                                    <div class="product_details">
                                        <br>
                                        <h5><a href="javascript:void(0);">Simple Black Clock</a></h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                            <div class="modal fade" id="editphoto{{$item->id}}" tabindex="-1" role="dialog">
                                <div class="modal-dialog modal-lg" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="title" id="largeModalLabel">Modal title</h4>
                                        </div>
                                        <form action="{{ route('client_app_carts_edit',['id' => $item->id]) }}" method="post" enctype="multipart/form-data">
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
                                                            <input type="text" name="name" class="form-control" value="{{$item->name}}">
                                                        </div>
                                                        <div class="col">
                                                            <label for="">Lg Name</label>
                                                            <input type="text" name="lg_name" class="form-control" value="{{$item->lg_name}}">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col">
                                                            <label for="">Price</label>
                                                            <input type="text" name="price" class="form-control" value="{{$item->price}}">
                                                        </div>
                                                        <div class="col">
                                                            <label for="">Phone</label>
                                                            <input class="form-control phone-number" type="text" name="phone" value="{{$item->phone}}">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="">Comment</label>
                                                    <textarea name="comment" class="form-control">{{$item->comment}}</textarea>
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
                            <div class="modal fade" id="deletephoto{{$item->id}}" tabindex="-1" role="dialog">
                                <div class="modal-dialog modal-lg" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="title" id="largeModalLabel">Modal title</h4>
                                        </div>
                                        <form action="{{ route('client_app_carts_delete',['id' => $item->id]) }}" method="post" enctype="multipart/form-data">
                                            @csrf
                                            <div class="modal-body">
                                                <div class="form-group">
                                                    <label class="text-danger fw-bold">Delete ?</label>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-primary">DELETE ITEM</button>
                                                <button type="button" class="btn btn-danger" data-dismiss="modal">CLOSE</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="row">
                @foreach ($swiperphotos as $swiperphoto)
                    <div class="col-lg-4 col-md-12">
                        <div class="card single_post">
                            <div class="body">
                                <div class="blog-top d-flex clearfix">
                                    <div class="short-name">
                                        <span class="mr-1 ml-1"> Name </span>
                                    </div>
                                    <h4 class="name">{{$swiperphoto->name}}</h4>
                                </div>
                                <h3><a href="blog-details.html">{{$swiperphoto->lg_name}}</a></h3>
                                <div class="img-post">
                                    <img class="d-block img-fluid" src="{{asset($swiperphoto->photo)}}" alt="First slide">
                                </div>
                                <p>{{$swiperphoto->comment}}</p>
                            </div>
                            <div class="footer">
                                <div class="actions">
                                    <a href="javascript:void(0);" data-toggle="modal" data-target="#editphotoswiper{{$swiperphoto->id}}" class="btn btn-primary">Edit</a>
                                    <a href="javascript:void(0);" data-toggle="modal" data-target="#deletephotoswiper{{$swiperphoto->id}}" class="btn btn-danger">Delete</a>
                                </div>
                                <ul class="stats">
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade" id="editphotoswiper{{$swiperphoto->id}}" tabindex="-1" role="dialog">
                        <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="title" id="largeModalLabel">Modal title</h4>
                                </div>
                                <form action="{{ route('client_app_swiper_edit',['id' => $swiperphoto->id]) }}" method="post" enctype="multipart/form-data">
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
                                                    <input type="text" name="name" class="form-control" value="{{$swiperphoto->name}}">
                                                </div>
                                                <div class="col">
                                                    <label for="">Lg Name</label>
                                                    <input type="text" name="lg_name" class="form-control" value="{{$swiperphoto->lg_name}}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col">
                                                    <label for="">Price</label>
                                                    <input type="text" name="price" class="form-control" value="{{$swiperphoto->price}}">
                                                </div>
                                                <div class="col">
                                                    <label for="">Phone</label>
                                                    <input class="form-control phone-number" type="text" name="phone" value="{{$swiperphoto->phone}}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="">Comment</label>
                                            <textarea name="comment" class="form-control">{{$swiperphoto->comment}}</textarea>
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
                    <div class="modal fade" id="deletephotoswiper{{$swiperphoto->id}}" tabindex="-1" role="dialog">
                        <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="title" id="largeModalLabel">Modal title</h4>
                                </div>
                                <form action="{{ route('client_app_swiper_delete',['id' => $swiperphoto->id]) }}" method="post" enctype="multipart/form-data">
                                    @csrf
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label class="text-danger fw-bold">Delete ?</label>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-primary">DELETE ITEM</button>
                                        <button type="button" class="btn btn-danger" data-dismiss="modal">CLOSE</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
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
            <script>
            @endsection
