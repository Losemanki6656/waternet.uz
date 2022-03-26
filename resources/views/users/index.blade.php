@extends('layouts.master')


@section('content')

@if ($message = Session::get('success'))
<div class="alert alert-success">
  <p>{{ $message }}</p>
</div>
@endif

<div class="container-fluid">
    <div class="block-header">
        <div class="row">
            <div class="col-lg-5 col-md-8 col-sm-12">
                <h2>Tovarlar</h2>
            </div>            
            <div class="col-lg-7 col-md-4 col-sm-12 text-right">
                <ul class="breadcrumb justify-content-end">
                    <a href="{{ route('users_create') }}" class="btn btn-primary me-1 mb-1" type="button">
                        <span class="fa fa-plus me-1"></span> Xodim qo'shish
                    </a>
                </ul>
            </div>
        </div>
    </div>

<div class="card">
    <div class="card-body">
        
        <div class="table-responsive scrollbar">
        <table class="table table-bordered">
            <thead class="bg-light">
            <tr class="text-800 bg-200">
                <th class="text-nowrap" width="180">No</th>
                <th class="text-center text-nowrap">Name</th>
                <th class="text-center text-nowrap">Email </th>
                <th class="text-center text-nowrap">Organization</th>
                <th class="text-center text-nowrap">Action</th>
            </tr>
            </thead>
            <tbody>
                @foreach ($data as $user)
                    <tr class="border-bottom border-200">
                        <td >
                            {{$loop->index + 1}}
                        </td>
                        <td class="text-center">
                            {{ $user->name }}
                        </td>
                        <td class="text-center">
                            {{ $user->email }}
                        </td>
                        <td class="text-center">
                            @if (Auth::user()->id == 1)
                                @if ($user->id != 1)
                                    {{$org[$user->id]}}
                                @endif
                            @else
                                Xodim
                            @endif
                        </td>
                        <td class="text-center">
                            <div>
                                <a href="{{ route('users.edit',$user->id) }}" class="btn btn-dark" type="button"><i class="fa fa-edit"></i>
                                </a>
                                <button type="button" class="btn btn-danger" type="button"><i class="fa fa-trash" data-toggle="modal" data-target="#deluser{{$user->id}}"></i>
                                </button>
                               
                            </div>  

                            <div class="modal fade" id="deluser{{$user->id}}" tabindex="-1" role="dialog">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="title" id="defaultModalLabel">O'chirish</h4>
                                        </div>
                                            <div class="modal-body">
                                                <div class="form-group">
                                                    <h6><label>{{$user->name}} - O'chirilsinmi ?</label></h6>
                                                </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal"> Chiqish</button>
                                                {!! Form::open(['method' => 'DELETE','route' => ['users.destroy', $user->id],'style'=>'display:inline']) !!}
                                                {!! Form::submit("O'chirish", ['class' => 'btn btn-danger']) !!} 
                                                {!! Form::close() !!}
                                            </div>
                                    </div>
                                </div>
                            </div> 

                        </td> 
                    </tr>  
                @endforeach         
            </tbody>
        </table>
        </div>
    </div>
</div>



@endsection


