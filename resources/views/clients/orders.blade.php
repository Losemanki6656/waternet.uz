@extends('layouts.v2_master')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">{{ __('messages.Orders') }}</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">{{ __('messages.home') }}</a></li>
                        <li class="breadcrumb-item active">{{ __('messages.Orders') }}</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>

    <div class="row  animate__animated animate__fadeIn">
        <div class="col-lg-3 col-md-6">
            <div class="card mb-0">
                <select class="form-control" data-trigger name="city_id" id="sity_select">
                    <option value="">{{ __('messages.select_region') }}</option>
                    @foreach ($sities as $sity)
                        <option value={{ $sity->id }} @if ($sity->id == request('city_id')) selected @endif>
                            {{ $sity->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="card mb-0">
                <select class="form-control" data-trigger name="area_id" id="area_select">
                    <option value="">{{ __('messages.select_city') }}</option>
                    @foreach ($areas as $area)
                        <option value={{ $area->id }} @if ($area->id == request('area_id')) selected @endif>
                            {{ $area->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <label class="col-form-label"> {{ __('messages.orders_count') }} <span
                    class="text-primary fw-bold">{{ $summ_order }};</span>
                {{ __('messages.client_count') }} - <span class="counter-value text-primary fw-bold"
                    data-target="{{ $orders->total() }}">0</span>
            </label>
        </div>
        <div class="col-lg-3 col-md-6">
            <form action="{{ route('orders') }}" method="get">
                @csrf
                <div class="input-group mb-3">
                    <input class="form-control" value="{{ request()->query('search') }}" name="search" type="search"
                        placeholder="{{ __('messages.search') }}" aria-label="Search" />
                </div>
            </form>
        </div>
    </div>
    @push('scripts')
        <script>
            $('#sity_select').change(function(e) {
                let city_id = $(this).val();
                let url = '{{ route('orders') }}';
                window.location.href = `${url}?city_id=${city_id}`;


            })

            $('#area_select').change(function(e) {
                let area_id = $(this).val();
                let city_id = $('#sity_select').val();
                let url = '{{ route('orders') }}';
                window.location.href = `${url}?city_id=${city_id}&area_id=${area_id}`;
            })
        </script>
    @endpush
    
    <div class="card">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-sm align-middle table-bordered table-nowrap animate__animated animate__fadeIn" id="table_order">
                    <thead class="table-light">
                        <tr>
                            <th class="text-center fw-bold"></th>
                            <th class="text-center" width="60">#</th>
                            <th class="text-center">{{ __('messages.fullname') }}</th>
                            <th class="text-center">{{ __('messages.phone') }}</th>
                            <th class="text-center">{{ __('messages.address') }} </th>
                            <th class="text-center">{{ __('messages.product') }}</th>
                            <th class="text-center">{{ __('messages.count') }}</th>
                            <th class="text-center">{{ __('messages.price') }}</th>
                            <th class="text-center">{{ __('messages.time') }}</th>
                            <th class="text-center">{{ __('messages.comment') }}</th>
                            <th class="text-center">{{ __('messages.user') }}</th>
                            <th class="text-center">{{ __('messages.action') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($orders as $order)
                            <tr class="row1" data-id="{{ $order->id }}">
                                <td class="text-center"><i class="fas fa-stream" style="color: blue; cursor: pointer"></i> </td>
                                <td class="text-center">{{ $orders->currentPage() * 10 - 10 + $loop->index + 1 }}</td>
                                <td class="text-center">{{ $order->client->fullname }}</td>
                                <td class="text-center">{{ $order->client->phone }}</td>
                                <td class="text-center">
                                    {{ $order->client->city->name ?? '' }},{{ $order->client->area->name ?? '' }}
                                    <span> <br> {{ $order->client->address ?? '' }}</span>
                                </td>
                                <td class="text-center">{{ $order->product->name ?? '' }}</td>
                                <td class="text-center">{{ $order->product_count ?? '' }}</td>
                                <td class="text-center">{{ $order->price }}</td>
                                <td class="text-center">{{ $order->created_at->format('Y-m-d') }}</td>
                                <td class="text-center">{{ $order->comment }}</td>
                                <td class="text-center">{{ $order->user->name }}</td>
                                <td class="align-middle text-center" width="120px">
                                    <a type="button" href="{{ route('success_order_view', ['id' => $order->id]) }}"
                                        class="btn btn-soft-success waves-effect waves-light" data-bs-toggle="tooltip"
                                        data-bs-placement="top" title="{{ __('messages.accept') }}">
                                        <i class="fa fa-check-circle"></i></a>

                                    <span data-bs-toggle="modal" data-bs-target="#orderedit{{ $order->id }}"
                                        aria-controls="offcanvasBottom">
                                        <button type="button" class="btn btn-soft-dark waves-effect waves-light"
                                            data-bs-toggle="tooltip" data-bs-placement="top"
                                            title="{{ __('messages.update') }}">
                                            <i class="fa fa-edit"></i></button>
                                    </span>

                                    <button type="button" class="btn btn-soft-danger waves-effect waves-light"
                                        onclick="DeleteOrder('{{ $order->client->fullname }}', {{ $order->id }})"
                                        data-bs-toggle="tooltip" data-bs-placement="top"
                                        title="{{ __('messages.delete') }}">
                                        <i class="fa fa-trash"></i></button>

                                </td>
                            </tr>
                            <div class="modal fade" id="orderedit{{ $order->id }}" tabindex="-1" role="dialog">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="myModalLabel">{{ __('messages.order_update') }}
                                            </h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <form action="{{ route('order_edit', ['id' => $order->id]) }}" method="post">
                                            @csrf
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <label class="mb-0">{{ __('messages.product') }}:</label>
                                                    <select class="form-select" id="prod_sel{{ $order->id }}"
                                                        name="product_id" onchange="onsel({{ $order->id }})" required>
                                                        @foreach ($products as $product)
                                                            <option data-amount="{{ $product->price }}"
                                                                @if ($order->product_id == $product->id) selected @endif
                                                                value={{ $product->id }}>{{ $product->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="row mb-3">
                                                    <div class="col">
                                                        <label class="mb-0">{{ __('messages.price') }}:</label>
                                                        <input class="form-control" type="text"
                                                            id="sena_product_order{{ $order->id }}" name="sena"
                                                            value="{{ $order->price }}" required>
                                                    </div>
                                                    <div class="col">
                                                        <label class="mb-0">{{ __('messages.count') }}:</label>
                                                        <input class="form-control" type="number"
                                                            value="{{ $order->product_count }}" name="count" required>
                                                    </div>
                                                </div>
                                                <div>
                                                    <label class="mb-0">{{ __('messages.comment') }}:</label>
                                                    <textarea class="form-control" name="izoh" id="" rows="2"></textarea>
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
            @if ($orders->total() > 10)
                <div class="row justify-content-between">
                    <div class="col-md-2">
                        <label class="mx-2">
                        </label>
                    </div>
                    <div class="col-md-8 text-center">
                        <label class="mb-0 p-0">{{ $orders->onEachSide(1)->withQueryString() }}</label>
                    </div>
                    <div class="col-md-2 text-end">
                        <label class="me-2">
                        </label>
                    </div>
                </div>
            @endif
        </div>

    </div>
@endsection

@section('scripts')
<script src="https://code.jquery.com/ui/1.13.1/jquery-ui.js"></script>
    <script>
        $("table tbody").sortable({

            update: function(event, ui) {
                var order = [];
                $('tr.row1').each(function(index, element) {
                    order.push({
                        id: $(this).attr('data-id'),
                        position: index + 1
                    });
                });
                console.log(order);
                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: "{{ url('orders/sortable') }}",
                    data: {
                        order: order,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        alertify.success(response.message);
                    }
                });
            }
        });
    </script>
    <script>
        function DeleteOrder(fullname, id) {
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
                        url: "{{ route('delete_Order') }}",
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
        function onsel(id) {
            if (document.getElementById("tolov-usuli" + id).value == 3) {
                var x = document.getElementById("sena" + id).value;
                var y = document.getElementById("count" + id).value;
                var z = x * y;
                $("#olinganpul" + id).val(z);
                $("#olinganpul" + id).attr('disabled', true);

            } else {

                var x = document.getElementById("sena" + id).value;
                var y = document.getElementById("count" + id).value;
                var z = x * y;
                $("#olinganpul" + id).val(z);
                $("#olinganpul" + id).attr('disabled', false);
            }
        }
    </script>>

    <script>
        function summa(id) {
            var x = document.getElementById("sena" + id).value;
            var y = document.getElementById("count" + id).value;
            var z = x * y;
            $("#olinganpul" + id).val(z);
        }
    </script>
@endsection
