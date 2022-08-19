@extends('inventory.layout')
@section('title', 'Quote Requests')
@section('content')
    @push('head')
        <link rel="stylesheet" href="{{ asset('plugins/DataTables/datatables.min.css') }}">
    @endpush

    <div class="container-fluid">
    	<div class="page-header">
            <div class="row align-items-end">
                <div class="col-lg-8">
                    <div class="page-header-title">
                        <i class="ik ik-inbox bg-blue"></i>
                        <div class="d-inline">
                            <h5>Kit Designer Inquiries</h5>
                            <span>Customer contact throught the kit designer</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <nav class="breadcrumb-container" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="#"><i class="ik ik-home"></i></a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="#">Quote Requests</a>
                            </li> 
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card table-card"> 
                    <div class="card-body">
                        <table class="table table-hover mb-0" id="quoteRequestsTable">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th class="nosort">Designs</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Country</th>
                                    <th>Created</th>
                                    <th class="nosort">Action</th> 
                                </tr>
                            </thead> 
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        var controller_url = "{{route('quote-requests')}}";
        $(document).ready(function() {
            var orderTable = $("#quoteRequestsTable").DataTable({
                responsive: {
                    details: {
                        type: 'column',
                        target: 'tr',
                    }
                },
                "columns": [{
                        "data": "id"
                    },
                    {
                        "data": "designs"
                    },
                    {
                        "data": "name"
                    },
                    {
                        "data": "email"
                    },
                    {
                        "data": "country"
                    },
                    {
                        "data": "created"
                    },
                    {
                        "data": "action"
                    } 
                ],
                columnDefs: [{
                        width: '10%',
                        type: 'num',
                        orderable: true,
                        targets: [0],
                        searchable: true,
                        sortable: true
                    },
                    {
                        width: '15%',
                        targets: [1],
                        searchable: false,
                        sortable: false
                    },
                    {
                        width: '22.5%',
                        targets: [2],
                        searchable: true,
                        sortable: true
                    },
                    {
                        width: '22.5%',
                        targets: [3],
                        searchable: true,
                        sortable: true
                    },
                    {
                        width: '10%',
                        targets: [4],
                        searchable: true,
                        sortable: true
                    },
                    {
                        width: '10%',
                        targets: [5],
                        searchable: true,
                        sortable: true
                    },
                    {
                        width: '10%',
                        targets: [6],
                        searchable: false,
                        sortable: false
                    } 
                ],
                "processing": true,
                "serverSide": true,
                ajax: {
                    "url": controller_url + "/loadDatatable",
                    "type": "GET",
                    "async": false,
                    "data": function(d) {
                    },
                    "statusCode": {
                        401: function(data) {
                            window.location.href = controller_url;
                        },
                    }
                },
                dom: "<'row'<'col-sm-2'l><'col-sm-7 text-center'B><'col-sm-3'f>>tipr",
                buttons: [
                    {
                        extend: 'copy',
                        className: 'btn-sm btn-info', 
                        header: false,
                        footer: true,
                        exportOptions: {
                            // columns: ':visible'
                        }
                    },
                    {
                        extend: 'csv',
                        className: 'btn-sm btn-success',
                        header: false,
                        footer: true,
                        exportOptions: {
                            // columns: ':visible'
                        }
                    },
                    {
                        extend: 'excel',
                        className: 'btn-sm btn-warning',
                        header: false,
                        footer: true,
                        exportOptions: {
                            // columns: ':visible',
                        }
                    },
                    {
                        extend: 'pdf',
                        className: 'btn-sm btn-primary',
                        header: false,
                        footer: true,
                        exportOptions: {
                            // columns: ':visible'
                        }
                    },
                    {
                        extend: 'print',
                        className: 'btn-sm btn-default',
                        header: true,
                        footer: false,
                        orientation: 'landscape',
                        exportOptions: {
                            // columns: ':visible',
                            stripHtml: false
                        }
                    }
                ]
            });

        });
    </script>
    <!-- push external js -->
    @push('script')
        <script src="{{ asset('plugins/DataTables/datatables.min.js') }}"></script>
        <script src="{{ asset('js/datatables.js') }}"></script>
    @endpush
@endsection
 