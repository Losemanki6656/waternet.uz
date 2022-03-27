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
      
        <div class="card">
            <div class="header">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addtask">
                    <i class="fa fa-plus-circle"></i> Tovar qo'shish
                </button>

                <div class="modal fade" id="addtask" tabindex="-1" role="dialog">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="title" id="defaultModalLabel">Tovar qo'shish</h4>
                            </div>
                            <form action="{{route('add_product')}}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="modal-body">
                                    <div class="form-group">
                                        <h6><label>Tovar nomi:</label></h6>
                                        <input class="form-control" type="text" name="name" placeholder="Tovar nomi..." required>
                                    </div>  
                                    <div class="form-group">
                                        <h6><label>Maxsulot turi:</label></h6>
                                        <select class="form-control" name="idish_status" >
                                            <option value="0">Idish qaytadi</option>
                                            <option value="1">Idish qaytmaydi</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <h6><label>Narxi:</label></h6>
                                        <input class="form-control" type="text" name="sena" placeholder="Narxi..." required>
                                    </div> 
                                    <input class="form-control" type="hidden" name="count" value="0" placeholder="Soni..." required>                                      
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
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                    <tr class="text-800 bg-200">
                        <th width="70">№</th>
                        <th>Tovar nomi</th>
                        <th>Narxi</th>
                        <th>Soni</th>
                        <th>Bo'sh idish</th>
                        <th>Rasmi</th>
                        <th width = "270px" style="min-width: 270px">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach ($products as $product)
                            <tr>
                                <td>{{$loop->index + 1 }}</td>
                                <td>{{$product->name}}</td>
                                <td>
                                    {{$product->price}}
                                </td>
                                <td>
                                    {{$product->product_count}}
                                </td>
                                <td>
                                    {{$product->container}}
                                </td>
                                <td>
                                    <img src="{{asset($product->photo)}}" class="round" alt="avatar" height="40" width="40">
                                </td>
                                <td>
                                    <button type="button" class="btn btn-dark" data-toggle="modal" data-target="#edit{{$product->id}}"><i class="fa fa-edit"></i> <span></span></button>
                                    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#delete{{$product->id}}"><i class="fa fa-trash-o"></i> <span></span></button>
                                </td>
                            </tr> 
                            <div class="modal fade" id="edit{{$product->id}}" tabindex="-1" role="dialog">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="title" id="defaultModalLabel">Taxrirlash</h4>
                                        </div>
                                        <form action="{{route('edit_product',['id' => $product->id])}}" method="post" enctype="multipart/form-data">
                                            @csrf
                                            <div class="modal-body">  
                                                <div class="form-group">
                                                    <h6><label>Tovar nomi:</label></h6>
                                                    <input class="form-control" type="text" name="name" value="{{$product->name}}" required>
                                                </div> 
                                                <div class="form-group">
                                                    <h6><label>Narxi:</label></h6>
                                                    <input class="form-control" type="number" name="price" value="{{$product->price}}" required>
                                                </div>                                         
                                                <div class="form-group">
                                                    <h6><label>Rasmi:</label></h6>
                                                    <input class="form-control" type="file" name="photo">
                                                </div>      
                                                <div class="form-group">
                                                    <h6><label>Maxsulot turi:</label></h6>
                                                    <select class="form-control" name="container_status" >
                                                        <option value="0">Idish qaytadi</option>
                                                        <option value="1">Idish qaytmaydi</option>
                                                    </select>
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
                            <div class="modal fade" id="delete{{$product->id}}" tabindex="-1" role="dialog">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="title" id="defaultModalLabel">O'chirish</h4>
                                        </div>
                                        <form action="{{route('delete_product',['id' => $product->id])}}" method="post">
                                            @csrf
                                            <div class="modal-body">  
                                                <div class="form-group">
                                                    <h6><label>{{$product->name}} ni o'chirishni xoxlaysizmi ?</label></h6>
                                                </div>   
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal"> Chiqish</button>
                                                <button class="btn btn-danger" type="submit"> Xa, O'chirish</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div> 

                        @endforeach         
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    </div>
@endsection

@push('scripts')
@endpush
