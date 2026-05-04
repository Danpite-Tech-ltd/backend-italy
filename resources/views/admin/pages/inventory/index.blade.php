@extends('admin.layout.app')

@push('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/2.3.2/css/dataTables.bootstrap5.min.css">



@endpush


@section('content')

    <div class="row my-4">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-center mb-4">
                <h2 class="mb-sm-0 font-size-18">Products Stock Overview</h2>
            </div>
        </div>
    </div>
    <div class="row">
        @forelse($productByCategory as $key => $products)
        <div class="col-xl-3 col-md-6 mb-4">
            <!-- card -->
            <div class="card card-h-100 shadow">
                <!-- card body -->
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-4 text-center  rounded">
                            <i class="fas fa-cart-plus h2"></i>
                        </div>

                        <div class="col-8">
                            <span class="text-muted mb-3 lh-1 d-block text-truncate">{{ $products->category->name ?? '' }}</span>
                            <h4 class="mb-3">
                                <span class="">{{ $products->count() }}</span>
                            </h4>
                        </div>
                    </div>

                </div><!-- end card body -->
            </div>
        </div>
        @empty
        @endforelse

        <div class="col-xl-3 col-md-6 mb-4">
            <!-- card -->
            <div class="card card-h-100 shadow">
                <!-- card body -->
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-4 text-center  rounded">
                            <i class="fas fa-cart-plus h2"></i>
                        </div>

                        <div class="col-8">
                            <span class="text-muted mb-3 lh-1 d-block text-truncate">Total Products</span>
                            <h4 class="mb-3">
                                <span class="">{{ $productByCategory->count()}}</span>
                            </h4>
                        </div>
                    </div>
                </div><!-- end card body -->
            </div>
        </div>
    </div>


    <div class="row">
        <div class="col-lg-12">
            <div class="card">

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table mb-0 w-100 dataTable no-footer dtr-inline table-striped" id="adminTable">
                            <thead>
                            <tr>
                                <th>Product SKU</th>
                                <th>Image</th>
                                <th>Title</th>
                                <th>Stock</th>
                                <th>Status</th>
                            </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>

                </div>
                <!-- end card body -->
            </div>
            <!-- end card -->
        </div>
        <!-- end col -->
    </div>

    {{--    Table Ends--}}

@endsection


@push('js')
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
            integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script src="https://cdn.datatables.net/2.3.2/js/dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/2.3.2/js/dataTables.bootstrap5.min.js"></script>
    {{--    <script src="{{asset('backend')}}/assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>--}}

    <!-- DataTables Buttons -->
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>

    <!-- Buttons Export (PDF/Print) -->
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>

    <!-- PDFMake (required for PDF export) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script>

        $(document).ready(function () {

            let token = $("input[name='_token']").val();

            let baseAssetUrl = "{{ asset('') }}";

            //Show Data through Datatable
            let adminTable = $('#adminTable').DataTable({

                dom: '<"row mb-3"' +
                    '<"col-md-6 d-flex align-items-center mb-2 mb-md-0"l>' +
                    '<"col-md-6 d-flex flex-wrap justify-content-md-end gap-2"Bf>' +
                    '>' +
                    '<"row"<"col-12"tr>>' +
                    '<"row mt-3"' +
                    '<"col-md-5"i>' +
                    '<"col-md-7"p>' +
                    '>',
                buttons: [
                    {
                        extend: 'print',
                        text: 'Print Table',
                        className: 'btn btn-success btn-sm'
                    },
                    {
                        extend: 'pdfHtml5',
                        text: 'Download PDF',
                        className: 'btn btn-danger btn-sm'
                    },
                    { extend: 'csv', className: 'btn btn-info btn-sm', text: 'CSV Export' },
                    { extend: 'excel', className: 'btn btn-success btn-sm', text: 'Excel Export' },

                ],

                order: [
                    [0, 'asc']
                ],
                processing: true,
                serverSide: true,
                {{--ajax: "{{url('/admin/data')}}",--}}
                ajax: "{{route('admin.inventory.index')}}",
                // pageLength: 30,

                columns: [

                    {
                        data: 'SKU',
                        name: 'SKU',
                        width: '10%',

                    },

                    {
                        data: 'proImg',
                        orderable: false,
                        searchable: false,
                        width: '10%',
                    },

                    {
                        data: 'name',
                        name: 'name',
                        width: '25%'
                    },
                    {
                        data: 'stock',
                        width: '45%'

                    },

                    {
                        data: 'status',
                        orderable: 'false',
                        searchable: 'false',
                        width: '10%'


                    },
                ]
            });


        });
    </script>
@endpush
