@extends('inventory.layout')
@section('title', 'Orders')
@section('content')
    <div class="container-fluid">
    	<div class="page-header">
            <div class="row align-items-end">
                <div class="col-lg-8">
                    <div class="page-header-title">
                        <i class="ik ik-headphones bg-blue"></i>
                        <div class="d-inline">
                            <h5>Orders</h5>
                            <span>Add and view orders</span>
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
                            <a href="#">Orders</a>
                            </li> 
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
            
                <div class="card table-card"> 
                <div class="card-header"> 
                    <div class="col col-sm-12">
                        <div class="card-options text-right"> 
                            <a href="{{ route('create-order') }}" class="btn btn-outline-primary btn-semi-rounded">Add Order</a>
                        </div>
                    </div>
                </div>
                <div class="card-header">
                        <h3>Order List</h3>
                        <div class="card-header-right">
                            <ul class="list-unstyled card-option">
                                <li><i class="ik ik-chevron-left action-toggle"></i></li>
                                <li><i class="ik ik-minus minimize-card"></i></li>
                                <li><i class="ik ik-x close-card"></i></li>
                            </ul>
                        </div>
                    </div>
                    <div class="card-body">
                    <div class="">
                            <table class="table table-hover mb-0" id="orderTable">
                                <thead>
                                    <tr>
                                        <th>Order Id</th>
                                        <th>Firstname</th>
                                        <th>Lastname</th>
                                        <th>Address</th>
                                        <th>Action</th> 
                                    </tr>
                                </thead> 
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script>
        var controller_url = "{{route('order-list')}}";
        $(document).ready(function() {
    var orderTable = $("#orderTable").DataTable({
        responsive: {
            details: {
                type: 'column',
                target: 'tr'
            }
        },
        "columns": [{
                "data": "ordernumber"
            },
            {
                "data": "firstname"
            },
            {
                "data": "lastname"
            },
            {
                "data": "address"
            },
            {
                "data": "action"
            } 
        ],
        columnDefs: [{
                width: '20%',
                targets: [0],
                searchable: true,
                sortable: true
            },
            {
                width: '20%',
                targets: [1],
                searchable: true,
                sortable: true
            },
            {
                targets: [2],
                searchable: true,
                sortable: true
            },
            {
                targets: [3],
                searchable: true,
                sortable: true
            },
            {
                targets: [4],
                searchable: true,
                sortable: true
            } 
        ],
        order: [1, 'asc'],
        bFilter: true,
        bLengthChange: true,
        pagingType: "simple",
        "paging": true,
        "searching": true,
        "language": {
            "info": " _START_ - _END_ of _TOTAL_ ",
            "sLengthMenu": "<span class='custom-select-title'>Rows per page:</span> <span class='t'> _MENU_ </span>",
            "sSearch": "",
            "sSearchPlaceholder": "Search",
            "paginate": {
                "sNext": " Next",
                "sPrevious": " Previous"
            },
        },
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
                    window.location.href = '{{route("order-list")}}';
                },
            }

        },
        dom: "<'pmd-card-title'<'data-table-responsive pull-right' f>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'pmd-card-footer' <'pmd-datatable-pagination' l i p>>",


    });
});
    </script>
@endsection
 