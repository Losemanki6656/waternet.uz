@extends('layouts.master')


@section('content')



@if (count($errors) > 0)
  <div class="alert alert-danger">
    <strong>Whoops!</strong> There were some problems with your input.<br><br>
    <ul>
       @foreach ($errors->all() as $error)
         <li>{{ $error }}</li>
       @endforeach
    </ul>
  </div>
@endif

<div class="container-fluid">

    <div class="block-header">
        <div class="row">
            <div class="col-lg-5 col-md-8 col-sm-12">
                <h2>Xodimlar</h2>
            </div>            
            <div class="col-lg-7 col-md-4 col-sm-12 text-right">
                <ul class="breadcrumb justify-content-end">
                    <li class="breadcrumb-item"><a href=""><i class="icon-home"></i></a></li>                            
                    <li class="breadcrumb-item active">Xodim qo'shish</li>
                </ul>
            </div>
        </div>
    </div>

    <div class="row clearfix">
        <div class="col-lg-9 col-md-12">
            
            <div class="card">
                <div class="header">
                    <h2> Xodim qo'shish</h2>
                </div>
                <div class="body">
                    {!! Form::open(array('route' => 'users.store','method'=>'POST')) !!}

                    <div class="row">
                            <div class="col-lg-3">
                                <div class="mb-3">
                                    <label for="lastname"> FIO: </label> 
                                     {!! Form::text('name', null, array('placeholder' => 'Name','class' => 'form-control')) !!}
                                </div>
                                <div class="mb-3">
                                    <label for="firstname"> Email: </label>
                                     {!! Form::text('email', null, array('placeholder' => 'Email','class' => 'form-control')) !!}           
                                </div>
                                <div class="mb-3">
                                    <label for="middlename"> Parol: </label>  
                                    {!! Form::password('password', array('placeholder' => 'Password','class' => 'form-control')) !!}    
                                </div>
                                <div class="mb-3">
                                    <label for="birhtdate"> Parolni takrorlash: </label>  
                                    {!! Form::password('confirm-password', array('placeholder' => 'Confirm Password','class' => 'form-control')) !!}             
                                </div>
                                <div class="mb-3">
                                    <a href="{{ route('users') }}" class="btn btn-dark" type="button"><i class="fa fa-mail-reply"></i> Orqaga </a>  
                                    <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Saqlash</button>       
                                </div>       
                            </div>
                            
                            <div class="col" style="margin-top:165px">
                                <div class="mt-3">
                                    <div class="row">
                                        <div class="col">
                                            <div class="fancy-checkbox">
                                                <label><input type="checkbox" name="bosh"><span>Bosh menu</span></label>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="fancy-checkbox">
                                                <label><input type="checkbox" name="client"><span>Klientlar</span></label>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="fancy-checkbox">
                                                <label><input type="checkbox" name="order"><span>Zakazlar</span></label>
                                            </div>
                                        </div>
                                    </div>
                                </div>    
                                <div class="mt-3">
                                    <div class="row">
                                        <div class="col">
                                            <div class="fancy-checkbox">
                                                <label><input type="checkbox" name="product"><span>Tovarlar</span></label>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="fancy-checkbox">
                                                <label><input type="checkbox" name="sklad"><span>Sklad</span></label>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="fancy-checkbox">
                                                <label><input type="checkbox" name="users"><span>Xodimlar</span></label>
                                            </div>
                                        </div>
                                    </div>
                                </div>  
                                <div class="mt-3">
                                    <div class="row">
                                        <div class="col">
                                            <div class="fancy-checkbox">
                                                <label><input type="checkbox" name="regions"><span>Regionlar</span></label>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="fancy-checkbox">
                                                <label><input type="checkbox" name="sms"><span>Sms</span></label>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="fancy-checkbox">
                                                <label><input type="checkbox" name="results"><span>Xisobotlar</span></label>
                                            </div>
                                        </div>
                                    </div>
                                </div>  
                            </div>
                    </div>
                    
                    {!! Form::close() !!}
                </div>   
            </div>
        </div>
    </div>
</div>



@endsection