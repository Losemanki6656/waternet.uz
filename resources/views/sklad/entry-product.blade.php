@extends('layouts.v2_master')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">{{ __('messages.warehouse') }}</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">{{ __('messages.home') }}</a></li>
                        <li class="breadcrumb-item active">{{ __('messages.warehouse') }}</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12 col-sm-12 col-lg-8">
            <div class="card rounded-4">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">{{ __('messages.warehouse_actions') }}</h4>
                    <div class="flex-shrink-0">
                        <ul class="nav justify-content-end nav-pills card-header-pills" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" id="entry_products_id" href="#entry_products"
                                    role="tab">
                                    <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                                    <span class="d-none d-sm-block">{{ __('messages.entry_products') }}</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" id="take_products_id" href="#take_products"
                                    role="tab">
                                    <span class="d-block d-sm-none"><i class="far fa-user"></i></span>
                                    <span class="d-none d-sm-block">{{ __('messages.take_products') }}</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" id="entry_container_id" href="#entry_container"
                                    role="tab">
                                    <span class="d-block d-sm-none"><i class="far fa-user"></i></span>
                                    <span class="d-none d-sm-block">{{ __('messages.entry_container') }}</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" id="take_container_id" href="#take_container"
                                    role="tab">
                                    <span class="d-block d-sm-none"><i class="far fa-user"></i></span>
                                    <span class="d-none d-sm-block">{{ __('messages.take_container') }}</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="card-body">
                    <div class="tab-content">
                        <div class="tab-pane" id="entry_products" role="tabpanel">
                            <button type="button" class="btn btn-primary  btn-lg waves-effect waves-light"
                                data-bs-toggle="modal" data-bs-target="#entryProduct">
                                <i class="fa fa-plus-circle me-2"></i> {{ __('messages.entry_product') }}
                            </button>

                            <div class="modal fade" id="entryProduct" tabindex="-1" role="dialog">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="myModalLabel">
                                                {{ __('messages.update_city') }}</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <form action="{{ route('add_entry_product') }}" method="post">
                                            @csrf
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <label class="mb-0">{{ __('messages.product_name') }}:</label>
                                                    <select class="form-select" name="product_id">
                                                        @foreach ($products as $product)
                                                            <option value="{{ $product->id }}">{{ $product->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="row mb-3">
                                                    <div class="col-md-6">
                                                        <label class="mb-0">{{ __('messages.count') }}:</label>
                                                        <input class="form-control" type="number" name="product_count"
                                                            placeholder="{{ __('messages.count') }}..." required>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="mb-0">{{ __('messages.price') }}:</label>
                                                        <input class="form-control" type="number" name="price"
                                                            placeholder="{{ __('messages.price') }}..." required>
                                                    </div>

                                                </div>
                                                <div class="mb-3">
                                                    <label class="mb-0">{{ __('messages.comment') }}:</label>
                                                    <input class="form-control" type="text" name="comment"
                                                        placeholder="{{ __('messages.comment') }}...">
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button"
                                                    class="btn btn-secondary btn-lg waves-effect waves-light"
                                                    data-bs-dismiss="modal"> <i class="fas fa-reply me-2"></i>
                                                    {{ __('messages.cancel') }}</button>
                                                <button class="btn btn-success btn-lg waves-effect waves-light"
                                                    type="submit"> <i class="fa fa-save me-2"></i>
                                                    {{ __('messages.save') }}</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="table-responsive mt-3">
                                <table class="table table-sm align-middle table-bordered table-nowrap">
                                    <thead class="table-light">
                                        <tr>
                                            <th class="text-center" width="80">#</th>
                                            <th class="text-center">{{ __('messages.product_name') }}</th>
                                            <th class="text-center">{{ __('messages.count') }}</th>
                                            <th class="text-center">{{ __('messages.price') }}</th>
                                            <th class="text-center">{{ __('messages.when') }}</th>
                                            <th class="text-center">{{ __('messages.comment') }}</th>
                                            <th class="text-center">{{ __('messages.user') }}</th>
                                            <th class="text-center" width="100px">{{ __('messages.action') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($entryproduct as $enproduct)
                                            <tr>
                                                <td class="text-center">
                                                    {{ $entryproduct->currentPage() * 10 - 10 + $loop->index + 1 }}
                                                </td>
                                                <td class="text-center">
                                                    {{ $enproduct->product->name ?? '' }}
                                                </td>
                                                <td class="text-center">
                                                    {{ $enproduct->product_count }}
                                                </td>
                                                <td class="text-center">
                                                    {{ $enproduct->price }}
                                                </td>
                                                <td class="text-center">{{ $enproduct->created_at }}</td>
                                                <td class="text-center">{{ $enproduct->comment }}</td>
                                                <td class="text-center">{{ $enproduct->user->name }}</td>

                                                <td class="text-center">
                                                    <button type="button"
                                                        class="btn btn-soft-primary waves-effect waves-light"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#editEntryProduct{{ $enproduct->id }}"><i
                                                            class="bx bx-edit-alt font-size-16 align-middle"></i></button>
                                                    <button type="button"
                                                        class="btn btn-soft-danger waves-effect waves-light"
                                                        onclick="DeleteEntryProduct({{ $enproduct->id }})"><i
                                                            class="bx bx-trash-alt font-size-16 align-middle"></i></button>
                                                </td>
                                            </tr>
                                            <div class="modal fade" id="editEntryProduct{{ $enproduct->id }}"
                                                tabindex="-1" role="dialog">
                                                <div class="modal-dialog modal-dialog-centered" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="myModalLabel">
                                                                {{ __('messages.update') }}</h5>
                                                            <button type="button" class="btn-close"
                                                                data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <form
                                                            action="{{ route('edit_entry_product', ['id' => $enproduct->id]) }}"
                                                            method="post">
                                                            @csrf
                                                            <div class="modal-body">
                                                                <div class="mb-3">
                                                                    <label
                                                                        class="mb-0">{{ __('messages.product_name') }}:</label>
                                                                    <select class="form-select" name="product_id">
                                                                        @foreach ($products as $product)
                                                                            @if ($enproduct->product_id == $product->id)
                                                                                <option value="{{ $product->id }}"
                                                                                    selected>
                                                                                    {{ $product->name }}</option>
                                                                            @else
                                                                                <option value="{{ $product->id }}">
                                                                                    {{ $product->name }}</option>
                                                                            @endif
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                                <div class="row mb-3">
                                                                    <div class="col-md-6">
                                                                        <label
                                                                            class="mb-0">{{ __('messages.count') }}:</label>
                                                                        <input class="form-control" type="number"
                                                                            name="product_count"
                                                                            value="{{ $enproduct->product_count }}"
                                                                            required>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <label
                                                                            class="mb-0">{{ __('messages.price') }}:</label>
                                                                        <input class="form-control" type="number"
                                                                            name="price"
                                                                            value="{{ $enproduct->price }}" required>
                                                                    </div>
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label
                                                                        class="mb-0">{{ __('messages.comment') }}:</label>
                                                                    <input class="form-control" type="text"
                                                                        name="comment" value="{{ $enproduct->comment }}"
                                                                        placeholder="{{ __('messages.comment') }}...">
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button"
                                                                    class="btn btn-secondary btn-lg waves-effect waves-light"
                                                                    data-bs-dismiss="modal"> <i
                                                                        class="fas fa-reply me-2"></i>
                                                                    {{ __('messages.cancel') }}</button>
                                                                <button
                                                                    class="btn btn-success btn-lg waves-effect waves-light"
                                                                    type="submit"> <i class="fa fa-save me-2"></i>
                                                                    {{ __('messages.save') }}</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </tbody>
                                </table>

                            </div>
                            <div class="d-flex justify-content-end">
                                <ul class="pagination mb-0">
                                    {{ $entryproduct->onEachSide(1)->withQueryString()->links() }}
                                </ul>
                            </div>

                        </div>
                        <div class="tab-pane" id="take_products" role="tabpanel">
                            <button type="button" class="btn btn-primary btn-lg waves-effect waves-light"
                                data-toggle="modal" data-target="#takprod">
                                <i class="fa fa-plus-circle me-2"></i> {{ __('messages.take_product') }}
                            </button>

                            <div class="modal fade" id="takprod" tabindex="-1" role="dialog">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="myModalLabel">
                                                {{ __('messages.update_city') }}</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <form action="{{ route('add_take_product') }}" method="post">
                                            @csrf
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <label class="mb-0">{{ __('messages.to_whom') }}:</label>
                                                    <select class="form-control" name="user_id">
                                                        @foreach ($users as $user)
                                                            <option value="{{ $user->id }}">{{ $user->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="mb-0">{{ __('messages.product_name') }}:</label>
                                                    <select class="form-control" name="product_id">
                                                        @foreach ($products as $product)
                                                            <option value="{{ $product->id }}">{{ $product->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="mb-0">{{ __('messages.count') }}:</label>
                                                    <input class="form-control" type="number" name="product_count"
                                                        placeholder="{{ __('messages.count') }}..." required>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button"
                                                    class="btn btn-secondary btn-lg waves-effect waves-light"
                                                    data-bs-dismiss="modal"> <i class="fas fa-reply me-2"></i>
                                                    {{ __('messages.cancel') }}</button>
                                                <button class="btn btn-success btn-lg waves-effect waves-light"
                                                    type="submit"> <i class="fa fa-save me-2"></i>
                                                    {{ __('messages.save') }}</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="table-responsive mt-3">
                                <table class="table table-sm align-middle table-bordered table-nowrap">
                                    <thead class="table-light">
                                        <tr>
                                            <th class="text-center" width="80">#</th>
                                            <th class="text-center">{{ __('messages.to_whom') }}</th>
                                            <th class="text-center">{{ __('messages.product_name') }}</th>
                                            <th class="text-center">{{ __('messages.count') }}</th>
                                            <th class="text-center">{{ __('messages.time_taken') }}</th>
                                            <th class="text-center">{{ __('messages.who_gave') }}</th>
                                            <th class="text-center" width="100px">{{ __('messages.action') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($takeproducts as $takeproduct)
                                            <tr>
                                                <td class="text-center">
                                                    {{ $takeproducts->currentPage() * 10 - 10 + $loop->index + 1 }}
                                                </td>
                                                <td class="text-center">
                                                    {{ $takeproduct->received->name ?? '' }}
                                                </td>
                                                <td class="text-center">
                                                    {{ $takeproduct->product->name ?? '' }}
                                                </td>
                                                <td class="text-center">
                                                    {{ $takeproduct->product_count }}
                                                </td>
                                                <td class="text-center">{{ $takeproduct->created_at }}</td>

                                                <td class="text-center">{{ $takeproduct->sent->name }}</td>
                                                <td class="text-center">
                                                    <button type="button"
                                                        class="btn btn-soft-primary waves-effect waves-light"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#editTakeProduct{{ $takeproduct->id }}"><i
                                                            class="bx bx-edit-alt font-size-16 align-middle"></i></button>
                                                    <button type="button"
                                                        class="btn btn-soft-danger waves-effect waves-light"
                                                        onclick="DeleteTakeProduct({{ $takeproduct->id }})"><i
                                                            class="bx bx-trash-alt font-size-16 align-middle"></i></button>
                                                </td>
                                            </tr>
                                            <div class="modal fade" id="editTakeProduct{{ $takeproduct->id }}"
                                                tabindex="-1" role="dialog">
                                                <div class="modal-dialog modal-dialog-centered" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="myModalLabel">
                                                                {{ __('messages.update') }}</h5>
                                                            <button type="button" class="btn-close"
                                                                data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <form
                                                            action="{{ route('take_edit_product', ['id' => $takeproduct->id]) }}"
                                                            method="post">
                                                            @csrf
                                                            <div class="modal-body">
                                                                <div class="mb-3">
                                                                    <label
                                                                        class="mb-0">{{ __('messages.to_whom') }}:</label>
                                                                    <select class="form-select" name="user_id">
                                                                        @foreach ($users as $user)
                                                                            @if ($takeproduct->received_id == $user->id)
                                                                                <option value="{{ $user->id }}"
                                                                                    selected>{{ $user->name }}</option>
                                                                            @else
                                                                                <option value="{{ $user->id }}">
                                                                                    {{ $user->name }}</option>
                                                                            @endif
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label
                                                                        class="mb-0">{{ __('messages.product_name') }}:</label>
                                                                    <select class="form-control" name="product_id">
                                                                        @foreach ($products as $product)
                                                                            @if ($takeproduct->product_id == $product->id)
                                                                                <option value="{{ $product->id }}"
                                                                                    selected>{{ $product->name }}</option>
                                                                            @else
                                                                                <option value="{{ $product->id }}">
                                                                                    {{ $product->name }}</option>
                                                                            @endif
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label
                                                                        class="mb-0">{{ __('messages.count') }}:</label>
                                                                    <input class="form-control" type="number"
                                                                        name="product_count"
                                                                        value="{{ $takeproduct->product_count }}"
                                                                        required>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button"
                                                                    class="btn btn-secondary btn-lg waves-effect waves-light"
                                                                    data-bs-dismiss="modal"> <i
                                                                        class="fas fa-reply me-2"></i>
                                                                    {{ __('messages.cancel') }}</button>
                                                                <button
                                                                    class="btn btn-success btn-lg waves-effect waves-light"
                                                                    type="submit"> <i class="fa fa-save me-2"></i>
                                                                    {{ __('messages.save') }}</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="d-flex justify-content-end">
                                <ul class="pagination mb-0">
                                    {{ $takeproducts->onEachSide(1)->withQueryString()->links() }}
                                </ul>
                            </div>
                        </div>
                        <div class="tab-pane" id="entry_container" role="tabpanel">
                            <button type="button" class="btn btn-primary btn-lg waves-effect waves-light"
                                data-bs-toggle="modal" data-bs-target="#addcontainer">
                                <i class="fa fa-plus-circle me-2"></i> {{ __('messages.entry_containers') }}
                            </button>

                            <div class="modal fade" id="addcontainer" tabindex="-1" role="dialog">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="myModalLabel">
                                                {{ __('messages.entry_containers') }}</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <form action="{{ route('add_entry_container') }}" method="post">
                                            @csrf
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <label class="mb-0">{{ __('messages.from_whom') }}:</label>
                                                    <select class="form-control" name="user_id">
                                                        @foreach ($users as $user)
                                                            <option value="{{ $user->id }}">{{ $user->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="mb-0">{{ __('messages.product_name') }}:</label>
                                                    <select class="form-control" name="product_id">
                                                        @foreach ($products as $product)
                                                            <option value="{{ $product->id }}">{{ $product->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="mb-0">{{ __('messages.count') }}:</label>
                                                    <input class="form-control" type="number" name="container_count"
                                                        placeholder="{{ __('messages.count') }}..." required>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button"
                                                    class="btn btn-secondary btn-lg waves-effect waves-light"
                                                    data-bs-dismiss="modal"> <i class="fas fa-reply me-2"></i>
                                                    {{ __('messages.cancel') }}</button>
                                                <button class="btn btn-success btn-lg waves-effect waves-light"
                                                    type="submit"> <i class="fa fa-save me-2"></i>
                                                    {{ __('messages.save') }}</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="table-responsive mt-3">
                                <table class="table table-sm align-middle table-bordered table-nowrap">
                                    <thead class="table-light">
                                        <tr>
                                            <th class="text-center" width="80">#</th>
                                            <th class="text-center">{{ __('messages.product_name') }}</th>
                                            <th class="text-center">{{ __('messages.from_whom') }}</th>
                                            <th class="text-center">{{ __('messages.count') }}</th>
                                            <th class="text-center">{{ __('messages.user') }}</th>
                                            <th class="text-center">{{ __('messages.when') }}</th>
                                            <th class="text-center" width="100px">{{ __('messages.action') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($entrycontainer as $entrycon)
                                            <tr>
                                                <td class="text-center">
                                                    {{ $entrycontainer->currentPage() * 10 - 10 + $loop->index + 1 }}
                                                </td>
                                                <td class="text-center">
                                                    {{ $entrycon->product->name ?? '' }}
                                                </td>
                                                <td class="text-center">
                                                    {{ $entrycon->user->name ?? '' }}
                                                </td>
                                                <td class="text-center">
                                                    {{ $entrycon->product_count }}
                                                </td>
                                                <td class="text-center">{{ $entrycon->received->name }}</td>
                                                <td class="text-center">{{ $entrycon->created_at }}</td>

                                                <td class="text-center">
                                                    <button type="button"
                                                        class="btn btn-soft-primary waves-effect waves-light"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#editEntryContainer{{ $entrycon->id }}"><i
                                                            class="bx bx-edit-alt font-size-16 align-middle"></i></button>
                                                    <button type="button"
                                                        class="btn btn-soft-danger waves-effect waves-light"
                                                        onclick="DeleteEntryContainer({{ $entrycon->id }})"><i
                                                            class="bx bx-trash-alt font-size-16 align-middle"></i></button>
                                                </td>
                                            </tr>
                                            <div class="modal fade" id="editEntryContainer{{ $entrycon->id }}"
                                                tabindex="-1" role="dialog">
                                                <div class="modal-dialog modal-dialog-centered" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="myModalLabel">
                                                                {{ __('messages.update') }}</h5>
                                                            <button type="button" class="btn-close"
                                                                data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <form
                                                            action="{{ route('edit_entry_container', ['id' => $entrycon->id]) }}"
                                                            method="post">
                                                            @csrf
                                                            <div class="modal-body">
                                                                <div class="mb-3">
                                                                    <label
                                                                        class="mb-0">{{ __('messages.from_whom') }}:</label>
                                                                    <select class="form-select" name="user_id">
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
                                                                <div class="mb-3">
                                                                    <label
                                                                        class="mb-0">{{ __('messages.product_name') }}:</label>
                                                                    <select class="form-select" name="product_id">
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
                                                                <div class="mb-3">
                                                                    <label
                                                                        class="mb-0">{{ __('messages.count') }}:</label>
                                                                    <input class="form-control" type="number"
                                                                        value="{{ $entrycon->product_count }}"
                                                                        name="container_count" required>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button"
                                                                    class="btn btn-secondary btn-lg waves-effect waves-light"
                                                                    data-bs-dismiss="modal"> <i
                                                                        class="fas fa-reply me-2"></i>
                                                                    {{ __('messages.cancel') }}</button>
                                                                <button
                                                                    class="btn btn-success btn-lg waves-effect waves-light"
                                                                    type="submit"> <i class="fa fa-save me-2"></i>
                                                                    {{ __('messages.save') }}</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="d-flex justify-content-end">
                                <ul class="pagination mb-0">
                                    {{ $entrycontainer->onEachSide(1)->withQueryString()->links() }}
                                </ul>
                            </div>
                        </div>
                        <div class="tab-pane" id="take_container" role="tabpanel">
                            <button type="button" class="btn btn-primary  btn-lg waves-effect waves-light"
                                data-bs-toggle="modal" data-bs-target="#takcontainer">
                                <i class="fa fa-plus-circle"></i> {{ __('messages.take_container') }}
                            </button>

                            <div class="modal fade" id="takcontainer" tabindex="-1" role="dialog">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="myModalLabel">
                                                {{ __('messages.take_container') }}</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <form action="{{ route('take_entry_container') }}" method="post">
                                            @csrf
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <label class="mb-0">{{ __('messages.product_name') }}:</label>
                                                    <select class="form-select" name="product_id">
                                                        @foreach ($products as $product)
                                                            <option value="{{ $product->id }}">
                                                                {{ $product->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="mb-0">{{ __('messages.count') }}:</label>
                                                    <input class="form-control" type="number" name="product_count"
                                                        placeholder="{{ __('messages.count') }}..." required>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="mb-0">{{ __('messages.comment') }}:</label>
                                                    <input class="form-control" type="text" name="comment"
                                                        placeholder="{{ __('messages.comment') }}...">
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button"
                                                    class="btn btn-secondary btn-lg waves-effect waves-light"
                                                    data-bs-dismiss="modal"> <i class="fas fa-reply me-2"></i>
                                                    {{ __('messages.cancel') }}</button>
                                                <button class="btn btn-success btn-lg waves-effect waves-light"
                                                    type="submit"> <i class="fa fa-save me-2"></i>
                                                    {{ __('messages.save') }}</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="table-responsive mt-3">
                                <table class="table table-sm align-middle table-bordered table-nowrap">
                                    <thead class="table-light">
                                        <tr>
                                            <th class="text-center" width="80px">#</th>
                                            <th class="text-center">{{ __('messages.from_whom') }}</th>
                                            <th class="text-center">{{ __('messages.product_name') }}</th>
                                            <th class="text-center">{{ __('messages.count') }}</th>
                                            <th class="text-center">{{ __('messages.when') }}</th>
                                            <th class="text-center">{{ __('messages.comment') }}</th>
                                            <th class="text-center" width="80px">{{ __('messages.comment') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($takecontainer as $takecon)
                                            <tr>
                                                <td class="text-center">
                                                    {{ $takecontainer->currentPage() * 10 - 10 + $loop->index + 1 }}
                                                </td>
                                                <td class="text-center">
                                                    {{ $takecon->user->name ?? '' }}
                                                </td>
                                                <td class="text-center">
                                                    {{ $takecon->product->name ?? '' }}
                                                </td>
                                                <td class="text-center">
                                                    {{ $takecon->product_count }}
                                                </td>
                                                <td class="text-center">{{ $takecon->created_at }}</td>
                                                <td class="text-center">{{ $takecon->comment }}</td>

                                                <td class="text-center">
                                                    <button type="button"
                                                        class="btn btn-soft-primary waves-effect waves-light"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#editTakeContainer{{ $takecon->id }}"><i
                                                            class="bx bx-edit-alt font-size-16 align-middle"></i></button>
                                                    <button type="button"
                                                        class="btn btn-soft-danger waves-effect waves-light"
                                                        onclick="DeleteTakeContainer({{ $takecon->id }})"><i
                                                            class="bx bx-trash-alt font-size-16 align-middle"></i></button>
                                                </td>
                                            </tr>
                                            <div class="modal fade" id="editTakeContainer{{ $takecon->id }}"
                                                tabindex="-1" role="dialog">
                                                <div class="modal-dialog modal-dialog-centered" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="myModalLabel">
                                                                {{ __('messages.update') }}</h5>
                                                            <button type="button" class="btn-close"
                                                                data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <form
                                                            action="{{ route('take_edit_container', ['id' => $takecon->id]) }}"
                                                            method="post">
                                                            @csrf
                                                            <div class="modal-body">
                                                                <div class="mb-3">
                                                                    <label
                                                                        class="mb-0">{{ __('messages.product_name') }}:</label>
                                                                    <select class="form-select" name="product_id">
                                                                        @foreach ($products as $product)
                                                                            @if ($takecon->product_id == $product->id)
                                                                                <option value="{{ $product->id }}"
                                                                                    selected>{{ $product->name }}
                                                                                </option>
                                                                            @else
                                                                                <option value="{{ $product->id }}">
                                                                                    {{ $product->name }}</option>
                                                                            @endif
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label
                                                                        class="mb-0">{{ __('messages.count') }}:</label>
                                                                    <input class="form-control" type="number"
                                                                        name="product_count"
                                                                        value="{{ $takecon->product_count }}" required>
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label
                                                                        class="mb-0">{{ __('messages.comment') }}:</label>
                                                                    <input class="form-control" type="text"
                                                                        name="comment" value="{{ $takecon->comment }}">
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button"
                                                                    class="btn btn-secondary btn-lg waves-effect waves-light"
                                                                    data-bs-dismiss="modal"> <i
                                                                        class="fas fa-reply me-2"></i>
                                                                    {{ __('messages.cancel') }}</button>
                                                                <button
                                                                    class="btn btn-success btn-lg waves-effect waves-light"
                                                                    type="submit"> <i class="fa fa-save me-2"></i>
                                                                    {{ __('messages.save') }}</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="d-flex justify-content-end">
                                <ul class="pagination mb-0">
                                    {{ $takecontainer->onEachSide(1)->withQueryString()->links() }}
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            let activeTab = localStorage.getItem('activaWarehouseTab') ?? 'entry_products';
            if (activeTab == "entry_products") {
                document.getElementById("entry_products_id").setAttribute("class", "nav-link active");
                document.getElementById("take_products_id").setAttribute("class", "nav-link");
                document.getElementById("entry_container_id").setAttribute("class", "nav-link");
                document.getElementById("take_container_id").setAttribute("class", "nav-link");
                document.getElementById("entry_products").setAttribute("class", "tab-pane active");
                document.getElementById("take_products").setAttribute("class", "tab-pane");
                document.getElementById("entry_container").setAttribute("class", "tab-pane");
                document.getElementById("take_container").setAttribute("class", "tab-pane");

            } else if (activeTab == "take_products") {
                document.getElementById("entry_products_id").setAttribute("class", "nav-link");
                document.getElementById("take_products_id").setAttribute("class", "nav-link active");
                document.getElementById("entry_container_id").setAttribute("class", "nav-link");
                document.getElementById("take_container_id").setAttribute("class", "nav-link");
                document.getElementById("entry_products").setAttribute("class", "tab-pane");
                document.getElementById("take_products").setAttribute("class", "tab-pane active");
                document.getElementById("entry_container").setAttribute("class", "tab-pane");
                document.getElementById("take_container").setAttribute("class", "tab-pane");
            } else
            if (activeTab == "entry_container") {
                document.getElementById("entry_products_id").setAttribute("class", "nav-link");
                document.getElementById("take_products_id").setAttribute("class", "nav-link");
                document.getElementById("entry_container_id").setAttribute("class", "nav-link active");
                document.getElementById("take_container_id").setAttribute("class", "nav-link");
                document.getElementById("entry_products").setAttribute("class", "tab-pane");
                document.getElementById("take_products").setAttribute("class", "tab-pane");
                document.getElementById("entry_container").setAttribute("class", "tab-pane active");
                document.getElementById("take_container").setAttribute("class", "tab-pane");
            } else if (activeTab == "take_container") {
                document.getElementById("entry_products_id").setAttribute("class", "nav-link");
                document.getElementById("take_products_id").setAttribute("class", "nav-link");
                document.getElementById("entry_container_id").setAttribute("class", "nav-link");
                document.getElementById("take_container_id").setAttribute("class", "nav-link active");
                document.getElementById("entry_products").setAttribute("class", "tab-pane");
                document.getElementById("take_products").setAttribute("class", "tab-pane");
                document.getElementById("entry_container").setAttribute("class", "tab-pane");
                document.getElementById("take_container").setAttribute("class", "tab-pane active");
            }
        });
    </script>
    <script>
        document.getElementById('entry_products_id').onclick = function() {
            let c = localStorage.setItem('activaWarehouseTab', 'entry_products');
            document.getElementById("entry_products_id").setAttribute("class", "nav-link active");
            document.getElementById("take_products_id").setAttribute("class", "nav-link");
            document.getElementById("entry_container_id").setAttribute("class", "nav-link");
            document.getElementById("take_container_id").setAttribute("class", "nav-link");
            document.getElementById("entry_products").setAttribute("class", "tab-pane active");
            document.getElementById("take_products").setAttribute("class", "tab-pane");
            document.getElementById("entry_container").setAttribute("class", "tab-pane");
            document.getElementById("take_container").setAttribute("class", "tab-pane");

        };

        document.getElementById('take_products_id').onclick = function() {
            let c = localStorage.setItem('activaWarehouseTab', 'take_products');
            document.getElementById("entry_products_id").setAttribute("class", "nav-link");
            document.getElementById("take_products_id").setAttribute("class", "nav-link active");
            document.getElementById("entry_container_id").setAttribute("class", "nav-link");
            document.getElementById("take_container_id").setAttribute("class", "nav-link");
            document.getElementById("entry_products").setAttribute("class", "tab-pane");
            document.getElementById("take_products").setAttribute("class", "tab-pane active");
            document.getElementById("entry_container").setAttribute("class", "tab-pane");
            document.getElementById("take_container").setAttribute("class", "tab-pane");

        };
        document.getElementById('entry_container_id').onclick = function() {
            let c = localStorage.setItem('activaWarehouseTab', 'entry_container');
            document.getElementById("entry_products_id").setAttribute("class", "nav-link");
            document.getElementById("take_products_id").setAttribute("class", "nav-link");
            document.getElementById("entry_container_id").setAttribute("class", "nav-link active");
            document.getElementById("take_container_id").setAttribute("class", "nav-link");
            document.getElementById("entry_products").setAttribute("class", "tab-pane");
            document.getElementById("take_products").setAttribute("class", "tab-pane");
            document.getElementById("entry_container").setAttribute("class", "tab-pane active");
            document.getElementById("take_container").setAttribute("class", "tab-pane");

        };
        document.getElementById('take_container_id').onclick = function() {
            let c = localStorage.setItem('activaWarehouseTab', 'take_container');
            document.getElementById("entry_products_id").setAttribute("class", "nav-link");
            document.getElementById("take_products_id").setAttribute("class", "nav-link");
            document.getElementById("entry_container_id").setAttribute("class", "nav-link");
            document.getElementById("take_container_id").setAttribute("class", "nav-link active");
            document.getElementById("entry_products").setAttribute("class", "tab-pane");
            document.getElementById("take_products").setAttribute("class", "tab-pane");
            document.getElementById("entry_container").setAttribute("class", "tab-pane");
            document.getElementById("take_container").setAttribute("class", "tab-pane active");

        };
    </script>
    <script>
        function DeleteEntryProduct(id) {
            Swal.fire({
                title: "{{ __('messages.Do_you_want_to_delete') }} ?",
                text: 'asasaads',
                icon: "warning",
                showCancelButton: !0,
                cancelButtonText: "{{ __('messages.no') }}",
                confirmButtonColor: "#1c84ee",
                cancelButtonColor: "#fd625e",
                confirmButtonText: "{{ __('messages.Yes_delete') }} !"
            }).then(function(e) {
                if (e.isConfirmed) {
                    $.ajax({
                        url: "{{ route('delete_entry_product') }}",
                        method: "POST",
                        data: {
                            "_token": "{{ csrf_token() }}",
                            id: id
                        },
                        success: function(res) {
                            e.value && Swal.fire("{{ __('messages.deleted') }}!",
                                "{{ __('messages.success_removed') }}",
                                "success").then((result) => {
                                location.reload();
                            });

                        },
                        error: function(error) {
                            alertify.error(error.responseJSON.message);
                        }
                    });
                }

            })
        }
    </script>
    <script>
        function DeleteTakeProduct(id) {
            Swal.fire({
                title: "{{ __('messages.Do_you_want_to_delete') }} ?",
                text: 'asasaads',
                icon: "warning",
                showCancelButton: !0,
                cancelButtonText: "{{ __('messages.no') }}",
                confirmButtonColor: "#1c84ee",
                cancelButtonColor: "#fd625e",
                confirmButtonText: "{{ __('messages.Yes_delete') }} !"
            }).then(function(e) {
                if (e.isConfirmed) {
                    $.ajax({
                        url: "{{ route('take_delete_product') }}",
                        method: "POST",
                        data: {
                            "_token": "{{ csrf_token() }}",
                            id: id
                        },
                        success: function(res) {
                            e.value && Swal.fire("{{ __('messages.deleted') }}!",
                                "{{ __('messages.success_removed') }}",
                                "success").then((result) => {
                                location.reload();
                            });

                        },
                        error: function(error) {
                            alertify.error(error.responseJSON.message);
                        }
                    });
                }

            })
        }
    </script>
    <script>
        function DeleteEntryContainer(id) {
            Swal.fire({
                title: "{{ __('messages.Do_you_want_to_delete') }} ?",
                text: 'asasaads',
                icon: "warning",
                showCancelButton: !0,
                cancelButtonText: "{{ __('messages.no') }}",
                confirmButtonColor: "#1c84ee",
                cancelButtonColor: "#fd625e",
                confirmButtonText: "{{ __('messages.Yes_delete') }} !"
            }).then(function(e) {
                if (e.isConfirmed) {
                    $.ajax({
                        url: "{{ route('delete_entry_container') }}",
                        method: "POST",
                        data: {
                            "_token": "{{ csrf_token() }}",
                            id: id
                        },
                        success: function(res) {
                            e.value && Swal.fire("{{ __('messages.deleted') }}!",
                                "{{ __('messages.success_removed') }}",
                                "success").then((result) => {
                                location.reload();
                            });

                        },
                        error: function(error) {
                            alertify.error(error.responseJSON.message);
                        }
                    });
                }

            })
        }
    </script>
    <script>
        function DeleteTakeContainer(id) {
            Swal.fire({
                title: "{{ __('messages.Do_you_want_to_delete') }} ?",
                text: 'asasaads',
                icon: "warning",
                showCancelButton: !0,
                cancelButtonText: "{{ __('messages.no') }}",
                confirmButtonColor: "#1c84ee",
                cancelButtonColor: "#fd625e",
                confirmButtonText: "{{ __('messages.Yes_delete') }} !"
            }).then(function(e) {
                if (e.isConfirmed) {
                    $.ajax({
                        url: "{{ route('take_delete_container') }}",
                        method: "POST",
                        data: {
                            "_token": "{{ csrf_token() }}",
                            id: id
                        },
                        success: function(res) {
                            e.value && Swal.fire("{{ __('messages.deleted') }}!",
                                "{{ __('messages.success_removed') }}",
                                "success").then((result) => {
                                location.reload();
                            });

                        },
                        error: function(error) {
                            alertify.error(error.responseJSON.message);
                        }
                    });
                }

            })
        }
    </script>
@endsection
