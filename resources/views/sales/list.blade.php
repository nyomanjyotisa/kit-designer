@extends('inventory.layout') 
@section('title', 'Sales')
@section('content')
	<div class="container-fluid">
    	<div class="page-header">
            <div class="row align-items-end">
                <div class="col-lg-8">
                    <div class="page-header-title">
                        <i class="ik ik-shopping-cart bg-green"></i>
                        <div class="d-inline">
                            <h5>Sales</h5>
                            <span>View, delete and update Sales</span>
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
                                <a href="#">Sales</a>
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
				<div class="card">
		            <div class="card-header row">
		                <div class="col col-sm-1">
		                    <div class="card-options d-inline-block">
		                        <div class="dropdown d-inline-block">
		                            <a class="nav-link dropdown-toggle" href="#" id="moreDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="ik ik-more-horizontal"></i></a>
		                            <div class="dropdown-menu dropdown-menu-left" aria-labelledby="moreDropdown">
		                                <a class="dropdown-item" href="#">Delete</a>
		                                <a class="dropdown-item" href="#">More Action</a>
		                            </div>
		                        </div>
		                    </div>
	                        
		                </div>
		                <div class="col col-sm-6">
		                    <div class="card-search with-adv-search dropdown">
		                        <form action="">
		                            <input type="text" class="form-control global_filter" id="global_filter" placeholder="Search.." required="">
		                            <button type="submit" class="btn btn-icon"><i class="ik ik-search"></i></button>
		                            <button type="button" id="adv_wrap_toggler" class="adv-btn ik ik-chevron-down dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></button>
		                            <div class="adv-search-wrap dropdown-menu dropdown-menu-right" aria-labelledby="adv_wrap_toggler">
		                                <div class="row">
		                                    <div class="col-md-12">
		                                        <div class="form-group">
		                                            <input type="text" class="form-control column_filter" id="col0_filter" placeholder="Reference No" data-column="0">
		                                        </div>
		                                    </div>
		                                    <div class="col-md-6">
		                                        <div class="form-group">
		                                            <input type="text" class="form-control column_filter" id="col1_filter" placeholder="Warehouse" data-column="1">
		                                        </div>
		                                    </div>
		                                    <div class="col-md-6">
		                                        <div class="form-group">
		                                            <input type="text" class="form-control column_filter" id="col2_filter" placeholder="Customer" data-column="2">
		                                        </div>
		                                    </div>
		                                    <div class="col-md-6">
		                                        <div class="form-group">
		                                            <select class="form-control" name="sale_status">
	                                                    <option selected="">Select Sale Status</option>
	                                                    <option value="completed">Completed</option>
	                                                    <option value="shipped">Shipped</option>
	                                                    <option value="pending">Pending</option>
	                                                </select>
		                                        </div>
		                                    </div>
		                                    <div class="col-md-6">
		                                        <div class="form-group">
		                                            <select class="form-control" name="sale_status">
	                                                    <option selected="">Select Payment Status</option>
	                                                    <option value="pending">Pending</option>
	                                                    <option value="due">Due</option>
	                                                    <option value="Paid">Paid</option>
	                                                </select>
		                                        </div>
		                                    </div>
		                                </div>
		                                <button class="btn btn-theme">Search</button>
		                            </div>
		                        </form>
		                    </div>
		                </div>
		                <div class="col col-sm-5">
		                    <div class="card-options text-right">
		                        <span class="mr-5" id="top">1 - 50 of 2,500</span>
		                        <a href="#"><i class="ik ik-chevron-left"></i></a>
		                        <a href="#"><i class="ik ik-chevron-right"></i></a>
		                        <a href="/sales/create" class=" btn btn-outline-primary btn-semi-rounded">Add Sale</a>
		                    </div>
		                </div>
		            </div>
		            <div class="card-body">
		                <table id="saleTable" class="table">
		                    <thead>
		                        <tr>
		                            <!-- <th class="nosort" width="10">
		                                <label class="custom-control custom-checkbox m-0">
		                                    <input type="checkbox" class="custom-control-input" id="selectall" name="" value="option2">
		                                    <span class="custom-control-label">&nbsp;</span>
		                                </label>
		                            </th>
                                    <th></th> -->
		                            <th class="nosort">Order Number</th>
		                            <th>Customer</th>
		                            <th>Qty</th>
		                            <th>Delivery Date</th>
		                            <th>Paid</th>
		                            <th>Status</th> 
                                    <th>Action</th> 
		                        </tr>
		                    </thead>
		                    <!-- <tbody>
		                        <tr>
		                            <td>
		                                <label class="custom-control custom-checkbox">
		                                    <input type="checkbox" class="custom-control-input select_all_child" id="" name="" value="option2">
		                                    <span class="custom-control-label">&nbsp;</span>
		                                </label>
		                            </td>
                                    <td><img src="../img/widget/p1.jpg" alt="" class="img-fluid img-20"></td>
		                            <td><a href="#InvoiceModal" data-toggle="modal" data-target="#InvoiceModal" class=" font-weight-bold">REF_0011</a></td>
		                            <td>John Doe</td>
		                            <td>1</td>
		                            <td><span class="badge badge-pill badge-success mb-1">Shipping required by 02/05/2022</span></td>
		                            <td>$720</td>
		                            <td><span class="badge badge-pill badge-danger mb-1">Pre Production</span></td> 
                                    <td><div class="table-actions text-left" ><a href="#"><i class="ik ik-eye"></i></a><a href="#"><i class="ik ik-edit-2"></i></a><a href="#"><i class="ik ik-trash-2"></i></a></div></td>
                                    <!-- New / submitted to Factory -->
		                        </tr> 
		                    </tbody> -->
		                </table>
		            </div>
		        </div>
		    </div>
		</div>
	</div>
    <script>
        var controller_url = "{{route('sales-list')}}";
        $(document).ready(function() {
        var saleTable = $("#saleTable").DataTable({
            responsive: {
                details: {
                    type: 'column',
                    target: 'tr'
                }
            },
            "columns": [{
                    "data": "orderno"
                },
                {
                    "data": "customerid"
                },
                {
                    "data": "qty"
                },
                {
                    "data": "delilvery_date"
                },
                {
                    "data": "paid"
                },
                {
                    "data": "status"
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
                } ,
                {
                    targets: [5],
                    searchable: true,
                    sortable: true
                },
                {
                    targets: [6],
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
                        window.location.href = '{{route("sales-list")}}';
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