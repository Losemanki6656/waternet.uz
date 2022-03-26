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
                    <h2>Magazin</h2>
                </div>            
                <div class="col-lg-7 col-md-4 col-sm-12 text-right">
                    <ul class="breadcrumb justify-content-end">
                        <li class="breadcrumb-item"><a href=""><i class="icon-home"></i></a></li>                            
                        <li class="breadcrumb-item active">Magazinlar</li>
                    </ul>
                </div>
            </div>
        </div>
      
        <div class="card">
            <div class="header">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addtask">
                    <i class="fa fa-plus-circle"></i> Magazin qo'shish
                </button>

                <div class="modal fade" id="addtask" tabindex="-1" role="dialog">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="title" id="defaultModalLabel"> Magazin qo'shish</h4>
                            </div>
                            <form action="{{route('add_organization')}}" method="post">
                                @csrf
                                <div class="modal-body">
                                    
                                    <div class="form-group">
                                        <label style="margin-bottom: 0">Magazin nomi:</label>
                                        <input class="form-control" type="text" name="name" placeholder="Nomi..." required>
                                    </div> 
                                    <div class="form-group">
                                        <label style="margin-bottom: 0">Rahbar FIO:</label>
                                        <input class="form-control" type="text" name="director_name" placeholder="FIO..." required>
                                    </div>
                                    <div class="form-group">
                                        <label style="margin-bottom: 0">Phone:</label>
                                        <input class="form-control phone-number" type="text" name="phone" placeholder="Tel raqami..." required>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <div class="form-group">
                                                <label style="margin-bottom: 0">Tarifni tanlang:</label>
                                                <select class="form-control" name="traffic_id" >
                                                    @foreach ($traffics as $traffic)
                                                        <option value="{{$traffic->id}}">{{$traffic->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col">
                                            <div class="form-group">
                                                <button type="button" class="btn btn-warning" onclick="setlocation(event)" id="select_location" style="margin-top: 23px">
                                                    <i class="fa fa-map-marker"></i> Lokatsiya</button>
                                            
                                                <input type="hidden" onchange="dotReplace(event)" value="0" class="form-control" id="location" name="location">
                                            </div> 
                                        </div>
                                        
                                    </div>  

                                    <div class="form-group">
                                        <label style="margin-bottom: 0">Qachongacha:</label>
                                        <input class="form-control" type="date" name="date_traffic" required>
                                    </div>

                                    <div class="form-group">
                                        <label style="margin-bottom: 0">Izoh:</label>
                                        <textarea class="form-control" type="text" name="comment" placeholder="Izoh..." required> </textarea>
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
                            <th>Nomi</th>
                            <th>Direktor</th>
                            <th>Tel</th>
                            <th>Tarif</th>
                            <th>Balans</th>
                            <th>Mijoz</th>
                            <th>SMS</th>
                            <th>Tovar</th>
                            <th>Xodim</th>
                            <th>Created</th>
                            <th>ToDate</th>
                            <th width = "130px">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach ($organizations as $organization)
                                <tr>
                                    
                                    <td>
                                        {{$organization->name}}
                                    </td>
                                    <td>
                                        {{$organization->director_name}}
                                    </td>
                                    <td>
                                        {{$organization->phone}}
                                    </td>
                                    <td class="text-center">
                                        <a href="{{route('trafficorgan',['id' => $organization->id ])}}">{{$organization->traffic->name}}</a>  
                                    </td>
                                    <td>
                                        <a href="{{route('addpriceorgan',['id' => $organization->id ])}}">{{$organization->balance}} so'm</a>
                                    </td>
                                    <td>
                                        {{$organization->clients_count}}
                                    </td>
                                    <td>
                                        {{$organization->sms_count}}
                                    </td>
                                    <td>
                                        {{$organization->products_count}}
                                    </td>
                                    <td>
                                        {{$organization->users_count}}
                                    </td>
                                    <td>
                                        {{$organization->updated_at->format('Y-m-d')}}
                                    </td>
                                    <td>
                                        {{$organization->date_traffic}}
                                    </td>
                                    <td>
                                        @if ($organization->location != '0')
                                            <a type="button" target="_blank" href="{{route('view_location',['id' => $organization->id])}}" class="btn btn-warning" >
                                                <i class="fa fa-map-marker"></i> <span></span></a> 
                                        @else
                                            <button type="button" class="btn btn-outline-warning" disabled>
                                                <i class="fa fa-map-marker"></i> <span></span></button>
                                        @endif
                                        <button type="button" class="btn btn-dark" data-toggle="modal" data-target="#edit{{$organization->id}}"><i class="fa fa-edit"></i> <span></span></button>
                                        <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#delete{{$organization->id}}"><i class="fa fa-trash-o"></i> <span></span></button>
                                    </td>
                                </tr> 
                                <div class="modal fade" id="edit{{$organization->id}}" tabindex="-1" role="dialog">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="title" id="defaultModalLabel"> Taxrirlash</h4>
                                            </div>
                                            <form action="{{route('edit_organization',['id' => $organization->id ])}}" method="post">
                                                @csrf
                                                <div class="modal-body">
                                                    
                                                    <div class="form-group">
                                                        <label style="margin-bottom: 0">Magazin nomi:</label>
                                                        <input class="form-control" type="text" name="name" value="{{$organization->name}}" required>
                                                    </div> 
                                                    <div class="form-group">
                                                        <label style="margin-bottom: 0">Rahbar FIO:</label>
                                                        <input class="form-control" type="text" name="director_name" value="{{$organization->director_name}}" required>
                                                    </div>
                                                    <div class="form-group">
                                                        <label style="margin-bottom: 0">Phone:</label>
                                                        <input class="form-control phone-number" type="text" name="phone" value="{{$organization->phone}}" required>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col">
                                                            <div class="form-group">
                                                                <label style="margin-bottom: 0">Tarifni tanlang:</label>
                                                                <select class="form-control" name="traffic_id" >
                                                                    @foreach ($traffics as $traffic)
                                                                        <option value="{{$traffic->id}}">{{$traffic->name}}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                
                                                        <div class="col">
                                                            <div class="form-group">
                                                                <button type="button" class="btn btn-warning" onclick="setlocation(event)" id="select_location" style="margin-top: 23px">
                                                                    <i class="fa fa-map-marker"></i> Lokatsiya</button>
                                                                    <input type="hidden" onchange="dotReplace(event)" value="0" class="form-control" id="location" name="location">
                                                            </div> 
                                                        </div>
                                                        
                                                    </div>  
                
                                                    <div class="form-group">
                                                        <label style="margin-bottom: 0">Qachongacha:</label>
                                                        <input class="form-control" type="date" name="date_traffic" value="{{$organization->date_traffic}}" required>
                                                    </div>
                
                                                    <div class="form-group">
                                                        <label style="margin-bottom: 0">Izoh:</label>
                                                        <textarea class="form-control" type="text" name="comment"  required> {{$organization->comment}} </textarea>
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
                                <div class="modal fade" id="delete{{$organization->id}}" tabindex="-1" role="dialog">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="title" id="defaultModalLabel"> O'chirish</h4>
                                            </div>
                                            <form action="{{route('delete_organization',['id' => $organization->id ])}}" method="post">
                                                @csrf
                                                <div class="modal-body">
                                                    
                                                    <div class="form-group">
                                                        <label style="margin-bottom: 0">{{$organization->name}} magazinni o'chirmoqchimisz ? </label>
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

@section('scripts')

<script>
     function setlocation(event){ 
      event.preventDefault(); 
      var myWindow=window.open("{{route('location')}}", 'Select Client Location', 'width=auto,height=auto')
    }

      function setlocation1(event, l1, l2){ 
            event.preventDefault(); 
            var myWindow=window.open('set_location_edit.asp?lat='+l1+'&lng='+l2+'', 'Joylashuvni tanlash', 'width=800,height=500')
        }

    function dotReplace(event){
                event.taget.value=event.target.value.replaceAll(",", ".")
            }
</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/3.3.4/jquery.inputmask.bundle.min.js"></script>  

<script>
    $(document).ready(function(){  
        $('.phone-number').inputmask('(99)9999999');  
    });
</script>

@endsection
