@extends('inventory.layout')
@section('title', 'Category')
@section('content')

<div class="container-fluid">
    <div class="page-header">
        <div class="row align-items-end">
            <div class="col-lg-8">
                <div class="page-header-title">
                    <i class="ik ik-headphones bg-green"></i>
                    <div class="d-inline">
                        <h5>Category</h5>
                        <span>View, delete and update category</span>
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
                            <a href="{{url('tags')}}">Tags</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="#">Category</a>
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
                    <ul class="nav justify-content-end float-left">
                        <li class="nav-item">
                            <a href="{{url('tags')}}" class="nav-link " aria-current="page">Tags</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{url('categories')}}" class="nav-link  btn-primary active" aria-current="page">Categories</a>
                        </li>
                    </ul>
                        <div class="card-options text-right"> 
                            <!-- <a href="{{route('create-fabric')}}"
                                class="btn btn-outline-primary btn-semi-rounded">Add Category</a> -->
                                <button class="btn btn-outline-primary btn-rounded-20" href="#categoryAdd" data-toggle="modal" data-target="#categoryAdd">
                                Add Category
                            </button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <table id="CategoryTable" class="table">
                        <thead>
                            <tr> 
                                <!-- <th class="nosort">Image</th> -->
                                <th>Name</th> 
                                <th>Matchine Name</th> 
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
 <!-- category add modal-->
 <div class="modal fade edit-layout-modal pr-0 " id="categoryAdd" tabindex="-1" role="dialog" aria-labelledby="categoryAddLabel" aria-hidden="true">
        <div class="modal-dialog w-300" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="categoryAddLabel">{{ __('Add Category')}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body"> 
                    <form method="post" action="{{route('store-category')}}">
                        @csrf
                        <div class="form-group">
                            <label class="d-block">Category Title</label>
                            <input type="text" name="name" required="" class="form-control" placeholder="Enter Category Title">
                        </div> 
                        <div class="form-group">
                            <input class="btn btn-primary" type="submit" name="Save" value="Save">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div> 
    <!-- category edit modal --> 
 <div class="modal fade edit-layout-modal pr-0 " id="categoryEdit" tabindex="-1" role="dialog" aria-labelledby="categoryEditLabel" aria-hidden="true">
        <div class="modal-dialog w-300" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="categoryEditLabel">{{ __('Edit Category')}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body"> 
                    <form method="post" action="{{route('update-category')}}">
                        @csrf
                        <div class="form-group">
                            <label class="d-block">Category Title</label>
                            <input type="hidden" id="categoryid" name="id" >
                            <input type="text" name="name" id="categoryname" required="" class="form-control" placeholder="Enter Category Title">
                        </div>
                        <div class="form-group">
                            <label class="d-block">Matchine Name</label>
                            <span id="matchine_name_edit" name="matchine_name"></span>
                        </div>
                        
                        <div class="form-group">
                            <input class="btn btn-primary" type="submit" name="Save" value="Save">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div> 
    <!-- category edit modal -->
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
var controller_url = "{{route('category-list')}}"; 
$(document).ready(function() {
    var CategoryTable = $("#CategoryTable").DataTable({
        responsive: {
            details: {
                type: 'column',
                target: 'tr'
            }
        },
        "columns": [ 
            {
                "data": "name"
            },
            {
                "data": "matchine_name"
            },
            {
                "data": "action"
            }

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
            "url": controller_url + "/loadDatatable",
            "type": "GET",
            "async": false,
            "data": function(d) {

            },
            "statusCode": {
                401: function(data) {
                    window.location.href = '{{route("category-list")}}';
                },
            }

        },
        dom: "<'pmd-card-title'<'data-table-responsive pull-right' f>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'pmd-card-footer' <'pmd-datatable-pagination' l i p>>",


    });

    
$(".edit_data").click(function(){ 
    $("#categoryid").val('');
    $("#name_edit").val('');
    $("#matchine_name_edit").text("");
    var id = $(this).data("id");
    var categoryname = $(this).data("name"); 
    var matchine_name = $(this).data("matchine_name");
    $("#categoryid").attr("value",id);
    $("#categoryname").attr("value",categoryname);
    $("#matchine_name_edit").text(matchine_name);
    // return false;
});
});

$(".show_data").click(function(){
	$("#p_"+$(this).data("id")).removeClass('hidden').addClass("show");
	 
}); 

$(".show_data").click(function(){
	$("#p_"+$(this).data("id")).removeClass('hidden').addClass("show");
	 
});

</script>
@endpush
@endsection