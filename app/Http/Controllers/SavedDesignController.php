<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\SavedDesign;

class SavedDesignController extends Controller
{
    /**
     * Show the tags dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(): View
    {  
        return view('savedproducts.saveddesigns.list');
    }


    public function loadDatatable(Request $request){
        $page = !empty($request->get("start")) ? $request->get("start") : 0;
        $rows = !empty($request->get("length")) ? $request->get("length") : 10;
		$draw = !empty($request->get("draw")) ? $request->get("draw") : 1;
		
		$searchkey = $request->search['value'];
		
		$order = SavedDesign::select(["saved_designs.id as id","design", "customers.name as name", "customers.email as email", "country", "saved_designs.created_at as created_at"])
            ->join('customers', 'customers.id', '=', 'customer_id')->orderBy('id', 'desc');
		
		if (!empty($searchkey)) {
            $order = $order->where(function ($query) use ($searchkey) {
                $query->orWhere('name', 'like', '%' . $searchkey . '%')
                    ->orWhere('email', 'like', '%' . $searchkey . '%')  ;                        
            });
        }
		$total_rows = $order->get()->count();
	    $all_records = array();
	   
		if ($total_rows > 0) {
			$orderData = $order->skip($page)->take($rows)->get();
			$index = 0;
			$i = 1;
			foreach ($orderData as $value) {
				$all_records[$index]['id']   = $value->id; 
				$all_records[$index]['designs']   = '<img src="/img/saved_designs/'.$value->design.'" height="50"/>'; 
				$all_records[$index]['name']   = $value->name; 
				$all_records[$index]['email']   = $value->email; 
				$all_records[$index]['country']   = '<img src="/img/flags/'.strtolower($value->country).'.png" width="30" title="'.$value->country.'" alt="'.$value->country.'"/>'; 
				$all_records[$index]['created']   = date('d/m/y', strtotime($value->created_at)); 
                $all_records[$index]['action']   ='<div class="table-actions text-left" ><a href="#"><i class="ik ik-eye"></i></a><a href="#"><i class="ik ik-edit-2"></i></a><a href="#"><i class="ik ik-trash-2"></i></a>';
				$index++;
				$i++;
			}
		}
		$response = array();
        $response['draw'] = (int) $draw;
        $response['recordsTotal'] = (int) $total_rows;
        $response['recordsFiltered'] = (int) $total_rows;
        $response['data'] = $all_records;
		return $response;
    }
}
