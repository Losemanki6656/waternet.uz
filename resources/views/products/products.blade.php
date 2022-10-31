@extends('layouts.master')
@section('content')

    @if (\Session::has('msg'))
        @if (Session::get('msg') == 'error')
            <div class="alert alert-danger" id="success-alert">Tovarlar bo'yicha ajratilgan tarif limiti tugadi!</div>
        @endif
    @endif

    <div class="container-fluid">
        <div class="block-header">
            <div class="row">
                <div class="col-lg-5 col-md-8 col-sm-12">
                    <h2>Tovarlar</h2>
                </div>
                <div class="col-lg-7 col-md-4 col-sm-12 text-right">
                    <ul class="breadcrumb justify-content-end">
                        <li class="breadcrumb-item"><a href=""><i class="icon-home"></i></a></li>
                        <li class="breadcrumb-item active">Tovarlar</li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="header mb-3">
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addtask">
                <i class="fa fa-plus-circle"></i> Tovar qo'shish
            </button>

            <div class="modal fade" id="addtask" tabindex="-1" role="dialog">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="title" id="defaultModalLabel">Tovar qo'shish</h4>
                        </div>
                        <form action="{{ route('add_product') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="modal-body">
                                <div class="form-group">
                                    <h6><label>Tovar nomi:</label></h6>
                                    <input class="form-control" type="text" name="name" placeholder="Tovar nomi..."
                                        required>
                                </div>
                                <div class="form-group">
                                    <h6><label>Maxsulot turi:</label></h6>
                                    <select class="form-control" name="idish_status">
                                        <option value="0">Idish qaytadi</option>
                                        <option value="1">Idish qaytmaydi</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <h6><label>Narxi:</label></h6>
                                    <input class="form-control" type="text" name="sena" placeholder="Narxi..."
                                        required>
                                </div>
                                <input class="form-control" type="hidden" name="count" value="0"
                                    placeholder="Soni..." required>
                                <div class="form-group">
                                    <h6><label>Rasmi:</label></h6>
                                    <input class="form-control" type="file" name="photo">
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-dismiss="modal"> Chiqish</button>
                                <button class="btn btn-primary" type="submit"> Saqlash</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="body">
            <div class="row">

                @foreach ($products as $product)
                    <div class="col-3">
                        <div class="card member-card">
                            <div class="header bg-info mb-3">
                                <h4 class="m-t-10 text-light" style="font-weight: bold">{{ $product->name }}</h4>
                                <small class="m-t-10 text-light" style="font-weight: bold">Tovar nomi</small>
                            </div>
                            <div class="member-img">
                                <button type="button" class="btn btn-dark" data-toggle="modal"
                                    data-target="#edit{{ $product->id }}"><i class="fa fa-edit"></i>
                                    <span></span></button>
                                <a><img src="https://play-lh.googleusercontent.com/US4iPJdhy3J3RdfCn0Sj3JYRHqYRYBxbtPzBZP2wODEnnNOlJhBhpyBpi7AcvDO25ZQV"
                                        class="rounded-circle" alt="profile-image"></a>
                                <button type="button" class="btn btn-danger" disabled><i class="fa fa-trash-o"></i>
                                    <span></span></button>
                            </div>
                            <div class="body">
                                <hr>
                                <div class="row">
                                    <div class="col-4">
                                        <h5 style="font-weight: bold">{{ $product->price }}</h5>
                                        <small style="font-weight: bold">Narxi</small>
                                    </div>
                                    <div class="col-4">
                                        <h5 style="font-weight: bold">{{ $product->product_count }}</h5>
                                        <small style="font-weight: bold">Soni</small>
                                    </div>
                                    <div class="col-4">
                                        <h5 style="font-weight: bold">{{ $product->container }}</h5>
                                        <small style="font-weight: bold">Bo'sh idish</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal fade" id="edit{{ $product->id }}" tabindex="-1" role="dialog">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="title" id="defaultModalLabel">Taxrirlash</h4>
                                </div>
                                <form action="{{ route('edit_product', ['id' => $product->id]) }}" method="post"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <h6><label>Tovar nomi:</label></h6>
                                            <input class="form-control" type="text" name="name"
                                                value="{{ $product->name }}" required>
                                        </div>
                                        <div class="form-group">
                                            <h6><label>Narxi:</label></h6>
                                            <input class="form-control" type="number" name="price"
                                                value="{{ $product->price }}" required>
                                        </div>
                                        <div class="form-group">
                                            <h6><label>Rasmi:</label></h6>
                                            <input class="form-control" type="file" name="photo">
                                        </div>
                                        <div class="form-group">
                                            <h6><label>Maxsulot turi:</label></h6>
                                            <select class="form-control" name="container_status">
                                                <option value="0">Idish qaytadi</option>
                                                <option value="1">Idish qaytmaydi</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-danger" data-dismiss="modal">
                                            Chiqish</button>
                                        <button class="btn btn-primary" type="submit"> Saqlash</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade" id="delete{{ $product->id }}" tabindex="-1" role="dialog">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="title" id="defaultModalLabel">O'chirish</h4>
                                </div>
                                <form action="{{ route('delete_product', ['id' => $product->id]) }}" method="post">
                                    @csrf
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <h6><label>{{ $product->name }} ni o'chirishni xoxlaysizmi
                                                    ?</label></h6>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">
                                            Chiqish</button>
                                        <button class="btn btn-danger" type="submit"> Xa, O'chirish</button>
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

@push('scripts')
@endpush
