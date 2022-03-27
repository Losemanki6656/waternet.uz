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
                    <li class="breadcrumb-item active">Xodim taxrirlash</li>
                </ul>
            </div>
        </div>
    </div>

    <div class="row clearfix">
        <div class="col-lg-9 col-md-12">
            
            <div class="card">
                <div class="header">
                    <h2> Taxrirlash</h2>
                </div>
                <div class="body">
                    {!! Form::model($user, ['method' => 'PATCH','route' => ['users.update', $user->id]]) !!}
                        <div class="row">
                                <div class="col-lg-3">
                                    <div class="mb-3">
                                        <label for="lastname"> FIO: </label>  {!! Form::text('name', null, array('placeholder' => 'Name','class' => 'form-control')) !!}
                                    </div>
                                    <div class="mb-3">
                                        <label for="firstname"> Email: </label> {!! Form::text('email', null, array('placeholder' => 'Email','class' => 'form-control')) !!}           
                                    </div>
                                    <div class="mb-3">
                                        <label for="middlename"> Parol: </label>  {!! Form::password('password', array('placeholder' => 'Password','class' => 'form-control')) !!}    
                                    </div>
                                    <div class="mb-3">
                                        <label for="birhtdate"> Parolni takrorlash: </label>  {!! Form::password('confirm-password', array('placeholder' => 'Confirm Password','class' => 'form-control')) !!}             
                                    </div>
                                    <div class="mb-3">
                                        @if (Auth::user()->id == 1)
                                        <a href="{{ route('users_admin') }}" class="btn btn-dark" type="button"><i class="fa fa-mail-reply"></i> Orqaga </a>  
                                        @else
                                        <a href="{{ route('users') }}" class="btn btn-dark" type="button"><i class="fa fa-mail-reply"></i> Orqaga </a>  
                                        @endif
                                        <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Saqlash</button>       
                                    </div>       
                                </div>
                                <div class="col" style="margin-top:165px">
                                    <div class="mt-3">
                                        <div class="row">
                                            <div class="col">
                                                <div class="fancy-checkbox">
                                                    <label><input type="checkbox" @if ($p[2]!='0') checked  @endif  name="bosh"><span>Bosh menu</span></label>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="fancy-checkbox">
                                                    <label><input type="checkbox"@if ($p[3]!='0') checked @endif name="client"><span>Klientlar</span></label>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="fancy-checkbox">
                                                    <label><input type="checkbox" @if ($p[4]!='0') checked @endif name="order"><span>Zakazlar</span></label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>    
                                    <div class="mt-3">
                                        <div class="row">
                                            <div class="col">
                                                <div class="fancy-checkbox">
                                                    <label><input type="checkbox" @if ($p[9]!='0') checked @endif name="product"><span>Tovarlar</span></label>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="fancy-checkbox">
                                                    <label><input type="checkbox" @if ($p[6]!='0') checked @endif name="sklad"><span>Sklad</span></label>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="fancy-checkbox">
                                                    <label><input type="checkbox" @if ($p[10]!='0') checked @endif name="users"><span>Xodimlar</span></label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>  
                                    <div class="mt-3">
                                        <div class="row">
                                            <div class="col">
                                                <div class="fancy-checkbox">
                                                    <label><input type="checkbox" @if ($p[5]!='0') checked @endif name="regions"><span>Regionlar</span></label>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="fancy-checkbox">
                                                    <label><input type="checkbox" @if ($p[7]!='0') checked @endif name="sms"><span>Sms</span></label>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="fancy-checkbox">
                                                    <label><input type="checkbox" @if ($p[8]!='0') checked @endif name="results"><span>Xisobotlar</span></label>
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