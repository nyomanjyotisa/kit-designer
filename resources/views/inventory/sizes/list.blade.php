@extends('inventory.layout')
@section('title', 'Sizes')
@section('content')

<div class="container-fluid">
    <div class="page-header">
        <div class="row align-items-end">
            <div class="col-lg-8">
                <div class="page-header-title">
                    <i class="ik ik-headphones bg-green"></i>
                    <div class="d-inline">
                        <h5>Sizes</h5>
                        <span>View, delete and update product sets</span>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <nav class="breadcrumb-container" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="/dashboard"><i class="ik ik-home"></i></a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="#">Sizes</a>
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <div class="row">
	  
        <!-- list layout 1 start -->
        <div class="col-md-12">
            <div class="card">
                <div class="card-header row"> 
                    <div class="col col-sm-12"> 
                        <div class="card-options text-right">  
                            <a href="{{route('create-size')}}"
                                class="btn btn-outline-primary btn-semi-rounded">Add Sizes</a>
                        </div>
                    </div>
                </div>
                <div class="card-body"> 
                    <h2>Mens</h2>
                    <table id="SizeTable" class="table">
                        <thead>
                            <tr> 
                                <th>Name</th> 
                                <th>Code</th>
                                <th>Weight</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                    </table>
                    <hr>
                    <h2>Womens</h2>
                    <table id="SizeTable_womens" class="table">
                        <thead>
                            <tr> 
                                <th>Name</th> 
                                <th>Code</th>
                                <th>Weight</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                    </table>
                    <h2>Kids</h2>
                    <table id="SizeTable_kids" class="table">
                        <thead>
                            <tr> 
                                <th>Name</th> 
                                <th>Code</th>
                                <th>Weight</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                    </table>
                    <h2>Unisex</h2>
                    <table id="SizeTable_unisex" class="table">
                        <thead>
                            <tr> 
                                <th>Name</th> 
                                <th>Code</th>
                                <th>Weight</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
        <!-- list layout 1 end -->
        <div class="col-md-12">
            <hr>
        </div>
        <!-- list layout 2 -->

        <!-- list layout 2 end -->
    </div>
</div>

@push('script')
<script src="{{ asset('plugins/amcharts/amcharts.js') }}"></script>
<script src="{{ asset('plugins/amcharts/gauge.js') }}"></script>
<script src="{{ asset('plugins/amcharts/serial.js') }}"></script>
<script src="{{ asset('plugins/amcharts/themes/light.js') }}"></script>
<script src="{{ asset('plugins/amcharts/animate.min.js') }}"></script>
<script src="{{ asset('plugins/amcharts/pie.js') }}"></script>
<script src="{{ asset('plugins/ammap3/ammap/ammap.js') }}"></script>
<script src="{{ asset('plugins/ammap3/ammap/maps/js/usaLow.js') }}"></script>
<script src="{{ asset('js/product.js') }}"></script>

<script>
var controller_url = "{{route('size-list')}}";

$(document).ready(function() {
    var SizeTable = $("#SizeTable").DataTable({
        responsive: {
            details: {
                type: 'column',
                target: 'tr'
            }
        },
        "columns": [ 
            {
                "data": "name"
            } , 
            {
                "data": "code"
            },  {
                "data": "weight"
            },
            {
                "data": "action"
            },

        ],
        columnDefs: [{
                width: '20%',
                targets: [0],
                searchable: true,
                sortable: false
            },
            {
                width: '20%',
                targets: [1],
                searchable: true,
                sortable: false
            },
            {
                targets: [2],
                searchable: true,
                sortable: false
            },
            {
                targets: [3],
                searchable: true,
                sortable: false
            }  

        ],
        "aaSorting": [],
        // order: [1, 'asc'],
        bFilter: false,
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
            "url": controller_url + "/loadDatatable_mens",
            "type": "GET",
            "async": false,
            "data": function(d) {

            },
            "statusCode": {
                401: function(data) {
                    window.location.href = '{{route("size-list")}}';
                },
            }

        },
        dom: "<'pmd-card-title'<'data-table-responsive pull-right' f>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'pmd-card-footer' <'pmd-datatable-pagination' l i p>>", 
    });


    var SizeTable_womens = $("#SizeTable_womens").DataTable({
        responsive: {
            details: {
                type: 'column',
                target: 'tr'
            }
        },
        "columns": [ 
            {
                "data": "name"
            } , 
            {
                "data": "code"
            },  {
                "data": "weight"
            },
            {
                "data": "action"
            },

        ],
        columnDefs: [{
                width: '20%',
                targets: [0],
                searchable: true,
                sortable: false
            },
            {
                width: '20%',
                targets: [1],
                searchable: true,
                sortable: false
            },
            {
                targets: [2],
                searchable: true,
                sortable: false
            },
            {
                targets: [3],
                searchable: true,
                sortable: false
            } 

        ],
        "aaSorting": [],
        // order: [1, 'asc'],
        bFilter: false,
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
            "url": controller_url + "/loadDatatable_womens",
            "type": "GET",
            "async": false,
            "data": function(d) {

            },
            "statusCode": {
                401: function(data) {
                    window.location.href = '{{route("size-list")}}';
                },
            }

        },
        dom: "<'pmd-card-title'<'data-table-responsive pull-right' f>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'pmd-card-footer' <'pmd-datatable-pagination' l i p>>", 
    });

    var SizeTable_kids = $("#SizeTable_kids").DataTable({
        responsive: {
            details: {
                type: 'column',
                target: 'tr'
            }
        },
        "columns": [ 
            {
                "data": "name"
            } , 
            {
                "data": "code"
            },  {
                "data": "weight"
            },
            {
                "data": "action"
            },

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
            } 

        ],
       // order: [1, 'asc'],
       "aaSorting": [],
        bFilter: false,
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
            "url": controller_url + "/loadDatatable_kids",
            "type": "GET",
            "async": false,
            "data": function(d) {

            },
            "statusCode": {
                401: function(data) {
                    window.location.href = '{{route("size-list")}}';
                },
            }

        },
        dom: "<'pmd-card-title'<'data-table-responsive pull-right' f>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'pmd-card-footer' <'pmd-datatable-pagination' l i p>>", 
    });

    var SizeTable_unisex = $("#SizeTable_unisex").DataTable({
        responsive: {
            details: {
                type: 'column',
                target: 'tr'
            }
        },
        "columns": [ 
            {
                "data": "name"
            } , 
            {
                "data": "code"
            },  {
                "data": "weight"
            },
            {
                "data": "action"
            },

        ],
        columnDefs: [{
                width: '20%',
                targets: [0],
                searchable: true,
                sortable: false
            },
            {
                width: '20%',
                targets: [1],
                searchable: true,
                sortable: false
            },
            {
                targets: [2],
                searchable: true,
                sortable: false
            },
            {
                targets: [3],
                searchable: true,
                sortable: false
            } 

        ],
        "aaSorting": [],
        // order: [1, 'asc'],
        bFilter: false,
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
            "url": controller_url + "/loadDatatable_unisex",
            "type": "GET",
            "async": false,
            "data": function(d) {

            },
            "statusCode": {
                401: function(data) {
                    window.location.href = '{{route("size-list")}}';
                },
            }

        },
        dom: "<'pmd-card-title'<'data-table-responsive pull-right' f>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'pmd-card-footer' <'pmd-datatable-pagination' l i p>>", 
    });
});
 
</script>
@endpush
@endsection