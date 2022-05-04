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
                <div class="col-lg-10 col-md-8 col-sm-12">
                    <form action="{{route('active_traffics')}}" method="post">
                        @csrf
                        <button type="button" class="btn btn-info" data-toggle="modal" data-target="#addtask">
                            <i class="fa fa-plus-circle"></i> Tarif qo'shish
                        </button>

                        <input type="text" name="active_traffics" id="active_traffics_a">
                        <button type="submit" class="btn btn-success">
                            <i class="fa fa-check"></i> Submit Active
                        </button>          
                    </form>
                    <div class="modal fade" id="addtask" tabindex="-1" role="dialog">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="title" id="defaultModalLabel">Tarif yaratish</h4>
                                </div>
                                <form action="{{route('add_traffic')}}" method="post">
                                    @csrf
                                    <div class="modal-body">
                                        
                                        <div class="form-group">
                                            <label style="margin-bottom: 0">Tarif nomi:</label>
                                            <input class="form-control" type="text" name="name" placeholder="Nomi..." required>
                                        </div> 
                                        <div class="form-group">
                                            <label style="margin-bottom: 0">Anotatsiya:</label>
                                            <textarea class="form-control" type="text" name="annotation" placeholder="Annotatsiya..." required></textarea>
                                        </div>
                                        <div class="form-group">
                                            <label style="margin-bottom: 0">Tarif narxi:</label>
                                            <input class="form-control" type="number" name="price" value="0" placeholder="Tarif narxi..." required>
                                        </div>
                                        <div class="row">
                                            <div class="col">
                                                <div class="form-group">
                                                    <label style="margin-bottom: 0">Mijoz soni:</label>
                                                    <input class="form-control" type="number" name="clients_count"  value="0" placeholder="Mijozlar soni..." required>
                                                </div> 
                                            </div>
                                            <div class="col">
                                                <div class="form-group">
                                                    <label style="margin-bottom: 0">Sms soni:</label>
                                                    <input class="form-control" type="number" name="sms_count"  value="0" placeholder="Sms soni..." required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col">
                                                <div class="form-group">
                                                    <label style="margin-bottom: 0">Tovar soni:</label>
                                                    <input class="form-control" type="number" name="products_count"  value="0" placeholder="Tovarlar soni..." required>
                                                </div> 
                                            </div>
                                            <div class="col">
                                                <div class="form-group">
                                                    <label style="margin-bottom: 0">Ishchilar soni:</label>
                                                    <input class="form-control" type="number" name="users_count"  value="0" placeholder="Ishchilar soni..." required>
                                                </div> 
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label style="margin-bottom: 0">Tarif turi:</label>
                                            <select class="form-control" name="status" data-placeholder="Tarif turi" required>
                                                <option value="0">Asosiy</option>
                                                <option value="1">Qo'shimcha</option>
                                            </select>
                                        </div>     
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col">
                                                    <label style="margin-bottom: 0">Asosiy dizayni:</label>
                                                    <select class="form-control" name="style1">
                                                        <option value="pricing body start-grp">Start</option>
                                                        <option value="pricing body good-grp">Good</option>
                                                        <option value="pricing body ultimna-grp">Ultima</option>
                                                        <option value="pricing body vip-grp">Vip</option>
                                                    </select>
                                                </div>
                                                <div class="col">
                                                    <label style="margin-bottom: 0">Qo'shimcha dizayni:</label>
                                                    <select class="form-control" name="style2" >
                                                        <option value="pricing-plan personal">Personal</option>
                                                        <option value="pricing-plan free">Free</option>
                                                        <option value="pricing-plan performance">Performance</option>
                                                        <option value="pricing-plan business">Business</option>
                                                    </select>
                                                </div>
                                            </div>
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
            </div>
        </div>
        <div class="row">
            <div class="col-lg-10 col-md-8 col-sm-12">
                <h5 class="text-center">  Asosiy tariflar </h5>
            </div>   
        </div>
        
            <div class="row clearfix">
                @foreach ($traffics as $traffic)
                    @if ($traffic->status == 0)
                        <div class="col-lg-3 cool-md-6 col-sm-12">
                            <div class="card">
                                <ul class="{{$traffic->style1}}">
                                    <li><h4>{{$traffic->name}}</h4></li>
                                    <li>
                                        <h3>{{$traffic->price}} so'm</h3>
                                        <span>1 oyga</span>
                                    </li>
                                    <li> {{$traffic->annotation}}</li>
                                    <li>Klient: {{$traffic->clients_count}} ta</li>
                                    <li>Sms: {{$traffic->sms_count}} ta</li>
                                    <li>Tovar: {{$traffic->products_count}} ta</li>
                                    <li>Xodim: {{$traffic->users_count}} ta</li>
                                    <label class="fancy-checkbox">
                                        <input type="checkbox" id="tr_check{{$traffic->id}}" onclick="check({{$traffic->id}})"
                                         @if ($q[$traffic->id] == true)
                                            checked
                                         @endif>
                                        <span>Active</span>
                                    </label>
                                    <button class="btn btn-dark" data-toggle="modal" data-target="#edit{{$traffic->id}}"> 
                                        <i class="fa fa-edit"></i> <span></span></button>
                                    <button class="btn btn-danger"data-toggle="modal" data-target="#delete{{$traffic->id}}"> 
                                        <i class="fa fa-trash-o"></i> <span></span></button>
                                </ul>
                            </div>
                        </div>
                    @endif
                    <div class="modal fade" id="edit{{$traffic->id}}" tabindex="-1" role="dialog">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="title" id="defaultModalLabel">Taxrirlash</h4>
                                </div>
                                <form action="{{route('edit_traffic',['id' => $traffic->id])}}" method="post">
                                    @csrf
                                    <div class="modal-body">
                                        
                                        <div class="form-group">
                                            <label style="margin-bottom: 0">Tarif nomi:</label>
                                            <input class="form-control" type="text" name="name" value="{{$traffic->name}}" required>
                                        </div> 
                                        <div class="form-group">
                                            <label style="margin-bottom: 0">Anotatsiya:</label>
                                            <textarea class="form-control" type="text" name="annotation" required>{{$traffic->annotation}}</textarea>
                                        </div>
                                        <div class="form-group">
                                            <label style="margin-bottom: 0">Tarif narxi:</label>
                                            <input class="form-control" type="number" name="price" value="{{$traffic->price}}" required>
                                        </div>
                                        <div class="row">
                                            <div class="col">
                                                <div class="form-group">
                                                    <label style="margin-bottom: 0">Mijoz soni:</label>
                                                    <input class="form-control" type="number" name="clients_count" value="{{$traffic->clients_count}}" required>
                                                </div> 
                                            </div>
                                            <div class="col">
                                                <div class="form-group">
                                                    <label style="margin-bottom: 0">Sms soni:</label>
                                                    <input class="form-control" type="number" name="sms_count" value="{{$traffic->sms_count}}" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col">
                                                <div class="form-group">
                                                    <label style="margin-bottom: 0">Tovar soni:</label>
                                                    <input class="form-control" type="number" name="products_count" value="{{$traffic->products_count}}" required>
                                                </div> 
                                            </div>
                                            <div class="col">
                                                <div class="form-group">
                                                    <label style="margin-bottom: 0">Ishchilar soni:</label>
                                                    <input class="form-control" type="number" name="users_count" value="{{$traffic->users_count}}" required>
                                                </div> 
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label style="margin-bottom: 0"> Tarif turi:</label>
                                            <select class="form-control" name="status" value="{{$traffic->status}}" required>
                                                <option value="0">Asosiy</option>
                                                <option value="1">Qo'shimcha</option>
                                            </select>
                                        </div>  
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col">
                                                    <label style="margin-bottom: 0">Asosiy dizayni:</label>
                                                    <select class="form-control" name="style1">
                                                        <option value="pricing body start-grp">Start</option>
                                                        <option value="pricing body good-grp">Good</option>
                                                        <option value="pricing body ultimna-grp">Ultima</option>
                                                        <option value="pricing body vip-grp">Vip</option>
                                                    </select>
                                                </div>
                                                <div class="col">
                                                    <label style="margin-bottom: 0">Qo'shimcha dizayni:</label>
                                                    <select class="form-control" name="style2" >
                                                        <option value="pricing-plan personal">Personal</option>
                                                        <option value="pricing-plan free">Free</option>
                                                        <option value="pricing-plan performance">Performance</option>
                                                        <option value="pricing-plan business">Business</option>
                                                    </select>
                                                </div>
                                            </div>
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
                    <div class="modal fade" id="delete{{$traffic->id}}" tabindex="-1" role="dialog">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="title" id="defaultModalLabel">Taxrirlash</h4>
                                </div>
                                <form action="{{route('delete_traffic',['id' => $traffic->id])}}" method="post">
                                    @csrf
                                    <div class="modal-body">
                                        
                                        <div class="form-group">
                                            <label style="margin-bottom: 0">{{$traffic->name}} tarifini o'chirmoqchimisz</label>
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
            </div>
            <div class="row">
                <div class="col-lg-10 col-md-8 col-sm-12">
                    <h5 class="text-center">  Qo'shimcha tariflar </h5>
                </div>   
            </div>
            <div class="row clearfix">
                @foreach ($traffics as $traffic)
                    @if ($traffic->status == 1)
                        <div class="col-lg-3 col-md-12">
                            <div class="card pricing2">
                                <div class="body">
                                    <div class="{{$traffic->style2}}">
                                        <div class="header">
                                            <h2 class="pricing-header">{{$traffic->name}}</h2>
                                            <span class="pricing-price"><sup>so'm</sup>{{$traffic->price}}<sub>/1 oyga</sub></span>
                                        </div>
                                        <ul class="pricing-features">
                                            <li> {{$traffic->annotation}}</li>
                                            @if ($traffic->clients_count != 0)
                                                <li>Klient: {{$traffic->clients_count}} ta</li>
                                            @endif
                                            @if ($traffic->sms_count!=0)
                                                 <li>Sms: {{$traffic->sms_count}} ta</li>
                                            @endif
                                            @if ($traffic->products_count!=0)
                                                 <li>Tovar: {{$traffic->products_count}} ta</li>
                                            @endif
                                            @if ($traffic->users_count!=0)
                                                <li>Xodim: {{$traffic->users_count}} ta</li>
                                            @endif
                                          
                                        </ul>
                                        <label class="fancy-checkbox">
                                            <input type="checkbox" id="tr_check{{$traffic->id}}" onclick="check({{$traffic->id}})"
                                            @if ($q[$traffic->id] == true)
                                                checked
                                            @endif>
                                            <span>Active</span>
                                        </label>
                                        <button class="btn btn-dark" data-toggle="modal" data-target="#edit{{$traffic->id}}"> 
                                            <i class="fa fa-edit"></i> <span></span></button>
                                        <button class="btn btn-danger"data-toggle="modal" data-target="#delete{{$traffic->id}}"> 
                                            <i class="fa fa-trash-o"></i> <span></span></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
    </div>

@endsection
@section('scripts')
<script>
    function check(id) {
    var checkBox = document.getElementById('tr_check' + id);
    var text = document.getElementById("active_traffics_a").value;
        if (checkBox.checked == true){
            $("#active_traffics_a").val(text + "," + id);
        }
    }
</script> 
@endsection

