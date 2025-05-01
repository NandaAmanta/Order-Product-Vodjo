@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Orders</h1>
            <a href="{{ route('orders.create') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-plus fa-sm text-white-50"></i> Create Order</a>
        </div>
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Data Orders</h6>
            </div>
            <div class="card-body">
                <table border="0" cellspacing="5" cellpadding="5">
                    <tbody><tr>
                        <td>Start date:</td>
                        <td><input type="date" id="min" name="min" ></td>
                    </tr>
                    <tr>
                        <td>End date:</td>
                        <td><input type="date" id="max" name="max" ></td>
                    </tr>
                </tbody></table>
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>order_no</th>
                                <th>Customer</th>
                                <th>Order Date</th>
                                <th>Grand Total</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script type="module" >
        $(document).ready(function () {
           initDatatable()
           $('#min, #max').on('change', filterData);
            
        });

        function filterData() {
            let minDate = $('#min').val();
            let maxDate = $('#max').val();
            $('#dataTable').DataTable().ajax.url(`{{ route('orders.index') }}?start_at=${minDate}&end_at=${maxDate}`).load();
        }
        
        function initDatatable(){
            $('#dataTable').DataTable({
                "processing": true,
                "serverSide": true,
                "ajax": {
                    "url": "{{ route('orders.index') }}",
                    "type": "GET"
                },
                "columns": [
                    { 
                        "data": "order_no",
                        'searchable': true
                    },
                    { "data": "customer_name" },
                    { "data": "order_date" },
                    { "data": "grand_total" },
                    {
                        "data": "id",
                        "render": function (data) {
                            return( `<a class="btn btn-sm btn-primary mr-2" href="{{route('orders.edit', ['id' => ':id'])}}"><i class="fas fa-edit">Edit</i></a>` +
                                   `<form action="{{route('orders.destroy', ['id' => ':id'])}}" method="POST" style="display:inline">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger delete" type="submit">Delete</button>
                                    </form>`).replaceAll(':id', data);
                        }
                    }
                ],
                "order": [[0, 'desc']]
            });
        }
    </script>
@endpush
