@extends('layouts.v2_master')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">{{ __('messages.order_update') }}</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">{{ __('messages.home') }}</a></li>
                        <li class="breadcrumb-item"><a href="javascript: void(0);">{{ __('messages.Clients') }}</a></li>
                        <li class="breadcrumb-item active">{{ __('messages.order_update') }}</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card rounded-3">
                <div class="card-body p-0 mb-0">
                    <div class="table-responsive">
                        <table class="table table-sm align-middle table-bordered table-nowrap table-check">
                            <thead class="table-light">
                                <tr>
                                    <th class="text-center">{{ __('messages.fullname') }}</th>
                                    <th class="align-middle text-center">{{ __('messages.phone') }}</th>
                                    <th class="align-middle text-center">{{ __('messages.address') }}</th>
                                    <th class="align-middle text-center">{{ __('messages.product') }}</th>
                                    <th class="align-middle text-center">{{ __('messages.count') }}</th>
                                    <th class="align-middle text-center">{{ __('messages.price') }}</th>
                                    <th class="align-middle text-center">{{ __('messages.time') }}</th>
                                    <th class="align-middle text-center">{{ __('messages.comment') }}</th>
                                    <th class="align-middle text-center">{{ __('messages.user') }}</th>
                                    <th class="align-middle text-center">{{ __('messages.action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($orders as $order)
                                    <tr>
                                        <td class="text-center"> {{ $order->client->fullname }}</td>
                                        <td class="text-center"> {{ $order->client->phone }}</td>
                                        <td class="text-center"> {{ $order->client->city->name ?? '' }},
                                            {{ $order->client->area->name ?? '' }}, {{ $order->client->address ?? '' }}
                                        </td>
                                        <td class="text-center"> {{ $order->product->name }}</td>
                                        <td class="text-center"> {{ $order->product_count }}</td>
                                        <td class="text-center"> {{ $order->price }}</td>
                                        <td class="text-center"> {{ $order->created_at }}</td>
                                        <td class="text-center"> {{ $order->comment }}</td>
                                        <td class="text-center"> {{ $order->user->name }}</td>
                                        <td class="text-center">
                                            <a href="{{ route('success_order_view', ['id' => $order->id]) }}"
                                                type="button"
                                                class="btn btn-outline-success btn-sm waves-effect waves-light"><i
                                                    class="fa fa-check-circle"></i>
                                                {{ __('messages.accept') }}</a>
                                            <button type="button"
                                                class="btn btn-outline-dark btn-sm waves-effect waves-light"
                                                data-bs-toggle="modal" data-bs-target="#edit{{ $order->id }}"><i
                                                    class="fa fa-edit"></i>
                                                {{ __('messages.update') }} </button>
                                        </td>
                                    </tr>
                                    <div class="modal fade" id="edit{{ $order->id }}" tabindex="-1" role="dialog">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="myModalLabel">
                                                        {{ __('messages.order_update') }}</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <form action="{{ route('order_edit', ['id' => $order->id]) }}"
                                                    method="post">
                                                    @csrf
                                                    <div class="modal-body">
                                                        <div class="mb-3">
                                                            <label class="mb-0">{{ __('messages.product') }}:</label>
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
                                                        <div class="row mb-3">
                                                            <div class="col">
                                                                <label class="mb-0">{{ __('messages.price') }}:</label>
                                                                <input class="form-control" type="text"
                                                                    id="sena_product_order{{ $order->id }}"
                                                                    name="sena" value="{{ $order->price }}" required>
                                                            </div>
                                                            <div class="col">
                                                                <label class="mb-0">{{ __('messages.count') }}:</label>
                                                                <input class="form-control" type="number"
                                                                    value="{{ $order->product_count }}" name="count"
                                                                    required>
                                                            </div>
                                                        </div>
                                                        <div class="">
                                                            <label class="mb-0">{{ __('messages.comment') }}:</label>
                                                            <textarea class="form-control" name="izoh" id="" rows="2"></textarea>
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
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        function onsel(id) {
            const $this = $("#prod_sel" + id);
            const dataVal = $this.find(':selected').data('amount');
            $('#sena_product_order' + id).val(dataVal);
        }
    </script>
@endsection
