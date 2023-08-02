@extends('layouts.v2_master')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">{{ __('messages.shop_balance_history') }}</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">{{ __('messages.home') }}</a></li>
                        <li class="breadcrumb-item active">{{ __('messages.shop_balance_history') }}</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>

    <div class="row">

        <div class="col-xl-3 col-md-6">
            <!-- card -->
            <div class="card card-h-100  rounded-4">
                <!-- card body -->
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <span class="text-muted mb-3 lh-1 d-block text-truncate">{{ __('messages.balance') }}</span>
                            <h4 class="mb-3">
                                <span class="counter-value" data-target="{{ $organization->balance }}">0</span> UZS
                            </h4>
                        </div>

                        <div class="flex-shrink-0 text-end">
                            <i class="fas fa-2x fa-dollar-sign text-success"></i>
                        </div>
                    </div>
                </div><!-- end card body -->
            </div><!-- end card -->
        </div><!-- end col -->

        <div class="col-xl-3 col-md-6">
            <!-- card -->
            <div class="card card-h-100  rounded-4">
                <!-- card body -->
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <span class="text-muted mb-3 lh-1 d-block text-truncate">{{ __('messages.director') }}</span>
                            <h4 class="mb-3">
                                {{ $organization->director_name }}
                            </h4>
                        </div>
                        <div class="flex-shrink-0 text-end">
                            <i class="fas fa-user fa-2x text-primary"></i>
                        </div>
                    </div>
                </div><!-- end card body -->
            </div><!-- end card -->
        </div><!-- end col-->

        <div class="col-xl-3 col-md-6">
            <!-- card -->
            <div class="card card-h-100 rounded-4">
                <!-- card body -->
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <span class="text-muted mb-3 lh-1 d-block text-truncate">{{ __('messages.phone') }}</span>
                            <h4 class="mb-3">
                                {{ $organization->phone }}
                            </h4>
                        </div>
                        <div class="flex-shrink-0 text-end">
                            <i class="fas fa-phone fa-2x text-danger"></i>
                        </div>
                    </div>
                </div><!-- end card body -->
            </div><!-- end card -->
        </div><!-- end col -->

        <div class="col-xl-3 col-md-6">
            <!-- card -->
            <div class="card card-h-100 rounded-4">
                <!-- card body -->
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <span class="text-muted mb-3 lh-1 d-block text-truncate">{{ __('messages.traffic') }}</span>
                            <h4 class="mb-3">
                                {{ $organization->traffic->name }}
                            </h4>
                        </div>
                        <div class="flex-shrink-0 text-end">
                            <i class="fas fa-tag fa-2x text-warning"></i>
                        </div>
                    </div>
                </div><!-- end card body -->
            </div><!-- end card -->
        </div><!-- end col -->
    </div>
    <button type="button" class="btn btn-primary mb-3 waves-effect waves-light" data-bs-toggle="modal"
        data-bs-target="#addprice">
        <i class="fa fa-plus-circle me-2"></i> {{ __('messages.add_price') }}
    </button>

    <div class="modal fade" id="addprice" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="title" id="defaultModalLabel">{{ __('messages.add_price') }}</h4>
                </div>
                <form action="{{ route('add_price_organization', ['id' => $organization->id]) }}" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label style="margin-bottom: 0">{{ __('messages.payment_type') }}:</label>
                            <select class="form-select" name="payment" required>
                                <option value="1">Naqd</option>
                                <option value="2">Plastik</option>
                                <option value="3">Pul ko'chirish</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label style="margin-bottom: 0">{{ __('messages.amount') }}:</label>
                            <input class="form-control" type="number" name="price" required>
                        </div>

                        <div class="mb-3">
                            <label style="margin-bottom: 0">{{ __('messages.comment') }}:</label>
                            <textarea class="form-control" type="text" name="comment" placeholder="Izoh..."> </textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-lg waves-effect waves-light"
                            data-bs-dismiss="modal">
                            <i class="fas fa-reply me-2"></i>
                            {{ __('messages.cancel') }}</button>
                        <button class="btn btn-primary btn-lg waves-effect waves-light" type="submit"> <i
                                class="fa fa-save me-2"></i>
                            {{ __('messages.save') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-body p-0">
            <div class="table-responsive animate__animated animate__fadeIn">
                <table class="table table-sm align-middle table-bordered table-nowrap">
                    <thead class="table-light">
                        <tr>
                            <th class="align-middle text-center">{{ __('messages.amount') }}</th>
                            <th class="align-middle text-center">{{ __('messages.payment_type') }}</th>
                            <th class="align-middle text-center">{{ __('messages.comment') }}</th>
                            <th class="align-middle text-center">{{ __('messages.date') }}</th>
                            <th class="align-middle text-center">{{ __('messages.action') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($priceorgan as $price)
                            <tr>

                                <td class="text-center">
                                    {{ $price->price }} UZS
                                </td>
                                <td class="text-center">
                                    @if ($price->payment == 1)
                                        <span class="badge bg-primary fs-7">{{ __('messages.cash') }}</span>
                                    @elseif ($price->payment == 2)
                                        <span class="badge bg-warning fs-7">{{ __('messages.card') }}</span>
                                    @else
                                        <span class="badge bg-success fs-7">{{ __('messages.transfer') }}</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    {{ $price->comment }}
                                </td>
                                <td class="text-center">
                                    {{ $price->created_at }}
                                </td>
                                <td class="text-center">
                                    @if ($priceorgan->count() == $loop->index + 1)
                                        <button type="button" class="btn btn-soft-dark waves-effect waves-light"
                                            data-bs-toggle="modal" data-bs-target="#editprice{{ $price->id }}"><i
                                                class="fas fa-edit"></i>
                                            <span></span></button>
                                        <button type="button" class="btn btn-soft-danger waves-effect waves-light"
                                            onclick="DeletePrice('{{ $price->price }}', {{ $price->id }})"><i
                                                class="fas fa-trash"></i>
                                            <span></span></button>
                                    @endif
                                </td>
                                <div class="modal fade" id="editprice{{ $price->id }}" tabindex="-1"
                                    role="dialog">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="title" id="defaultModalLabel">{{ __('messages.update') }}
                                                </h4>
                                            </div>
                                            <form action="{{ route('edit_price_organization', ['id' => $price->id]) }}"
                                                method="post">
                                                @csrf
                                                <div class="modal-body">
                                                    <div class="mb-3">
                                                        <label
                                                            style="margin-bottom: 0">{{ __('messages.payment_type') }}:</label>
                                                        <select class="form-select" name="payment" required>
                                                            <option value="1">Naqd</option>
                                                            <option value="2">Plastik</option>
                                                            <option value="3">Pul ko'chirish</option>
                                                        </select>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label
                                                            style="margin-bottom: 0">{{ __('messages.amount') }}:</label>
                                                        <input class="form-control" type="number"
                                                            value="{{ $price->price }}" name="price" required>
                                                    </div>

                                                    <div class="mb-3">
                                                        <label
                                                            style="margin-bottom: 0">{{ __('messages.comment') }}:</label>
                                                        <textarea class="form-control" type="text" value="{{ $price->comment }}" name="comment"> </textarea>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button"
                                                        class="btn btn-secondary btn-lg waves-effect waves-light"
                                                        data-bs-dismiss="modal">
                                                        <i class="fas fa-reply me-2"></i>
                                                        {{ __('messages.cancel') }}</button>
                                                    <button class="btn btn-primary btn-lg waves-effect waves-light"
                                                        type="submit"> <i class="fa fa-save me-2"></i>
                                                        {{ __('messages.save') }}</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <div class="modal fade" id="deleteprice{{ $price->id }}" tabindex="-1"
                                    role="dialog">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="title" id="defaultModalLabel">O'chirish</h4>
                                            </div>
                                            <form action="{{ route('delete_price_organization', ['id' => $price->id]) }}"
                                                method="post">
                                                @csrf
                                                <div class="modal-body">
                                                    <div class="mb-3">
                                                        <label style="margin-bottom: 0">O'chirishni xoxlaysizmi
                                                            ?</label>
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
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function DeletePrice(fullname, id) {
            Swal.fire({
                title: "{{ __('messages.Do_you_want_to_delete') }} ?",
                text: "{{ __('messages.amount') }}: " + fullname + " UZS",
                icon: "warning",
                showCancelButton: !0,
                cancelButtonText: "{{ __('messages.no') }}",
                confirmButtonColor: "#1c84ee",
                cancelButtonColor: "#fd625e",
                confirmButtonText: "{{ __('messages.Yes_delete') }} !"
            }).then(function(e) {
                if (e.isConfirmed) {
                    $.ajax({
                        url: "{{ route('delete_price_organization') }}",
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
