@extends('inventory.layout')
@section('title', 'Tags')
@section('content')

<div class="container-fluid">
    <div class="page-header">
        <div class="row align-items-end">
            <div class="col-lg-8">
                <div class="page-header-title">
                    <i class="ik ik-headphones bg-green"></i>
                    <div class="d-inline">
                        <h5>Tags</h5>
                        <span>View, delete and update Tags</span>
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
                            <a href="#">Tags</a>
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
                            <a href="{{url('tags')}}" class="nav-link btn-primary active " aria-current="page">Tags</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{url('categories')}}" class="nav-link" aria-current="page">Categories</a>
                        </li>
                    </ul>
                        <div class="card-options text-right"> 
                            <!-- <a href="{{route('create-fabric')}}"
                                class="btn btn-outline-primary btn-semi-rounded">Add Category</a> -->
                                <button class="btn btn-outline-primary btn-rounded-20" href="#tagsAdd" data-toggle="modal" data-target="#tagsAdd">
                                Add Tags
                            </button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <table id="TagsTable" class="table">
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
                                <th>Matchine Name</th> 
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
 <!-- category add modal-->
 <div class="modal fade edit-layout-modal pr-0 " id="tagsAdd" tabindex="-1" role="dialog" aria-labelledby="tagsAddLabel" aria-hidden="true">
        <div class="modal-dialog w-300" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="tagsAddLabel">{{ __('Add Tag')}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body"> 
                    <form method="post" action="{{route('store-tag')}}">
                        @csrf
                        <div class="form-group">
                            <label class="d-block">Tag Name</label>
                            <input type="text" name="tagname" required="" class="form-control" placeholder="Enter Tag">
                        </div>
                        <div class="form-group">
                            <label class="d-block">Category</label>
                            <select name="categoryid" id="categoryid" required="" class="form-control">
                                <option value="">Select Category</option> 
                                @if(!empty($category))
                                    @foreach($category as $categ)
                                    <option value="{{$categ->id}}">{{$categ->name}}</option> 
                                    @endforeach
                                @endif
                            </select>
                            
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
 <div class="modal fade edit-layout-modal pr-0 " id="tagEdit" tabindex="-1" role="dialog" aria-labelledby="tagEditLabel" aria-hidden="true">
        <div class="modal-dialog w-300" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="categoryEditLabel">{{ __('Edit Tag')}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body"> 
                    <form method="post" action="{{route('update-tag')}}">
                        @csrf
                        <div class="form-group">
                            <label class="d-block">Tag Title</label>
                            <input type="hidden" id="id" name="id" >
                            <input type="text" name="name" id="name" required="" class="form-control" placeholder="Enter tag">
                        </div>
                        <div class="form-group">
                            <label class="d-block">Category</label>
                            <select name="tag_category"  id="tag_category" required="" class="form-control">
                                <option value="">Select Category</option> 
                                @if(!empty($category))
                                    @foreach($category as $categ)
                                        <option value="{{$categ->id}}">{{$categ->name}}</option> 
                                    @endforeach
                                @endif
                            </select> 
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
var controller_url = "{{route('tag-list')}}";

$(document).ready(function() {
    var TagsTable = $("#TagsTable").DataTable({
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
                "data": "matchine_name"
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
                    window.location.href = '{{route("category-list")}}';
                },
            }

        },
        dom: "<'pmd-card-title'<'data-table-responsive pull-right' f>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'pmd-card-footer' <'pmd-datatable-pagination' l i p>>",


    });

    
$(".edit_data").click(function(){ 
 
    $("#tagEdit #id").val(''); 
    $("#tagEdit #name").val('');
    $("#tagEdit #tag_category").val('');
    var id = $(this).data("id");
    var tagname = $(this).data("name"); 
    var categoryid = $(this).data("category");
 
    $('#tagEdit #tag_category option[value="'+categoryid+'"]').attr('selected','selected'); 
    $("#tagEdit #id").val(id);
    $("#tagEdit #name").val(tagname); 
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