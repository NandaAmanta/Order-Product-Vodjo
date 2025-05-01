@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col">
            <div class="card">
                <div class="card-header">{{ __('Edit Order') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('orders.update', $order->id) }}">
                        @csrf
                        @method('PUT')
                        <div class="row mb-3">
                            <label for="customer" class="col-md-4 col-form-label text-md-end">{{ __('Customer') }}</label>

                            <div class="col-md-6">
                                <input id="customer" type="text" class="form-control @error('customer') is-invalid @enderror" name="customer_name" value="{{ $order->customer_name }}" required autocomplete="customer_name">

                                @error('customer_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="order_date" class="col-md-4 col-form-label text-md-end">{{ __('Order Date') }}</label>

                            <div class="col-md-6">
                                <input id="order_date" type="date" class="form-control @error('order_date') is-invalid @enderror" name="order_date" value="{{ $order->order_date}}" required autocomplete="order_date">

                                @error('order_date')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="grand_total" class="col-md-4 col-form-label text-md-end">{{ __('Grand Total') }}</label>

                            <div class="col-md-6">
                                <input id="grand_total" type="number" class="form-control @error('grand_total') is-invalid @enderror" name="grand_total" value="{{ $order->grand_total}}" required autocomplete="grand_total">

                                @error('grand_total')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="mt-5  mb-5" id="order-products">
                            <div class="row justify-content-end">
                                <div class="col-auto">
                                    <button class="btn btn-primary add-product">Add Product</button>
                                </div>
                            </div>

                            <div class="row justify-content-center">
                                <table id="table-order-products">
                                    <tr>
                                        <th>Product</th>
                                        <th>Quantity</th>
                                        <th>Price</th>
                                        <th>Subtotal</th>
                                        <th></th>
                                    </tr>
                                    @foreach ($order->orderProducts as $index => $orderProduct)
                                        <tr>
                                            <input type="hidden" name="order_products[{{ $index }}][id]" value="{{ $orderProduct->id }}">
                                            <td class="pr-2"><input type="text" name="order_products[{{ $index }}][product_name]" class="form-control" value="{{ $orderProduct->product_name }}"></td>    
                                            <td class="pr-2"><input type="number" name="order_products[{{ $index }}][qty]" class="form-control" value="{{ $orderProduct->qty }}"></td>
                                            <td class="pr-2"><input type="number" name="order_products[{{ $index }}][price]" class="form-control" value="{{ $orderProduct->price }}"></td>
                                            <td class="pr-2"><input type="number" name="order_products[{{ $index }}][subtotal]" class="form-control" value="{{ $orderProduct->subtotal }}" disabled></td>
                                            <td class="pr-2"><button type="button" class="btn btn-danger remove-product">Remove</button></td>
                                        </tr>
                                    @endforeach
                                </table>
                            </div>
                            
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Update') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    <script type="module">
        $(document).on('click', '.remove-product', function(e){
            e.preventDefault();
            $(this).closest('tr').remove();
        });

        $(document).on('click', '.add-product', function(e){
            e.preventDefault();
            let index = $('#table-order-products tr').length - 1;
            $('#table-order-products').append(`
                <tr>
                    <td class="pr-2">
                        <input type="text" name="order_products[${index}][product_name]" class="form-control">
                    </td>    
                    <td class="pr-2"><input type="number" name="order_products[${index}][qty]" class="form-control"></td>
                    <td class="pr-2"><input type="number" name="order_products[${index}][price]" class="form-control"></td>
                    <td class="pr-2"><button type="button" class="btn btn-danger remove-product">Remove</button></td>
                </tr>
            `);
        });
    </script>
@endpush
