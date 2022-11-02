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
                    <h2>Idish kiritish</h2>
                </div>
                <div class="col-lg-7 col-md-4 col-sm-12 text-right">
                    <ul class="breadcrumb justify-content-end">
                        <li class="breadcrumb-item"><a href=""><i class="icon-home"></i></a></li>
                        <li class="breadcrumb-item active">Idish kiritish</li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="">
            <ul class="nav nav-tabs-new2">
                <li class="nav-item"><a class="nav-link" style="font-weight: bold; color: black" href="{{ route('entry_products') }}"><i
                            class="fa fa-home"></i>
                        Tovar kiritish</a></li>
                <li class="nav-item"><a class="nav-link"  style="font-weight: bold; color: black" href="{{ route('take_products') }}"><i class="fa fa-user"></i>
                        Tovar chiqarish</a></li>
                <li class="nav-item"><a class="nav-link active show"  style="font-weight: bold;" href="{{ route('entry_container') }}"><i
                            class="fa fa-home"></i> Idishlarni kiritish</a></li>
                <li class="nav-item"><a class="nav-link"  style="font-weight: bold; color: black" href="{{ route('take_container') }}"><i class="fa fa-user"></i>
                        Tara chiqarish </a></li>
            </ul>

            <div class="tab-content col-8">
                <div class="tab-pane show active">
                    <div class="card">
                        <div class="header">
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addcontainer">
                                <i class="fa fa-plus-circle"></i> Idishlarni qaytarish
                            </button>

                            <div class="modal fade" id="addcontainer" tabindex="-1" role="dialog">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="title" id="defaultModalLabel">Idishlarni qaytarish</h4>
                                        </div>
                                        <form action="{{ route('add_entry_container') }}" method="post">
                                            @csrf
                                            <div class="modal-body">
                                                <div class="form-group">
                                                    <h6><label>Kimdan:</label></h6>
                                                    <select class="form-control" name="user_id">
                                                        @foreach ($users as $user)
                                                            <option value="{{ $user->id }}">{{ $user->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <h6><label>Tovar nomi:</label></h6>
                                                    <select class="form-control" name="product_id">
                                                        @foreach ($products as $product)
                                                            <option value="{{ $product->id }}">{{ $product->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <h6><label>Soni:</label></h6>
                                                    <input class="form-control" type="number" name="container_count"
                                                        placeholder="Soni..." required>
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
                        </div>
                        <div class="body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-sm">
                                    <thead>
                                        <tr class="text-800 bg-200">
                                            <th width="80">#</th>
                                            <th>Tovar nomi</th>
                                            <th>Kimdan</th>
                                            <th>Qancha</th>
                                            <th>Qabul qildi</th>
                                            <th>Qachon</th>
                                            <th width="80px" style="min-width: 80px">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($entrycontainer as $entrycon)
                                            <tr>
                                                <td>{{ $entrycontainer->currentPage() * 10 - 10 + $loop->index + 1 }}
                                                </td>
                                                <td>
                                                    {{ $entrycon->product->name }}
                                                </td>
                                                <td>
                                                    {{ $entrycon->user->name }}
                                                </td>
                                                <td>
                                                    {{ $entrycon->product_count }}
                                                </td>
                                                <td>{{ $entrycon->received->name }}</td>
                                                <td>{{ $entrycon->created_at }}</td>

                                                <td>
                                                    <button type="button" class="btn btn-secondary"
                                                        data-toggle="modal" data-target="#edit{{ $entrycon->id }}">
                                                        <i class="fa fa-edit"></i> <span></span></button>
                                                    <button type="button" class="btn btn-danger"
                                                        data-toggle="modal" data-target="#delete{{ $entrycon->id }}"><i
                                                            class="fa fa-trash-o"></i> <span></span></button>
                                                </td>
                                            </tr>
                                            <div class="modal fade" id="edit{{ $entrycon->id }}" tabindex="-1"
                                                role="dialog">
                                                <div class="modal-dialog modal-dialog-centered" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h4 class="title" id="defaultModalLabel">Taxrirlash</h4>
                                                        </div>
                                                        <form
                                                            action="{{ route('edit_entry_container', ['id' => $entrycon->id]) }}"
                                                            method="post">
                                                            @csrf
                                                            <div class="modal-body">
                                                                <div class="form-group">
                                                                    <h6><label>Kimdan:</label></h6>
                                                                    <select class="form-control" name="user_id">
                                                                        @foreach ($users as $user)
                                                                            @if ($entrycon->user_id == $user->id)
                                                                                <option value="{{ $user->id }}"
                                                                                    selected>{{ $user->name }}</option>
                                                                            @else
                                                                                <option value="{{ $user->id }}">
                                                                                    {{ $user->name }}</option>
                                                                            @endif
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                                <div class="form-group">
                                                                    <h6><label>Tovar nomi:</label></h6>
                                                                    <select class="form-control" name="product_id">
                                                                        @foreach ($products as $product)
                                                                            @if ($entrycon->product_id == $product->id)
                                                                                <option value="{{ $product->id }}"
                                                                                    selected>{{ $product->name }}</option>
                                                                            @else
                                                                                <option value="{{ $product->id }}">
                                                                                    {{ $product->name }}</option>
                                                                            @endif
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                                <div class="form-group">
                                                                    <h6><label>Soni:</label></h6>
                                                                    <input class="form-control" type="number"
                                                                        value="{{ $entrycon->product_count }}"
                                                                        name="container_count" required>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-danger"
                                                                    data-dismiss="modal"> Chiqish</button>
                                                                <button class="btn btn-primary" type="submit">
                                                                    Saqlash</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="modal fade" id="delete{{ $entrycon->id }}" tabindex="-1"
                                                role="dialog">
                                                <div class="modal-dialog modal-dialog-centered" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h4 class="title" id="defaultModalLabel">O'chirish</h4>
                                                        </div>
                                                        <form
                                                            action="{{ route('delete_entry_container', ['id' => $entrycon->id]) }}"
                                                            method="post">
                                                            @csrf
                                                            <div class="modal-body">
                                                                <div class="form-group">
                                                                    <h6><label>O'chirishni xoxlaysizmi ?</label></h6>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-dismiss="modal"> Chiqish</button>
                                                                <button class="btn btn-danger" type="submit"> Xa,
                                                                    O'chirish</button>
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
                                    {{ $entrycontainer->withQueryString()->links() }}
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
    <script src="{{ asset('assets/js/pages/ui/dialogs.js') }}"></script>
@endpush
