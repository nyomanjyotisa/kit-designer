@extends('inventory.layout')
@section('title', 'Designs')
@section('content')

<div class="container-fluid">
    <div class="page-header">
        <div class="row align-items-end">
            <div class="col-lg-8">
                <div class="page-header-title">
                    <i class="ik ik-headphones bg-green"></i>
                    <div class="d-inline">
                        <h5>Designs</h5>
                        <span>View, delete and update designs</span>
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
                            <a href="#">Designs</a>
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
                            <a href="{{route('create-designproduct')}}"
                                class="btn btn-outline-primary btn-semi-rounded">Add Product</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <table id="DesignTable" class="table">
                        <thead>
                            <tr>
                                <th class="nosort" width="10">
                                    <label class="custom-control custom-checkbox m-0">
                                        <input type="checkbox" class="custom-control-input" id="selectall" name=""
                                            value="option2">
                                        <span class="custom-control-label">&nbsp;</span>
                                    </label>
                                </th>
                                <!-- <th class="nosort">Image</th> -->
                                <th>Name</th> 
                                <th>Thumbnail</th>
                                <th>Tag</th>
                                <th>Category</th>
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
var controller_url = "{{route('design-list')}}";

$(document).ready(function() {
    var SizeTable = $("#DesignTable").DataTable({
        responsive: {
            details: {
                type: 'column',
                target: 'tr'
            }
        },
        "columns": [{
                "data": "checkbox"
            },
            {
                "data": "name"
            },
            {
                "data": "thumbnail"
            },
            {
                "data": "tag"
            },
            {
                "data": "category"
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
                    window.location.href = '{{route("size-list")}}';
                },
            }

        },
        dom: "<'pmd-card-title'<'data-table-responsive pull-right' f>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'pmd-card-footer' <'pmd-datatable-pagination' l i p>>",


    });
});

$(".show_data").click(function(){
	$("#p_"+$(this).data("id")).removeClass('hidden').addClass("show");
	 
});
</script>
@endpush
@endsection