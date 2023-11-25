@extends('layouts.v2_master')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">{{ __('messages.shops') }}</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">{{ __('messages.home') }}</a></li>
                        <li class="breadcrumb-item active">{{ __('messages.shops') }}</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>

    <button type="button" class="btn btn-primary mb-3 waves-effect waves-light" data-bs-toggle="offcanvas"
            data-bs-target="#addShop" aria-controls="offcanvasBottom">
        <i class="fas fa-plus-circle me-2"></i>{{ __('messages.add_shop') }}
    </button>

    <div class="offcanvas offcanvas-bottom" tabindex="-1" id="addShop" aria-labelledby="offcanvasBottomLabel"
         style="height: 350px">
        <div class="offcanvas-header">
            <h5 id="offcanvasBottomLabel">{{ __('messages.add_shop') }}</h5>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <form action="{{ route('add_organization') }}" method="post">
                @csrf
                <div class="row mb-3">
                    <div class="col">
                        <label style="margin-bottom: 0">{{ __('messages.shop_name') }}:</label>
                        <input class="form-control" type="text" name="name" required>
                    </div>
                    <div class="col">
                        <label style="margin-bottom: 0">{{ __('messages.director') }}:</label>
                        <input class="form-control" type="text" name="director_name" required>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col">
                        <label style="margin-bottom: 0">{{ __('messages.select_traffic') }}:</label>
                        <select class="form-select" name="traffic_id">
                            @foreach ($traffics as $traffic)
                                <option value="{{ $traffic->id }}">{{ $traffic->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col">
                        <label style="margin-bottom: 0">{{ __('messages.to_date') }}:</label>
                        <input class="form-control" type="date" name="date_traffic" required>
                    </div>

                    <div class="col">
                        <label style="margin-bottom: 0">{{ __('messages.phone') }}:</label>
                        <input class="form-control phone-number" type="text" id="phone" name="phone" required>
                    </div>

                </div>

                <div class="row">
                    <div class="col">
                        <label style="margin-bottom: 0">{{ __('messages.comment') }}:</label>
                        <textarea class="form-control" type="text" name="comment" required> </textarea>
                    </div>
                    <div class="col">
                        <button type="button" class="btn btn-secondary btn-lg waves-effect waves-light"
                                data-bs-dismiss="offcanvas" style="margin-top: 30px"><i class="fas fa-reply me-2"></i>
                            {{ __('messages.cancel') }}</button>
                        <button type="submit" class="btn btn-success waves-effect btn-lg waves-light"
                                style="margin-top: 30px">
                            <i class="fas fa-save me-2"></i> {{ __('messages.save') }}
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-body p-0">
            <div class="table-responsive animate__animated animate__fadeIn">
                <table class="table table-sm align-middle table-bordered table-nowrap">
                    <thead class="table-light">
                    <tr>
                        <th class="align-middle text-center">#</th>
                        <th class="align-middle text-center">{{ __('messages.name') }}</th>
                        <th class="align-middle text-center">{{ __('messages.director') }}</th>
                        <th class="align-middle text-center">{{ __('messages.phone') }}</th>
                        <th class="align-middle text-center">{{ __('messages.traffic') }}</th>
                        <th class="align-middle text-center">{{ __('messages.balance') }}</th>
                        <th class="align-middle text-center">{{ __('messages.clients') }}</th>
                        <th class="align-middle text-center">{{ __('messages.sms') }}</th>
                        <th class="align-middle text-center">{{ __('messages.products') }}</th>
                        <th class="align-middle text-center">{{ __('messages.users') }}</th>
                        <th class="align-middle text-center">{{ __('messages.created') }}</th>
                        <th class="align-middle text-center">{{ __('messages.to_date') }}</th>
                        <th class="align-middle text-center" width="130px">{{ __('messages.action') }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($organizations as $organization)
                        <tr>
                            <td class="text-center">{{ $loop->index + 1 }}</td>
                            <td class="text-center">
                                {{ $organization->name }}
                            </td>
                            <td class="text-center">
                                {{ $organization->director_name }}
                            </td>
                            <td class="text-center">
                                {{ $organization->phone }}
                            </td>
                            <td class="text-center">
                                <a
                                    href="{{ route('trafficorgan', ['id' => $organization->id]) }}">{{ $organization->traffic->name }}</a>
                            </td>
                            <td class="text-center">
                                <a href="{{ route('addpriceorgan', ['id' => $organization->id]) }}">{{ $organization->balance }}
                                    so'm</a>
                            </td>
                            <td class="text-center">
                                {{ $organization->clients->count() }}
                            </td>
                            <td class="text-center">
                                {{ $organization->sms_count }}
                            </td>
                            <td class="text-center">
                                {{ $organization->products->count() }}
                            </td>
                            <td class="text-center">
                                {{ $organization->users->count() }}
                            </td>
                            <td class="text-center">
                                {{ $organization->updated_at->format('Y-m-d') }}
                            </td>
                            <td class="text-center">
                                {{ $organization->date_traffic ?? now() }}
                            </td>
                            <td class="text-center">
                                <button type="button" class="btn btn-soft-dark waves-effect waves-light"
                                        data-bs-toggle="offcanvas" data-bs-target="#edit{{ $organization->id }}"
                                        aria-controls="offcanvasBottom"><i class="fas fa-edit"></i>
                                    <span></span></button>
                                <button type="button" class="btn btn-soft-danger waves-effect waves-light"
                                        onclick="DeleteShop('{{ $organization->name }}', {{ $organization->id }})"><i
                                        class="fas fa-trash"></i>
                                    <span></span></button>
                            </td>
                        </tr>

                        <div class="offcanvas offcanvas-bottom" tabindex="-1" id="edit{{ $organization->id }}"
                             aria-labelledby="offcanvasBottomLabel" style="height: 350px">
                            <div class="offcanvas-header">
                                <h5 id="offcanvasBottomLabel">{{ __('messages.edit_shop') }}</h5>
                                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                                        aria-label="Close"></button>
                            </div>
                            <div class="offcanvas-body">
                                <form action="{{ route('edit_organization', ['id' => $organization->id]) }}"
                                      method="post">
                                    @csrf
                                    <div class="row mb-3">
                                        <div class="col">
                                            <label style="margin-bottom: 0">{{ __('messages.shop_name') }}:</label>
                                            <input class="form-control" type="text" name="name"
                                                   value="{{ $organization->name }}" required>
                                        </div>
                                        <div class="col">
                                            <label style="margin-bottom: 0">{{ __('messages.director') }}:</label>
                                            <input class="form-control" type="text" name="director_name"
                                                   value="{{ $organization->director_name }}" required>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col">
                                            <label style="margin-bottom: 0">{{ __('messages.phone') }}:</label>
                                            <input class="form-control phone-number" type="text" name="phone"
                                                   value="{{ $organization->phone }}" required>
                                        </div>
                                        <div class="col">
                                            <label
                                                style="margin-bottom: 0">{{ __('messages.select_traffic') }}:</label>
                                            <select class="form-select" name="traffic_id">
                                                @foreach ($traffics as $traffic)
                                                    <option value="{{ $traffic->id }}">
                                                        {{ $traffic->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col">
                                            <label style="margin-bottom: 0">{{ __('messages.to_date') }}:</label>
                                            <input class="form-control" type="date" name="date_traffic"
                                                   value="{{ $organization->date_traffic }}" required>
                                        </div>

                                    </div>

                                    <div class="row">
                                        <div class="col">
                                            <label style="margin-bottom: 0">{{ __('messages.comment') }}:</label>
                                            <textarea class="form-control" type="text" name="comment"
                                                      required> {{ $organization->comment }}</textarea>
                                        </div>
                                        <div class="col">
                                            <button type="button"
                                                    class="btn btn-secondary btn-lg waves-effect waves-light"
                                                    data-bs-dismiss="offcanvas" style="margin-top: 30px"><i
                                                    class="fas fa-reply me-2"></i>
                                                {{ __('messages.cancel') }}</button>
                                            <button type="submit"
                                                    class="btn btn-success waves-effect btn-lg waves-light"
                                                    style="margin-top: 30px">
                                                <i class="fas fa-save me-2"></i> {{ __('messages.save') }}
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        IMask(document.getElementById("phone"), {
            mask: [{
                mask: "(00)0000000"
            }]
        });
    </script>
    <script>
        function DeleteShop(fullname, id) {
            Swal.fire({
                title: "{{ __('messages.Do_you_want_to_delete') }} ?",
                text: fullname,
                icon: "warning",
                showCancelButton: !0,
                cancelButtonText: "{{ __('messages.no') }}",
                confirmButtonColor: "#1c84ee",
                cancelButtonColor: "#fd625e",
                confirmButtonText: "{{ __('messages.Yes_delete') }} !"
            }).then(function (e) {
                if (e.isConfirmed) {
                    $.ajax({
                        url: "{{ route('delete_organization') }}",
                        method: "POST",
                        data: {
                            "_token": "{{ csrf_token() }}",
                            id: id
                        },
                        success: function (res) {
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
