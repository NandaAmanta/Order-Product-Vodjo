@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col">
            <div class="card">
                <div class="card-header">{{ __('Create Order') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('orders.store') }}">
                        @csrf
                        <div class="row mb-3">
                            <label for="customer" class="col-md-4 col-form-label text-md-end">{{ __('Customer') }}</label>

                            <div class="col-md-6">
                                <input id="customer" type="text" class="form-control @error('customer') is-invalid @enderror" name="customer_name" value="{{ old('customer_name') }}" required autocomplete="customer_name">

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
                                <input id="order_date" type="date" class="form-control @error('order_date') is-invalid @enderror" name="order_date" value="{{ old('order_date') }}" required autocomplete="order_date">

                                @error('order_date')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        
                        <div class="mt-5" id="order-products">
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
                                        <th></th>
                                    </tr>
                                    <tr>
                                        <td class="pr-2">
                                            <input type="text" name="order_products[0][product_name]" class="form-control">
                                        </td>    
                                        <td class="pr-2"><input type="number" name="order_products[0][qty]" class="form-control"></td>
                                        <td class="pr-2"><input type="number" name="order_products[0][price]" class="form-control"></td>
                                        <td class="pr-2"><button type="button" class="btn btn-danger remove-product">Remove</button></td>
                                    </tr>
    
                                </table>
                            </div>
                            
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Create') }}
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
            $('#table-order-products').append(`
                <tr>
                    <td class="pr-2">
                        <input type="text" name="product_name[]" class="form-control">
                    </td>    
                    <td class="pr-2"><input type="number" name="qty[]" class="form-control"></td>
                    <td class="pr-2"><input type="number" name="price[]" class="form-control"></td>
                    <td class="pr-2"><button type="button" class="btn btn-danger remove-product">Remove</button></td>
                </tr>
            `);
        });
    </script>
@endpush