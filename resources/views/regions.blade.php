@extends('layouts.v2_master')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">{{ __('messages.regions') }}</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">{{ __('messages.home') }}</a></li>
                        <li class="breadcrumb-item active">{{ __('messages.regions') }}</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12 col-sm-12 col-lg-8">
            <div class="card rounded-4">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">{{ __('messages.regions') }}</h4>
                    <div class="flex-shrink-0">
                        <ul class="nav justify-content-end nav-pills card-header-pills" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" id="city" href="#cityTab" role="tab">
                                    <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                                    <span class="d-none d-sm-block">{{ __('messages.regions') }}</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" id="area" href="#areaTab" role="tab">
                                    <span class="d-block d-sm-none"><i class="far fa-user"></i></span>
                                    <span class="d-none d-sm-block">{{ __('messages.cities') }}</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="card-body">
                    <div class="tab-content text-muted">
                        <div class="tab-pane" id="cityTab" role="tabpanel">

                            <button type="button" class="btn btn-primary btn-lg waves-effect waves-light"
                                data-bs-toggle="modal" data-bs-target="#addregion">
                                <i class="fa fa-plus-circle"></i> {{ __('messages.add_region') }}
                            </button>

                            <div class="modal fade" id="addregion" tabindex="-1" role="dialog">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="myModalLabel">
                                                {{ __('messages.add_region') }}</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <form action="{{ route('add_region') }}" method="post">
                                            @csrf
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <h6><label>{{ __('messages.name') }}:</label></h6>
                                                    <input class="form-control" type="text" name="region_name"
                                                        placeholder="{{ __('messages.name') }}..." required>
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

                            <div class="row mt-3">
                                <div class="table-responsive" style="max-height: 400px;">
                                    <table class="table table-sm align-middle table-bordered table-nowrap">
                                        <thead class="table-light">
                                            <tr>
                                                <th class="text-center" width="60">#</th>
                                                <th class="text-center">{{ __('messages.name') }}</th>
                                                <th class="text-center">{{ __('messages.clients_count') }}</th>
                                                <th class="text-center" width="100">{{ __('messages.action') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($regions as $region)
                                                <tr>
                                                    <td class="text-center">{{ $loop->index + 1 }}</td>
                                                    <td class="text-center">
                                                        <h6>{{ $region->name }}</h6>
                                                    </td>
                                                    <td class="text-center">
                                                        <h6>{{ $region->clients->count() }}</h6>
                                                    </td>
                                                    <td class="text-center">
                                                        <button type="button"
                                                            class="btn btn-soft-primary waves-effect waves-light"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#edit{{ $region->id }}"><i
                                                                class="bx bx-edit-alt font-size-16 align-middle"></i></button>
                                                        <button type="button"
                                                            class="btn btn-soft-danger waves-effect waves-light"
                                                            onclick="DeleteRegion('{{ $region->name }}', {{ $region->id }})"><i
                                                                class="bx bx-trash-alt font-size-16 align-middle"></i></button>

                                                    </td>
                                                </tr>
                                                <div class="modal fade" id="edit{{ $region->id }}" tabindex="-1"
                                                    role="dialog">
                                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="myModalLabel">
                                                                    {{ __('messages.update_region') }}</h5>
                                                                <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <form
                                                                action="{{ route('edit_region', ['id' => $region->id]) }}"
                                                                method="post">
                                                                @csrf
                                                                <div class="modal-body">
                                                                    <div class="mb-3">
                                                                        <label class="mb-0">
                                                                            {{ __('messages.name') }}:</label>
                                                                        <input class="form-control" type="text"
                                                                            name="region_name"
                                                                            value="{{ $region->name }}" required>
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
                            </div>
                        </div>
                        <div class="tab-pane" id="areaTab" role="tabpanel">
                            <button type="button" class="btn btn-primary btn-lg waves-effect waves-light"
                                data-bs-toggle="modal" data-bs-target="#addcity">
                                <i class="fa fa-plus-circle"></i> {{ __('messages.add_city') }}
                            </button>
                            <button type="button" class="btn btn-danger btn-lg waves-effect waves-light"
                                onclick="Sort()">
                                <i class="fa fa-filter"></i> {{ __('messages.filtr') }}
                            </button>
                            @push('scripts')
                                <script>
                                    function Sort() {
                                        let url = '{{ route('regions') }}';
                                        window.location.href =
                                            `${url}?filter=${"down"}`;
                                    }
                                </script>
                            @endpush
                            <div class="modal fade" id="addcity" tabindex="-1" role="dialog">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="myModalLabel">
                                                {{ __('messages.add_city') }}</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <form action="{{ route('add_city') }}" method="post">
                                            @csrf
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <label class="mb-0">{{ __('messages.regions') }}:</label>
                                                    <select class="form-select" name="sity_id">
                                                        @foreach ($regions as $region)
                                                            <option value="{{ $region->id }}">{{ $region->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="mb-0">{{ __('messages.name') }}:</label>
                                                    <input class="form-control" type="text" name="area_name" required>
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
                            <div class="table-responsive mt-3" style="max-height: 400px;">
                                <table class="table table-sm align-middle table-bordered table-nowrap">
                                    <thead class="table-light">
                                        <tr>
                                            <th class="text-center">#</th>
                                            <th class="text-center">{{ __('messages.region_name') }}</th>
                                            <th class="text-center">{{ __('messages.name') }}</th>
                                            <th class="text-center">{{ __('messages.clients_count') }}</th>
                                            <th class="text-center">{{ __('messages.action') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($areas as $area)
                                            <tr>
                                                <td class="text-center">{{ $loop->index + 1 }}</td>
                                                <td class="text-center">
                                                    {{ $area->region->name }}
                                                </td>
                                                <td class="text-center">
                                                    <h6> {{ $area->name }}</h6>
                                                </td>
                                                <td class="text-center">
                                                    <h6>{{ $area->clients->count() }}</h6>
                                                </td>
                                                <td class="text-center">
                                                    <button type="button"
                                                        class="btn btn-soft-primary waves-effect waves-light"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#editCty{{ $area->id }}"><i
                                                            class="bx bx-edit-alt font-size-16 align-middle"></i></button>
                                                    <button type="button"
                                                        class="btn btn-soft-danger waves-effect waves-light"
                                                        onclick="DeleteCity('{{ $area->name }}', {{ $area->id }})"><i
                                                            class="bx bx-trash-alt font-size-16 align-middle"></i></button>
                                                </td>
                                            </tr>
                                            <div class="modal fade" id="editCty{{ $area->id }}" tabindex="-1"
                                                role="dialog">
                                                <div class="modal-dialog modal-dialog-centered" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="myModalLabel">
                                                                {{ __('messages.update_city') }}</h5>
                                                            <button type="button" class="btn-close"
                                                                data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <form action="{{ route('edit_city', ['id' => $area->id]) }}"
                                                            method="post">
                                                            @csrf
                                                            <div class="modal-body">
                                                                <div class="mb-3">
                                                                    <label
                                                                        class="mb-0">{{ __('messages.regions') }}:</label>
                                                                    <select class="form-control" name="sity_id">
                                                                        @foreach ($regions as $region)
                                                                            <option value="{{ $region->id }}">
                                                                                {{ $region->name }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label
                                                                        class="mb-0">{{ __('messages.name') }}:</label>
                                                                    <input class="form-control" type="text"
                                                                        name="area_name" value="{{ $area->name }}"
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
            let activeTab = localStorage.getItem('activaRegionTab') ?? 'cityTab';
            if (activeTab == "cityTab") {
                document.getElementById("city").setAttribute("class", "nav-link active");
                document.getElementById("area").setAttribute("class", "nav-link");
                document.getElementById("cityTab").setAttribute("class", "tab-pane active");
                document.getElementById("areaTab").setAttribute("class", "tab-pane");

            } else {
                document.getElementById("city").setAttribute("class", "nav-link");
                document.getElementById("area").setAttribute("class", "nav-link active");
                document.getElementById("cityTab").setAttribute("class", "tab-pane");
                document.getElementById("areaTab").setAttribute("class", "tab-pane active");
            }
        });
    </script>
    <script>
        document.getElementById('city').onclick = function() {
            let c = localStorage.setItem('activaRegionTab', 'cityTab');

            document.getElementById("city").setAttribute("class", "nav-link active");
            document.getElementById("area").setAttribute("class", "nav-link");
            document.getElementById("cityTab").setAttribute("class", "tab-pane active");
            document.getElementById("areaTab").setAttribute("class", "tab-pane");

        };

        document.getElementById('area').onclick = function() {
            let c = localStorage.setItem('activaRegionTab', 'areaTab');

            document.getElementById("city").setAttribute("class", "nav-link");
            document.getElementById("area").setAttribute("class", "nav-link active");
            document.getElementById("cityTab").setAttribute("class", "tab-pane");
            document.getElementById("areaTab").setAttribute("class", "tab-pane active");

        };
    </script>
    <script>
        function DeleteRegion(fullname, id) {
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
                        url: "{{ route('delete_region') }}",
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
        function DeleteCity(fullname, id) {
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
                        url: "{{ route('delete_city') }}",
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
