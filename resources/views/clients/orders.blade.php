@extends('layouts.master')
@section('content')
    <div class="container-fluid">
        <div class="block-header">
            <div class="row">
                <div class="col-lg-5 col-md-8 col-sm-12">
                    <h2>Mijozlar</h2>
                </div>
                <div class="col-lg-7 col-md-4 col-sm-12 text-right">
                    <ul class="breadcrumb justify-content-end">
                        <li class="breadcrumb-item"><a href=""><i class="icon-home"></i></a></li>
                        <li class="breadcrumb-item active">Mijozlar</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="header">
                <div class="row clearfix">
                    <div class="col-lg-3 col-md-6">
                        <select class="form-control show-tick ms select2" id="sity_select"
                            data-placeholder="Regionni tanlang ... ">
                            <option value=""></option>
                            @foreach ($sities as $sity)
                                <option value={{ $sity->id }} @if ($sity->id == request('city_id')) selected @endif>
                                    {{ $sity->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <select class="form-control show-tick ms select2" id="area_select"
                            data-placeholder="Shaharni tanlang ... ">
                            <option value=""></option>
                            @foreach ($areas as $area)
                                <option value={{ $area->id }} @if ($area->id == request('area_id')) selected @endif>
                                    {{ $area->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-lg-3 col-md-6">
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <form action="{{ route('orders') }}" method="get">
                            @csrf
                            <div class="input-group mb-3">
                                <input class="form-control" value="{{ request()->query('search') }}" name="search"
                                    type="search" placeholder="Qidirish ..." aria-label="Search" />
                            </div>
                        </form>
                    </div>
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

            <div class="body">
                <div class="table-responsive">
                    <table class="table m-b-0 table-bordered table-sm">
                        <thead>
                            <tr>
                                <th width="60">#</th>
                                <th>FIO</th>
                                <th>Tel raqami</th>
                                <th>Manzil </th>
                                <th>Tovar nomi</th>
                                <th>Miqdori</th>
                                <th>Narxi</th>
                                <th>Vaqti</th>
                                <th>Izoh</th>
                                <th>Operator</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($orders as $order)
                                <tr>
                                    <td>{{ $orders->currentPage() * 10 - 10 + $loop->index + 1 }}</td>
                                    <td>{{ $order->client->fullname }}</td>
                                    <td>{{ $order->client->phone }}</td>
                                    <td class="text-center">
                                        {{ $order->client->city->name ?? '' }},{{ $order->client->area->name ?? '' }}
                                        <span> <br> {{ $order->client->address ?? '' }}</span>
                                    </td>
                                    <td>{{ $order->product->name }}</td>
                                    <td>{{ $order->product_count }}</td>
                                    <td>{{ $order->price }}</td>
                                    <td>{{ $order->created_at->format('Y-m-d') }}</td>
                                    <td>{{ $order->comment }}</td>
                                    <td>{{ $order->user->name }}</td>
                                    <td class="align-middle text-center">
                                        @if ($order->client->location != '0')
                                            <a type="button" target="_blank"
                                                href="{{ route('view_location', ['id' => $order->client->id]) }}"
                                                class="btn btn-warning">
                                                <i class="fa fa-map-marker"></i> <span></span></a>
                                        @else
                                            <button type="button" class="btn btn-outline-warning" disabled>
                                                <i class="fa fa-map-marker"></i> <span></span></button>
                                        @endif
                                        <a href="{{ route('success_order_view', ['id' => $order->id]) }}" type="button"
                                            class="btn btn-success"><i class="fa fa-check-circle"></i> <span></span></a>

                                        <button type="button" class="btn btn-dark" data-toggle="modal"
                                        title="Zakasni taxrirlash" data-target="#orderedit{{ $order->id }}"><i class="fa fa-edit"></i>
                                            <span></span></button>
                                        <button type="button" class="btn btn-danger" data-toggle="modal"
                                        title="Zakasni o'chirish" data-target="#deleteorder{{ $order->id }}"><i class="fa fa-trash"></i>
                                            <span></span></button>
                                    </td>
                                </tr>
                                <div class="modal fade" id="orderedit{{ $order->id }}" tabindex="-1" role="dialog">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="title" id="defaultModalLabel">Zakazni taxrirlash</h4>
                                            </div>
                                            <form action="{{ route('order_edit', ['id' => $order->id]) }}" method="post">
                                                @csrf
                                                <div class="modal-body">
                                                    <div class="form-group">
                                                        <h6><label>Tovar nomi:</label></h6>
                                                        <select class="form-control show-tick select2"
                                                            id="prod_sel{{ $order->id }}" name="product_id"
                                                            onchange="onsel({{ $order->id }})" required>
                                                            @foreach ($products as $product)
                                                                <option data-amount="{{ $product->price }}"
                                                                    @if ($order->product_id == $product->id) selected @endif
                                                                    value={{ $product->id }}>{{ $product->name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <h6><label>Narxi:</label></h6>
                                                        <input class="form-control" type="text"
                                                            id="sena_product_order{{ $order->id }}" name="sena"
                                                            value="{{ $order->price }}" required>
                                                    </div>
                                                    <div class="form-group">
                                                        <h6><label>Soni:</label></h6>
                                                        <input class="form-control" type="number"
                                                            value="{{ $order->product_count }}" name="count" required>
                                                    </div>
                                                    <div class="form-group">
                                                        <h6><label>Izoh:</label></h6>
                                                        <textarea class="form-control" name="izoh" id="" rows="2"></textarea>
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
                                <div class="modal fade" id="deleteorder{{ $order->id }}" tabindex="-1"
                                    role="dialog">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="title" id="defaultModalLabel">O'chirish</h4>
                                            </div>
                                            <form action="{{ route('delete_Order', ['id' => $order->id]) }}"
                                                method="post">
                                                @csrf
                                                <div class="modal-body">
                                                    <h6><label class="fw-bold text-danger">{{ $order->client->fullname }} </label> zakasini o'chirmoqchimisz ?</h6>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-dismiss="modal"> Chiqish</button>
                                                    <button class="btn btn-danger" type="submit">Xa, O'chirish</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal fade" id="success{{ $order->id }}" tabindex="-1" role="dialog">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="title" id="defaultModalLabel">Zakazni yetqazish</h5>
                                            </div>
                                            <form action="{{ route('success_order', ['id' => $order->id]) }}"
                                                method="post" enctype="multipart/form-data">
                                                @csrf
                                                <div class="modal-body">

                                                    <div class="card top_report">
                                                        <div class="row">
                                                            <div class="col-lg-6 col-md-6 col-sm-6">
                                                                <div class="body">
                                                                    <div class="clearfix">
                                                                        <div class="float-left">
                                                                            <i class="fa fa-2x fa-dollar text-col-blue"></i>
                                                                        </div>
                                                                        <div class="number float-right text-right">
                                                                            <h6>Mijoz balansi:</h6>
                                                                            <span
                                                                                class="font700">{{ $order->client->balance }}</span>
                                                                        </div>
                                                                    </div>
                                                                    <div
                                                                        class="progress progress-xs progress-transparent custom-color-blue mb-0 mt-3">
                                                                        <div class="progress-bar" data-transitiongoal="28">
                                                                        </div>
                                                                    </div>
                                                                    <h6><small
                                                                            class="text-muted">{{ $order->client->fullname }}</small>
                                                                    </h6>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6 col-md-6 col-sm-6">
                                                                <div class="body">
                                                                    <div class="clearfix">
                                                                        <div class="float-left">
                                                                            <i
                                                                                class="fa fa-2x fa-shopping-cart text-col-red"></i>
                                                                        </div>
                                                                        <div class="number float-right text-right">
                                                                            <h6>Tovar soni:</h6>
                                                                            <span
                                                                                class="font700">{{ $order->product_count }}</span>
                                                                        </div>
                                                                    </div>
                                                                    <div
                                                                        class="progress progress-xs progress-transparent custom-color-red mb-0 mt-3">
                                                                        <div class="progress-bar" data-transitiongoal="41">
                                                                        </div>
                                                                    </div>
                                                                    <h6><small
                                                                            class="text-muted">{{ $order->product->name }}</small>
                                                                    </h6>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <div class="row">
                                                            <div class="col-lg-4 col-md-6">
                                                                <h6><label>Zakaz holati:</label></h6>
                                                                <select class="form-control" name="order_status"
                                                                    id="order-stat">
                                                                    <option value="1">Yetqazildi</option>
                                                                    <option value="2">Olib ketildi</option>
                                                                    <option value="3">Bekor qilindi</option>
                                                                    <option value="4">Manzil topilmadi</option>
                                                                    <option value="5">Manzilda xech kim yo'q</option>
                                                                </select>
                                                            </div>
                                                            <div class="col-lg-4 col-md-6">
                                                                <h6><label>Yetqazildi:</label></h6>
                                                                <input class="form-control" type="number"
                                                                    onchange="summa({{ $order->id }})" name="count"
                                                                    id="count{{ $order->id }}" value="0"
                                                                    required>
                                                            </div>
                                                            <div class="col-lg-4 col-md-6">
                                                                <h6><label>Narxi:</label></h6>
                                                                <input class="form-control" type="number"
                                                                    onchange="summa({{ $order->id }})" name="sena"
                                                                    id="sena{{ $order->id }}" value="0" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @if ($order->container_status == 0)
                                                        <div class="form-group">
                                                            <div class="row">
                                                                <div class="col-lg-6 col-md-6">
                                                                    <h6><label>Qaytargan idish soni:</label></h6>
                                                                    <input class="form-control" type="number"
                                                                        name="idish" id="idish{{ $order->id }}"
                                                                        value="0" required>
                                                                </div>
                                                                <div class="col-lg-6 col-md-6">
                                                                    <h6><label>Yaroqsiz idish soni:</label></h6>
                                                                    <input class="form-control" type="number"
                                                                        name="yaroqsiz_idish"
                                                                        id="yaroqsiz_idish{{ $order->id }}"
                                                                        value="0" required>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endif
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <div class="col-lg-6 col-md-6">
                                                                <h6><label>To'lov ususli:</label></h6>
                                                                <select class="form-control" name="tolov_usuli"
                                                                    onchange="onsel({{ $order->id }})"
                                                                    id="tolov-usuli{{ $order->id }}">
                                                                    <option value="1">Naqd</option>
                                                                    <option value="2">Plastik</option>
                                                                    <option value="3">Pul ko'chirish</option>
                                                                </select>
                                                            </div>
                                                            <div class="col-lg-6 col-md-6">
                                                                <h6><label>To'lov summasi:</label></h6>
                                                                <input class="form-control" type="number"
                                                                    name="olinganpul" id="olinganpul{{ $order->id }}"
                                                                    value="0" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <textarea name="izoh" rows="2" class="form-control" name="izoh" placeholder="Izoh..."></textarea>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-danger" data-dismiss="modal">
                                                        Chiqish</button>
                                                    <button class="btn btn-primary" type="submit"><i
                                                            class="fa fa-save"></i> Saqlash</button>
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
                        {{ $orders->withQueryString()->links() }}
                    </ul>
                </div>
            </div>

        </div>
    </div>
@endsection

@section('scripts')
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
