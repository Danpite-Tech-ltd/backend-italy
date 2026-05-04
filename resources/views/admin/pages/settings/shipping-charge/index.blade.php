@extends('admin.layout.app')

@push('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/2.3.2/css/dataTables.bootstrap5.min.css">

@endpush


@section('content')

    {{--    <div class="row">--}}
    {{--        <div class="col-12">--}}
    {{--            <div class="page-title-box d-sm-flex align-items-center justify-content-end">--}}
    {{--                <h4 class="mb-sm-0 font-size-18">Admins</h4>--}}

    {{--                <div class="page-title-right">--}}
    {{--                    <ol class="breadcrumb m-0">--}}
    {{--                        <li class="breadcrumb-item"><a href="javascript: void(0);">Pages</a></li>--}}
    {{--                        <li class="breadcrumb-item active">Admins</li>--}}
    {{--                    </ol>--}}
    {{--                </div>--}}

    {{--            </div>--}}
    {{--        </div>--}}
    {{--    </div>--}}

    {{-- Table Starts--}}

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">

                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="card-title mb-0">Shipping Charge List</h4>
                        {{--                                                       @can('Create Admin')--}}
                        {{--                                                       @if(Auth::guard('admin')->user()->can('Create Admin'))--}}
                        <button class="btn btn-md btn-secondary" data-bs-toggle="modal"
                                data-bs-target="#createAdminModal">
                            Add Shipping charge
                        </button>
                        {{--                                                        @endcan--}}
                        {{--                                                        @endif--}}
                    </div>

                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table mb-0  nowrap w-100 dataTable no-footer dtr-inline table-striped"
                               id="adminTable">
                            <thead>
                            <tr>
                                <th>SL</th>
                                <th>Delivery Area</th>
                                <th>Charge</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>

                            @forelse($shippingCharges as $charge)

                                <tr>
                                    <td>{{ $charge->id }}</td>
                                    <td>{{ $charge->area_name }}</td>
                                    <td>{{ $charge->delivery_charge }}</td>
                                    <td>

                                        @if( $charge->status == 1)
                                            <a class="badge bg-info">Active</a>

                                        @else
                                            <a class="badge bg-danger">Inactive</a>
                                         @endif

                                    </td>

                                    <td>
                                        <div class="d-flex gap-3">
                                            <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#editAdminModal{{ $charge->id }}" class="btn btn-sm btn-primary"><i class="fas fa-edit"></i></a>
                                            <form method="post" id="delete-form-{{$charge->id}}" action="{{ route('admin.shipping-charge.destroy',$charge->id) }}">
                                                @csrf
                                                @method('delete')
                                                <button type="submit" class="btn btn-sm btn-danger" ><i class="fas fa-trash"></i></button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>

                                {{--    Edit Categories Modal--}}
                                <div class="modal fade" id="editAdminModal{{ $charge->id }}" tabindex="-1" aria-labelledby="exampleModalLabel"
                                     style="display: none;" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Edit Admin</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form name="form2" method="post" action="{{ route('admin.shipping-charge.update',$charge->id) }}" enctype="multipart/form-data">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="mb-3">
                                                        <label for="Name" class="col-form-label">Delivery Area</label>
                                                        <input type="text" class="form-control" name="area_name" value="{{ $charge->area_name ?? '' }}" required>
                                                    </div>

                                                    <div class="mb-3">
                                                        <label for="email" class="col-form-label">Charge</label>
                                                        <input type="number" class="form-control" value="{{ $charge->delivery_charge ?? '' }}" name="delivery_charge">
                                                    </div>

                                                    <div>
                                                        <label for="email" class="col-form-label">Status</label>
                                                        <select class="form-control" name="status">
                                                            <option value="1" @if($charge->status == 1) selected @endif>Active</option>
                                                            <option value="0" @if($charge->status == 0) selected @endif>Inactive</option>
                                                        </select>

                                                    </div>

                                                    <input id="id" type="number" hidden>

                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                        <button type="submit" class="btn btn-primary">Submit</button>
                                                    </div>
                                                    <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @empty
                            @endforelse

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

    {{--    Create Admin Modal--}}
    <div class="modal fade" id="createAdminModal" tabindex="-1" aria-labelledby="exampleModalLabel"
         style="display: none;" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Shipping Charge</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form name="form" method="post" action="{{ route('admin.shipping-charge.store') }}"
                          enctype="multipart/form-data">
                        @csrf

                        <div class="mb-3">
                            <label for="Name" class="col-form-label">Delivery Area</label>
                            <input type="text" class="form-control" name="area_name" required>
                        </div>

                        <div class="mb-3">
                            <label for="email" class="col-form-label">Charge</label>
                            <input type="number" class="form-control" name="delivery_charge">
                        </div>

                        <div>
                            <label for="email" class="col-form-label">Status</label>
                            <select class="form-control" name="status">
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>

                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>



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

            var token = $("input[name='_token']").val();

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
                    {extend: 'csv', className: 'btn btn-info btn-sm', text: 'CSV Export'},
                    {extend: 'excel', className: 'btn btn-success btn-sm', text: 'Excel Export'},

                ],

                order: [
                    [0, 'asc']
                ],
            });

        });
    </script>
@endpush
