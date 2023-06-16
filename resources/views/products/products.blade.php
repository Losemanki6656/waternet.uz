@extends('layouts.v2_master')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">{{ __('messages.Products') }}</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">{{ __('messages.home') }}</a></li>
                        <li class="breadcrumb-item active">{{ __('messages.Products') }}</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>

    <div class="header mb-3">
        <button type="button" class="btn btn-primary btn-lg waves-effect waves-light" data-bs-toggle="modal"
            data-bs-target="#addtask">
            <i class="fa fa-plus-circle"></i> {{ __('messages.add_product') }}
        </button>

        <div class="modal fade" id="addtask" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="myModalLabel">{{ __('messages.add_product') }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('add_product') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-body">
                            <div class="mb-3">
                                <label class="mb-0">{{ __('messages.product_name') }}:</label>
                                <input class="form-control" type="text" name="name" placeholder="Tovar nomi..."
                                    required>
                            </div>
                            <div class="row mb-3">
                                <div class="col">
                                    <label class="mb-0">{{ __('messages.product_type') }}:</label>
                                    <select class="form-select" name="idish_status">
                                        <option value="0">Idish qaytadi</option>
                                        <option value="1">Idish qaytmaydi</option>
                                    </select>
                                </div>
                                <div class="col">
                                    <label class="mb-0">{{ __('messages.price') }}:</label>
                                    <input class="form-control" type="text" name="sena"
                                        placeholder="{{ __('messages.price') }}" required>
                                </div>
                            </div>
                            <input class="form-control" type="hidden" name="count" value="0"
                                placeholder="{{ __('messages.count') }}" required>
                            <div class="mb-3">
                                <label class="mb-0">{{ __('messages.photo') }}:</label>
                                <input class="form-control" type="file" name="photo">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary btn-lg waves-effect waves-light"
                                data-bs-dismiss="modal"> <i class="fas fa-reply me-2"></i>
                                {{ __('messages.cancel') }}</button>
                            <button class="btn btn-success btn-lg waves-effect waves-light" type="submit"> <i
                                    class="fa fa-save me-2"></i>
                                {{ __('messages.save') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-8">
            <div class="card rounded-4">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table align-middle mb-0 table-nowrap">
                            <thead class="table-light">
                                <tr>
                                    <th>{{ __('messages.photo') }}</th>
                                    <th>{{ __('messages.product') }}</th>
                                    <th>{{ __('messages.price') }}</th>
                                    <th>{{ __('messages.count') }}</th>
                                    <th>{{ __('messages.container') }}</th>
                                    <th>{{ __('messages.action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($products as $product)
                                    <tr>
                                        <td>
                                            <img src="{{ asset('assets/images/product.jpg') }}"
                                                class="img-fluid rounded-circle avatar-md" alt="product-img"
                                                title="product-img" />
                                        </td>
                                        <td>
                                            <h6 class="text-truncate">{{ $product->name }}</h6>
                                        </td>
                                        <td>
                                            <h6>{{ $product->price }}</h6>
                                        </td>
                                        <td>
                                            <h6> {{ $product->product_count }}</h6>
                                        </td>
                                        <td>
                                            <h6>{{ $product->container }}</h6>
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-dark btn-lg waves-effect waves-light"
                                                data-bs-toggle="modal" data-bs-target="#edit{{ $product->id }}">
                                                <i class="fa fa-edit"></i> {{ __('messages.update') }}
                                            </button>
                                            <button type="button" class="btn btn-danger btn-lg waves-effect waves-light"
                                                onclick="DeleteProduct('{{ $product->name }}', {{ $product->id }})">
                                                <i class="fa fa-save"></i> {{ __('messages.delete') }}
                                            </button>
                                        </td>
                                    </tr>
                                    <div class="modal fade" id="edit{{ $product->id }}" tabindex="-1" role="dialog">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="myModalLabel">
                                                        {{ __('messages.update_product') }}</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <form action="{{ route('edit_product', ['id' => $product->id]) }}"
                                                    method="post" enctype="multipart/form-data">
                                                    @csrf
                                                    <div class="modal-body">
                                                        <div class="mb-3">
                                                            <label
                                                                class="mb-0">{{ __('messages.product_name') }}:</label>
                                                            <input class="form-control" type="text" name="name"
                                                                value="{{ $product->name }}" required>
                                                        </div>
                                                        <div class="row mb-3">
                                                            <div class="col">
                                                                <label class="mb-0">{{ __('messages.price') }}:</label>
                                                                <input class="form-control" type="number" name="price"
                                                                    value="{{ $product->price }}" required>
                                                            </div>
                                                            <div class="col">
                                                                <label
                                                                    class="mb-0">{{ __('messages.product_type') }}:</label>
                                                                <select class="form-select" name="container_status">
                                                                    <option value="0"
                                                                        @if ($product->container_status == 0) selected @endif>
                                                                        Idish
                                                                        qaytadi</option>
                                                                    <option value="1"
                                                                        @if ($product->container_status == 1) selected @endif>
                                                                        Idish qaytmaydi</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="mb-0">{{ __('messages.photo') }}:</label>
                                                            <input class="form-control" type="file" name="photo">
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
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function DeleteProduct(fullname, id) {
            Swal.fire({
                title: "{{ __('messages.Do_you_want_to_delete') }} ?",
                text: fullname,
                icon: "warning",
                showCancelButton: !0,
                cancelButtonText: "{{ __('messages.no') }}",
                confirmButtonColor: "#1c84ee",
                cancelButtonColor: "#fd625e",
                confirmButtonText: "{{ __('messages.Yes_delete') }} !"
            }).then(function(e) {
                if (e.isConfirmed) {
                    $.ajax({
                        url: "{{ route('delete_product') }}",
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
@endpush
