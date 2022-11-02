@extends('layouts.master')
@section('content')

    @if (\Session::has('msg'))  
        @if (Session::get('msg') == 1)
        <div class="alert alert-success" id="success-alert">A simple success alert—check it out!</div>
        @endif
    @endif

    <div class="container-fluid">
        <div class="block-header">
            <div class="row">
                <div class="col-lg-5 col-md-8 col-sm-12">
                    <h2>Tovar kiritish</h2>
                </div>            
                <div class="col-lg-7 col-md-4 col-sm-12 text-right">
                    <ul class="breadcrumb justify-content-end">
                        <li class="breadcrumb-item"><a href=""><i class="icon-home"></i></a></li>                            
                        <li class="breadcrumb-item active">Tovar kiritish</li>
                    </ul>
                </div>
            </div>
        </div>
  
        <div class="">   
            <ul class="nav nav-tabs-new2">
                <li class="nav-item"><a class="nav-link  active show" style="font-weight: bold;" href="{{route('entry_products')}}"><i class="fa fa-home"></i> Tovar kiritish</a></li>
                <li class="nav-item"><a class="nav-link"  style="font-weight: bold; color: black" href="{{route('take_products')}}"><i class="fa fa-user"></i> Tovar chiqarish</a></li>
                <li class="nav-item"><a class="nav-link"  style="font-weight: bold; color: black" href="{{route('entry_container')}}"><i class="fa fa-home"></i> Idishlarni kiritish</a></li>
                <li class="nav-item"><a class="nav-link" style="font-weight: bold; color: black" href="{{route('take_container')}}"><i class="fa fa-user"></i> Tara chiqarish </a></li>
            </ul>
        <div class="tab-content col-8">  
            <div class="tab-pane show active" id="entryproducts">
                <div class="card">
                    <div class="header">
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#enprod">
                            <i class="fa fa-plus-circle"></i> Tovar kiritish
                        </button>
        
                        <div class="modal fade" id="enprod" tabindex="-1" role="dialog">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="title" id="defaultModalLabel">Tovar chiqarish</h4>
                                    </div>
                                    <form action="{{route('add_entry_product')}}" method="post">
                                        @csrf
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <h6><label>Tovar nomi:</label></h6>
                                                <select class="form-control" name="product_id" >
                                                    @foreach ($products as $product)
                                                        <option value="{{$product->id}}">{{$product->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <h6><label>Soni:</label></h6>
                                                <input class="form-control" type="number" name="product_count" placeholder="Soni..." required>
                                            </div> 
                                            <div class="form-group">
                                                <h6><label>Narxi:</label></h6>
                                                <input class="form-control" type="number" name="price" placeholder="Narxi..." required>
                                            </div> 
                                            <div class="form-group">
                                                <h6><label>Izoh:</label></h6>
                                                <input class="form-control" type="text" name="comment" placeholder="Izoh...">
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
                            <table class="table table-bordered table-sm">
                                <thead>
                                <tr class="text-800 bg-200">
                                    <th width = "80">#</th>
                                    <th>Tovar nomi</th>
                                    <th>Miqdori</th>
                                    <th>Narxi</th>
                                    <th>Qachon</th>
                                    <th>Izoh</th>
                                    <th>FIO</th>
                                    <th width = "80px" style="min-width: 80px">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach ($entryproduct as $enproduct)
                                        <tr>
                                            <td>{{(($entryproduct->currentPage() * 10) - 10) + $loop->index + 1}}</td>  
                                            <td>
                                                {{$enproduct->product->name}}
                                            </td>
                                            <td>
                                                {{$enproduct->product_count}}
                                            </td>
                                            <td>
                                                {{$enproduct->price}}
                                            </td>                            
                                            <td>{{$enproduct->created_at}}</td>
                                            <td>{{$enproduct->comment}}</td>
                                            <td>{{$enproduct->user->name}}</td>
                                            
                                            <td>
                                                <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#edit{{$enproduct->id}}">
                                                    <i class="fa fa-edit"></i> <span></span></button>
                                                <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#delete{{$enproduct->id}}">
                                                    <i class="fa fa-trash-o"></i> <span></span></button>
                                            </td>
                                        </tr> 
                                        <div class="modal fade" id="edit{{$enproduct->id}}" tabindex="-1" role="dialog">
                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4 class="title" id="defaultModalLabel">Taxrirlash</h4>
                                                    </div>
                                                    <form action="{{route('edit_entry_product',['id' => $enproduct->id])}}" method="post">
                                                        @csrf
                                                        <div class="modal-body">
                                                            <div class="form-group">
                                                                <h6><label>Tovar nomi:</label></h6>
                                                                <select class="form-control" name="product_id" >
                                                                    @foreach ($products as $product)
                                                                        @if ($enproduct->product_id == $product->id)
                                                                            <option value="{{$product->id}}" selected>{{$product->name}}</option> 
                                                                        @else
                                                                            <option value="{{$product->id}}">{{$product->name}}</option>  
                                                                        @endif
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div class="form-group">
                                                                <h6><label>Soni:</label></h6>
                                                                <input class="form-control" type="number" name="product_count" value="{{$enproduct->product_count}}" required>
                                                            </div> 
                                                            <div class="form-group">
                                                                <h6><label>Narxi:</label></h6>
                                                                <input class="form-control" type="number" name="price" value="{{$enproduct->price}}" required>
                                                            </div> 
                                                            <div class="form-group">
                                                                <h6><label>Izoh:</label></h6>
                                                                <input class="form-control" type="text" name="comment" value="{{$enproduct->comment}}" placeholder="Izoh...">
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
                                        <div class="modal fade" id="delete{{$enproduct->id}}" tabindex="-1" role="dialog">
                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4 class="title" id="defaultModalLabel">Taxrirlash</h4>
                                                    </div>
                                                    <form action="{{route('delete_entry_product',['id' => $enproduct->id])}}" method="post">
                                                        @csrf
                                                        <div class="modal-body">
                                                            <div class="form-group">
                                                                <h6><label>O'chirishni xoxlasysizmi ?</label></h6>
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
                        <div class="d-flex justify-content mt-3">             
                            <ul class="pagination mb-0">
                                {{ $entryproduct->withQueryString()->links() }}
                            </ul> 
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

   
    </div>
@endsection

@push('scripts')
@endpush
