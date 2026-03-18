@if ($orders->count())
    <div class="table-responsive" style="min-height:200px">
        <table class="table table-sm align-middle table-bordered table-nowrap" id="table_order">
            <thead class="table-light">
                <tr>
                    <th class="text-center fw-bold" style="width:32px"></th>
                    <th class="text-center" width="50">#</th>
                    <th class="text-center">{{ __('messages.fullname') }}</th>
                    <th class="text-center">{{ __('messages.phone') }}</th>
                    <th class="text-center">{{ __('messages.address') }}</th>
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
                    <tr class="row1" data-id="{{ $order->id }}"
                        data-fullname="{{ $order->client->fullname }}"
                        data-phone="{{ $order->client->phone }}"
                        data-city="{{ optional($order->client->city)->name ?? '' }}"
                        data-area="{{ optional($order->client->area)->name ?? '' }}"
                        data-address="{{ $order->client->address ?? '' }}"
                        data-comment="{{ $order->comment }}">
                        <td class="text-center">
                            <i class="fas fa-stream" style="color:#556ee6;cursor:pointer"></i>
                        </td>
                        <td class="text-center">
                            <span class="view-order-btn" style="cursor:pointer;color:#556ee6;font-weight:600">
                                {{ $orders->currentPage() * $orders->perPage() - $orders->perPage() + $loop->index + 1 }}
                            </span>
                        </td>
                        <td class="text-center fw-bold">{{ $order->client->fullname }}</td>
                        <td class="text-center">{{ $order->client->phone }}</td>
                        <td class="text-center">
                            <span class="text-muted" style="font-size:12px">
                                {{ optional($order->client->city)->name ?? '' }}{{ optional($order->client->area)->name ? ', '.$order->client->area->name : '' }}
                            </span>
                            <br>{{ $order->client->address ?? '' }}
                        </td>
                        <td class="text-center">{{ optional($order->product)->name ?? '' }}</td>
                        <td class="text-center fw-bold">{{ $order->product_count ?? '' }}</td>
                        <td class="text-center">{{ $order->price }}</td>
                        <td class="text-center" style="font-size:12px;white-space:nowrap">
                            {{ $order->created_at->format('d.m.Y') }}
                        </td>
                        <td class="text-center" style="max-width:120px;font-size:12px">{{ $order->comment }}</td>
                        <td class="text-center" style="font-size:12px">{{ optional($order->user)->name }}</td>
                        <td class="align-middle text-center" style="white-space:nowrap">
                            <a href="{{ route('success_order_view', ['id' => $order->id]) }}"
                               class="btn btn-soft-success waves-effect waves-light btn-sm"
                               data-bs-toggle="tooltip" data-bs-placement="top"
                               title="{{ __('messages.accept') }}">
                                <i class="fa fa-check-circle"></i>
                            </a>
                            <button type="button" class="btn btn-soft-dark waves-effect waves-light btn-sm"
                                    data-bs-toggle="modal" data-bs-target="#orderedit{{ $order->id }}"
                                    title="{{ __('messages.update') }}">
                                <i class="fa fa-edit"></i>
                            </button>
                            <button type="button" class="btn btn-soft-danger waves-effect waves-light btn-sm"
                                    onclick="DeleteOrder('{{ addslashes($order->client->fullname) }}', {{ $order->id }})"
                                    data-bs-toggle="tooltip" data-bs-placement="top"
                                    title="{{ __('messages.delete') }}">
                                <i class="fa fa-trash"></i>
                            </button>
                        </td>
                    </tr>

                    {{-- Edit order modal --}}
                    <div class="modal fade" id="orderedit{{ $order->id }}" tabindex="-1" data-bs-scroll="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">{{ __('messages.order_update') }}</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
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
                                                            @if ($order->product_id === $product->id) selected @endif
                                                            value="{{ $product->id }}">{{ $product->name }}</option>
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
                                            <textarea class="form-control" name="izoh" rows="2">{{ $order->comment }}</textarea>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary btn-lg" data-bs-dismiss="modal">
                                            <i class="fas fa-reply me-2"></i>{{ __('messages.cancel') }}
                                        </button>
                                        <button class="btn btn-success btn-lg" type="submit">
                                            <i class="fa fa-save me-2"></i>{{ __('messages.save') }}
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </tbody>
        </table>
    </div>
@else
    <div class="text-center py-4 text-muted">
        <i class="fas fa-inbox fa-2x mb-2 d-block opacity-50"></i>
        {{ __('messages.no_data') ?? 'No orders' }}
    </div>
@endif
