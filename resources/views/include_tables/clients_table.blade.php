@if ($clients->count())
    <div class="table-responsive animate__animated animate__fadeIn" style="min-height: 230px">
        <table class="table table-sm align-middle table-bordered table-nowrap table-check">
            <thead class="table-light">
                <tr>
                    <th style="width: 30px;" class="align-middle text-center">
                        <div class="form-check font-size-16 text-center">
                            <input class="form-check-input" type="checkbox" id="checkAll" name="checkbox"
                                style="float: none">
                        </div>
                    </th>
                    <th class="fw-bold text-center">#</th>
                    <th class="text-center">{{ __('messages.fullname') }}</th>
                    <th class="align-middle text-center">{{ __('messages.phone') }}</th>
                    <th class="align-middle text-center">{{ __('messages.address') }}</th>
                    <th class="align-middle text-center">{{ __('messages.balance') }}</th>
                    <th class="align-middle text-center">{{ __('messages.container') }}</th>
                    <th class="align-middle text-center">{{ __('messages.active') }}</th>
                    <th class="align-middle text-center">{{ __('messages.action') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($clients as $client)
                    <tr>
                        <td class="text-center">
                            <div class="form-check font-size-16 text-center">
                                <input class="form-check-input" type="checkbox" style="float: none"
                                    form="order_all_form" name="checkbox[{{ $client->id }}]">
                            </div>
                        </td>
                        <td class="text-center">
                            {{ $clients->currentPage() * $clients->perPage() - $clients->perPage() + $loop->index + 1 }}</a>
                        </td>
                        <td class="text-center">{{ $client->fullname }}</td>
                        <td class="text-center">
                            <strong>{{ $client->phone }}</strong>
                            @if ($client->phone2)
                                <br><span class="text-muted">{{ $client->phone2 }}</span>
                            @endif
                        </td>
                        <td class="text-center">
                            <h6 class="margin-0">
                                @if ($client->street != ' ')
                                    {{ $client->street }},
                                @endif
                                @if ($client->home_number != ' ')
                                    {{ $client->home_number }},
                                @endif
                                @if ($client->entrance != ' ')
                                    {{ $client->entrance }},
                                @endif
                                @if ($client->floor != ' ')
                                    {{ $client->floor }},
                                @endif
                                @if ($client->apartment_number != ' ')
                                    {{ $client->apartment_number }}
                                @endif
                                @if ($client->address != ' ')
                                    {{ $client->address }}
                                @endif
                            </h6>
                            <span class="text-muted">
                                @if ($client->city)
                                    {{ $client->city->name }},
                                @endif
                                @if ($client->area)
                                    {{ $client->area->name }}
                                @endif
                            </span>
                        </td>
                        <td class="text-center">{{ $client->balance }}</td>
                        <td class="text-center">{{ $client->container }}</td>
                        <td class="text-center" width="100px">
                            @if ($client->activated_at->diffInDays() > 14)
                                <button type="button" class="btn btn-soft-danger waves-effect waves-light btn-sm"
                                    data-bs-toggle="tooltip" data-bs-placement="top"
                                    title="{{ $client->activated_at->diffInDays() + 1 }} kun davomida aktiv emas">
                                    {{ $client->activated_at->format('d-m-Y') }}</button>
                            @else
                                @if ($client->activated_at->diffInDays() >= 7 && $client->activated_at->diffInDays() <= 14)
                                    <button type="button" class="btn btn-soft-warning waves-effect waves-light btn-sm"
                                        data-bs-toggle="tooltip" data-bs-placement="top"
                                        title="{{ $client->activated_at->diffInDays() + 1 }} kun davomida aktiv emas">
                                        {{ $client->activated_at->format('d-m-Y') }}</button>
                                @else
                                    <button type="button" class="btn btn-soft-success waves-effect waves-light btn-sm"
                                        data-bs-toggle="tooltip" data-bs-placement="top"
                                        title="{{ $client->activated_at->diffInDays() + 1 }} kun davomida aktiv emas">
                                        {{ $client->activated_at->format('d-m-Y') }}</button>
                                @endif
                            @endif

                        </td>
                        <td class="text-center" width="150px">
                            @if ($client->location != '0')
                                <span
                                    onclick="showLocation('{{ $client->location }}', '{{ $client->fullname }}',{{ $client->id }})">
                                    <button type="button" class="btn btn-soft-warning waves-effect waves-light"
                                        data-bs-toggle="tooltip" data-bs-placement="top"
                                        title="{{ __('messages.view_location') }}">
                                        <i class="fa fa-map-marker"></i>
                                    </button>
                                </span>
                            @else
                                <a class="btn btn-soft-secondary waves-effect waves-light" href="#"
                                    onclick="showLocation('{{ $client->location }}', '{{ $client->fullname }}',{{ $client->id }})"
                                    data-bs-toggle="tooltip" data-bs-placement="top"
                                    title="{{ __('messages.add_location') }}"><i class="fa fa-map-marker"></i></a>
                            @endif

                            <button type="button" class="btn btn-soft-success waves-effect waves-light"
                                id="orderButton{{ $client->id }}" onclick="showModal({{ $client->id }})"
                                @if ($client->orders->count()) disabled @endif><i
                                    class="fa fa-shopping-cart"></i></button>

                            <div class="btn-group dropstart">
                                <button type="button" class="btn btn-soft-primary waves-effect waves-light"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="bx bx-smile font-size-16 align-middle"></i></button>

                                <div class="dropdown-menu dropdownmenu-primary">
                                    <a class="dropdown-item" href="#"
                                        data-bs-target="#clietnprice{{ $client->id }}" data-bs-toggle="modal"><i
                                            class="fa fa-credit-card me-2 text-success"></i>
                                        {{ __('messages.add_amount') }}</a>
                                    <a class="dropdown-item" href="#"
                                        data-bs-target="#container{{ $client->id }}" data-bs-toggle="modal"><i
                                            class="fa fa-download me-2 text-dark"></i>
                                        {{ __('messages.back_container') }}</a>
                                    <a class="dropdown-item"
                                        href="{{ route('soldproducts', ['id' => $client->id]) }}"><i
                                            class="fa fa-cube me-2 text-info"></i>
                                        {{ __('messages.result') }}</a>
                                    <a class="dropdown-item" href="#" data-bs-toggle="offcanvas"
                                        data-bs-target="#update{{ $client->id }}" aria-controls="offcanvasBottom"><i
                                            class="fa fa-edit me-2"></i>
                                        {{ __('messages.update') }}</a>

                                    <a class="dropdown-item" href="#" class="text-danger"
                                        onclick="DeleteClient('{{ $client->fullname }}', {{ $client->id }})"><i
                                            class="fa fa-trash me-2 text-danger"></i>
                                        {{ __('messages.delete') }}</a>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <div id="container{{ $client->id }}" class="modal fade" tabindex="-1"
                        aria-labelledby="myModalLabel" aria-hidden="true" data-bs-scroll="true">
                        <div class="modal-dialog modal-dialog-centered modal-rounded">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="myModalLabel">
                                        {{ __('messages.returned_containers') }}</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <form action="{{ route('client_container', ['id' => $client->id]) }}" method="post">
                                    @csrf
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label for="tolov-usuli">{{ __('messages.product_name') }}:</label>
                                            <select class="form-select" name="product_id" id="tolov-usuli" required>
                                                <option value="">Tanlanmadi</option>
                                                @foreach ($products as $product)
                                                    <option value="{{ $product->id }}">
                                                        {{ $product->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="row mb-3">
                                            <div class="col">
                                                <label>{{ __('messages.returned_containers_count') }}:</label>
                                                <input class="form-control" type="number" name="count"
                                                    value="0" required>
                                            </div>
                                            <div class="col">
                                                <label>{{ __('messages.unusable_containers') }}:</label>
                                                <input class="form-control" type="number" name="invalid_count"
                                                    value="0" required>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <h6><label>{{ __('messages.comment') }}:</label></h6>
                                            <textarea class="form-control" name="comment" id="" rows="2"></textarea>
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

                    <div id="clietnprice{{ $client->id }}" class="modal fade" tabindex="-1"
                        aria-labelledby="myModalLabel" aria-hidden="true" data-bs-scroll="true">
                        <div class="modal-dialog modal-dialog-centered modal-rounded">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="myModalLabel">{{ __('messages.add_price') }}</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <form action="{{ route('client_price', ['id' => $client->id]) }}" method="post">
                                    @csrf
                                    <div class="modal-body">

                                        <div class="row mb-3">
                                            <div class="col"><label>{{ __('messages.payment_type') }}:</label>
                                                <select class="form-select" name="payment" id="tolov-usuli">
                                                    <option value="1">Naqd</option>
                                                    <option value="2">Plastik</option>
                                                    <option value="3">Pul ko'chirish</option>
                                                </select>
                                            </div>
                                            <div class="col"><label>{{ __('messages.amount') }}:</label>
                                                <input class="form-control" type="input" name="amount"
                                                    placeholder="Summa ..." required>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label>{{ __('messages.comment') }}:</label>
                                            <textarea class="form-control" name="comment" id="" rows="2"></textarea>
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

                    <div class="offcanvas offcanvas-bottom" tabindex="-1" id="update{{ $client->id }}"
                        aria-labelledby="offcanvasBottomLabel" style="height: 400px">
                        <div class="offcanvas-header">
                            <h5 id="offcanvasBottomLabel">{{ __('messages.edit_client') }}</h5>
                            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                                aria-label="Close"></button>
                        </div>
                        <div class="offcanvas-body">
                            <form action="{{ route('client_edit', ['id' => $client->id]) }}" method="post">
                                @csrf
                                <div class="row mb-3">
                                    <div class="col">
                                        <label class="mb-0">{{ __('messages.fullname') }}:</label>
                                        <input class="form-control" type="input" value="{{ $client->fullname }}"
                                            name="fullname" required>
                                    </div>
                                    <div class="col">
                                        <label class="mb-0">{{ __('messages.select_region') }}:</label>
                                        <select class="form-select" name="city_id"
                                            id="edit_region_id{{ $client->id }}"
                                            onchange="changeRegion({{ $client->id }})">
                                            <option value="">--{{ __('messages.select_region') }}-- </option>
                                            @foreach ($sities as $city)
                                                <option value="{{ $city->id }}"
                                                    @if ($city->id == $client->city_id) selected @endif>
                                                    {{ $city->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col">
                                        <label class="mb-0">{{ __('messages.select_city') }}:</label>
                                        <select class="form-select" name="area_id"
                                            id="edit_area_id{{ $client->id }}">
                                            <option value="{{ $client->area_id }}">{{ $client->area->name }}
                                            </option>
                                        </select>
                                    </div>

                                </div>

                                <div class="row mb-3">
                                    <div class="col">
                                        <label class="mb-0">{{ __('messages.street') }}:</label>
                                        <input class="form-control" type="input" value="{{ $client->street }}"
                                            name="street">
                                    </div>
                                    <div class="col">
                                        <label class="mb-0">{{ __('messages.home_number') }}:</label>
                                        <input class="form-control" type="input"
                                            value="{{ $client->home_number }}" name="home_number">
                                    </div>
                                    <div class="col">
                                        <label class="mb-0">{{ __('messages.apartment_number') }}:</label>
                                        <input class="form-control" type="input"
                                            value="{{ $client->apartment_number }}" name="apartment_number">
                                    </div>
                                    <div class="col">
                                        <label class="mb-0">{{ __('messages.entrance') }}:</label>
                                        <input class="form-control" type="input" value="{{ $client->entrance }}"
                                            name="entrance">
                                    </div>
                                    <div class="col">
                                        <label class="mb-0">{{ __('messages.floor') }}:</label>
                                        <input class="form-control" type="input" value="{{ $client->floor }}"
                                            name="floor">
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col">
                                        <label class="mb-0">{{ __('messages.phone') }}:</label>
                                        <input class="form-control phone-number" type="input"
                                            value="{{ $client->phone }}" name="phone" id="phone" required>
                                    </div>
                                    <div class="col">
                                        <label class="mb-0">{{ __('messages.phone') }}2:</label>
                                        <input class="form-control phone-number" type="input"
                                            value="{{ $client->phone2 }}" name="phone2" id="phone2">
                                    </div>
                                    <div class="col">
                                        <label class="mb-0">{{ __('messages.login') }}:</label>
                                        <input class="form-control" type="input" value="{{ $client->login }}"
                                            name="login" required>
                                    </div>
                                    <div class="col">
                                        <label class="mb-0">{{ __('messages.password') }}:</label>
                                        <input class="form-control" type="input" value="{{ $client->password }}"
                                            name="password" required>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col">
                                        <label class="mb-0">{{ __('messages.comment') }}:</label>
                                        <input class="form-control" name="address" id=""
                                            value="{{ $client->address }}">
                                    </div>
                                    <div class="col">
                                        <button type="button" class="btn btn-warning"
                                            onclick="setlocation(event,{{ $client->id }})"
                                            id="select_location{{ $client->id }}" style="margin-top: 20px">
                                            <i class="fa fa-map-marker"></i>
                                            {{ __('messages.add_location') }}</button>
                                        <input type="hidden" onchange="dotReplace(event)" value="0"
                                            class="form-control" id="location{{ $client->id }}" name="location">
                                    </div>
                                    <div class="col text-end">

                                        <button type="button"
                                            class="btn btn-secondary btn-lg waves-effect waves-light"
                                            data-bs-dismiss="offcanvas" style="margin-top: 20px"> <i
                                                class="fas fa-reply me-2"></i>
                                            {{ __('messages.cancel') }}</button>
                                        <button class="btn btn-success btn-lg waves-effect waves-light" type="submit"
                                            style="margin-top: 20px"> <i class="fa fa-save me-2"></i>
                                            {{ __('messages.save') }}</button>
                                    </div>

                                </div>
                            </form>
                        </div>
                    </div>
                @endforeach

            </tbody>
        </table>
    </div>

    <div id="Neworder" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true"
        data-bs-scroll="true">
        <div class="modal-dialog modal-dialog-centered modal-rounded">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel">{{ __('messages.take_order') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label>{{ __('messages.product_name') }}:</label>
                        <select class="form-select" id="prod_sel_new_order" onchange="onsel()" required>
                            @foreach ($products as $product)
                                <option data-amount="{{ $product->price }}" value={{ $product->id }}>
                                    {{ $product->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="row mb-3">
                        <div class="col">
                            <label>{{ __('messages.amount') }}:</label>
                            <input class="form-control" type="text" id="sena_product_order"
                                @if ($products->count()) value="{{ $products[0]->price }}" @endif required>
                        </div>
                        <div class="col">
                            <label>{{ __('messages.count') }}:</label>
                            <input class="form-control" type="number" id="orderCount" value="1"
                                name="count" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label>{{ __('messages.comment') }}:</label>
                        <textarea class="form-control" name="izoh" id="orderComment" rows="2"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-lg waves-effect waves-light"
                        data-bs-dismiss="modal"> <i class="fas fa-reply me-2"></i>
                        {{ __('messages.cancel') }}</button>
                    <button class="btn btn-success btn-lg waves-effect waves-light" type="button"
                        onclick="TakeOrder()"> <i class="fa fa-save me-2"></i>
                        {{ __('messages.save') }}</button>
                </div>
            </div>
        </div>
    </div>

    <div class="offcanvas offcanvas-bottom" tabindex="-1" id="viewLocation" aria-labelledby="offcanvasBottomLabel"
        style="height: 400px">
        <div class="offcanvas-body">
            <div class="row row-cols-auto mb-2">
                <label for="horizontal-firstname-input" id="locationLabel" class="col col-form-label"></label>
                <div class="col-4">
                    <input type="text" class="form-control" id="locationInput" readonly>
                </div>
                <div class="col">
                    <button class="btn btn-warning waves-effect waves-light" onclick="addLocation()" type="button">
                        {{ __('messages.update_location') }}</button>
                </div>
            </div>
            <div id="map" style="width: 100%; height: 85%;">
            </div>
        </div>
    </div>
@else
    <h6 for="" class="text-center align-middle mt-3"> NO INFO </h6>
@endif

@push('scripts')
    <script>
        function addLocation() {
            let location = $('#locationInput').val();
            let id = localStorage.getItem('client');

            let url = '{{ route('update_location') }}';
            window.location.href =
                `${url}?client_id=${id}&location=${location}`;
        }
    </script>
    <script>
        function showLocation(location, fullname, id) {
            localStorage.setItem('client', id);
            var myOffcanvas = document.getElementById('viewLocation');
            var bsOffcanvas = new bootstrap.Offcanvas(myOffcanvas);
            bsOffcanvas.show();

            if (location.length > 3) {
                const myArray = location.split(",");

                var map = window.map;
                map.removeLayer(marker);
                marker = L.marker([myArray[0], myArray[1]]).addTo(map)
                    .bindPopup(fullname)
                    .openPopup();

                map.setView(new L.LatLng(myArray[0], myArray[1]), 15);

                $('#locationLabel').html(fullname);

                map.on('click', function(ev) {
                    marker.setLatLng(ev.latlng);
                    var latlng = map.mouseEventToLatLng(ev.originalEvent);
                    $('#locationInput').val(latlng.lat + ', ' + latlng.lng);
                });

            } else {

                var map = window.map;
                map.removeLayer(marker);
                marker = L.marker([39.7706790971256, 64.4232798737373]).addTo(map)
                    .bindPopup(fullname)
                    .openPopup();

                map.setView(new L.LatLng(39.7706790971256, 64.4232798737373), 15);

                $('#locationLabel').html(fullname);

                map.on('click', function(ev) {
                    marker.setLatLng(ev.latlng);
                    var latlng = map.mouseEventToLatLng(ev.originalEvent);
                    $('#locationInput').val(latlng.lat + ', ' + latlng.lng);
                });
            }

        }
    </script>
    <script>
        function showModal(id) {
            localStorage.setItem('client', id);
            $('#Neworder').modal('show');
        }
    </script>
    <script>
        function TakeOrder() {
            let product_id = $('#prod_sel_new_order').val();
            let sena = $('#sena_product_order').val();
            let count = $('#orderCount').val();
            let izoh = $('#orderComment').val();
            let id = localStorage.getItem('client');
            $.ajax({
                url: "{{ route('add_order') }}",
                method: "POST",
                data: {
                    "_token": "{{ csrf_token() }}",
                    client_id: id,
                    product_id: product_id,
                    sena: sena,
                    count: count,
                    izoh: izoh,
                },
                success: function(res) {
                    if (res.status) {
                        $('#Neworder').modal('hide');
                        $('#orderButton' + id).prop('disabled', true);
                        alertify.success(res.message);
                    } else {
                        $('#Neworder').modal('hide');
                        alertify.error(res.message);
                    }
                }
            });
        }
    </script>
    <script>
        function onsel() {
            const $this = $("#prod_sel_new_order");
            const dataVal = $this.find(':selected').data('amount');
            $('#sena_product_order').val(dataVal);
        }
    </script>
    <script>
        function changeRegion(id) {
            let region_id = $('#edit_region_id' + id).val();
            $.ajax({
                url: "{{ route('search_areas') }}",
                method: "GET",
                data: {
                    region_id: region_id
                },
                success: function(res) {
                    console.log(res);
                    var $area = $('#edit_area_id' + id);
                    $area.empty();
                    for (var i = 0; i < res.length; i++) {
                        $area.append('<option value=' + res[i]
                            .id + '>' + res[i].name + '</option>');
                    }
                    $area.change();
                }
            });
        }
    </script>
    <script>
        function DeleteClient(fullname, id) {
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
                        url: "{{ route('delete_client') }}",
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
