<?php 
namespace App\Http\Controllers; 
use App\Http\Requests\UserRequest;
use DataTables;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;
use Spatie\Permission\Models\Role;
use App\Models\Product;
use App\Models\Product_image;
use App\Models\Product_colours;
use App\Models\Size;
use App\Models\Fabric;
use App\Models\Fabric_colour; 
use App\Models\Productset; 
use App\Models\Designproduct; 
use App\Models\Category; 
use App\Models\Tags; 
use App\Models\Organization; 
use App\Models\Country; 
use App\Models\Customer; 
use App\Models\Productset_size; 
use App\Models\Sale; 
use App\Models\SalesOrder; 

use Storage;
class SalesController extends Controller
{

    /**
     * Show the tags dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function __construct()
    {
        $country = Country::get();
        $customer = Customer::get();
        $this->country = $country;
        $this->customer = $customer;
    }
    public function index(): View
    { 
       return view('sales.list');
    }
   

    // create sales start
    public function create(): mixed
    {
        try {
            $country = $this->country;
            $customer = $this->customer;
            return view('sales.create',compact('country','customer'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    } 
    // create sales end

    public function getSize($id)
    { 
        if($id){
            $productSet = Productset_size::where('productset_id',$id)->first();
            if($productSet){
                $pSet_sizes = ($productSet->size_id)?explode(",",$productSet->size_id):array();
                if(!empty($pSet_sizes)){
                    $size_array = array();
                    $i= 0;
                    foreach($pSet_sizes as $sizeid){
                        $size  = Size::find($sizeid);
                        if($size->gender=='1'){
                            $size_array['Mens'][$i]['id'] = $size->id;
                            $size_array['Mens'][$i]['gender'] = $size->gender;
                            $size_array['Mens'][$i]['name'] = $size->name;
                            $size_array['Mens'][$i]['short'] = $size->short;
                            $size_array['Mens'][$i]['qty'] = $size->qty;
                        }
                        if($size->gender=='2'){
                            $size_array['Womens'][$i]['id'] = $size->id;
                            $size_array['Womens'][$i]['gender'] = $size->gender;
                            $size_array['Womens'][$i]['name'] = $size->name;
                            $size_array['Womens'][$i]['short'] = $size->short;
                            $size_array['Womens'][$i]['qty'] = $size->qty;
                        }
                        if($size->gender=='3'){
                            $size_array['Kids'][$i]['id'] = $size->id;
                            $size_array['Kids'][$i]['gender'] = $size->gender;
                            $size_array['Kids'][$i]['name'] = $size->name;
                            $size_array['Kids'][$i]['short'] = $size->short;
                            $size_array['Kids'][$i]['qty'] = $size->qty;
                        }
                        if($size->gender=='4'){
                            $size_array['Unisex'][$i]['id'] = $size->id;
                            $size_array['Unisex'][$i]['gender'] = $size->gender;
                            $size_array['Unisex'][$i]['name'] = $size->name;
                            $size_array['Unisex'][$i]['short'] = $size->short;
                            $size_array['Unisex'][$i]['qty'] = $size->qty;
                        }
                        
                        $i++;
                        
                    }
                    echo json_encode($size_array,true); 
                }
            }else{
                echo json_encode(array(),true); 
            }
        }
    }

    // store sales start
    public function store(Request $request): RedirectResponse
    { 
//        print_r(json_encode($request->qty)) ;
// die;

        try{
            $validator = Validator::make($request->all(), [
                'delilvery_date' => 'required',
                'customerid' => 'required',  
                'orderno' => 'required',   
                'note' => 'required',  
                'source' => 'required',  
                'productset' => 'required',  
                'sale_status' => 'required',  
                'payment_status' => 'required',  
            ]); 
            if ($validator->fails()) {
                return redirect()->back()->withInput()->with('error', $validator->messages()->first());
            } 

            $name = '';  
            if ($request->hasfile('attachment')) { 
                $file = $request->file('attachment');
                if($file->extension()!='pdf'){
                    return redirect()->back()->withInput()->with('error', 'pdf file required');
                    die;
                }
                $name = time() . '.' . $file->extension();

                $file->move(public_path() . '/img/sales/', $name); 
            }   
            $orders = Sale::create([
                'delilvery_date' => $request->delilvery_date, 
                'customerid' => $request->customerid, 
                'note' => $request->note,
                'source' => $request->source, 
                'attachment'=>$name,
                'sale_status' => $request->sale_status,
                'payment_status' => $request->payment_status 
               
            ]);    
            $createOrders = SalesOrder::create([
                'salesid'=>$orders->id,
                'ordernumber'=>$request->orderno,
                'productset'=>$request->productset,
                'sizes'=>json_encode($request->qty)
            ]);
     
            return redirect('sales')->with('success', 'New sale created!'); 


        }catch (\Exception $e) {
            $bug = $e->getMessage();  
            // print_r(    $bug );die;
            return redirect()->back()->with('error', $bug);
        } 
    }
    // store sales end 

    public function loadDatatable(Request $request){
        $page = !empty($request->get("start")) ? $request->get("start") : 0;
        $rows = !empty($request->get("length")) ? $request->get("length") : 10;
		$draw = !empty($request->get("draw")) ? $request->get("draw") : 1;
		
		$searchkey = $request->search['value'];
		
		
		$order = Sale::select("*");
		
		
		if (!empty($searchkey)) {			
                $order = $order->where(function ($query) use ($searchkey) {
                        $query->orWhere('delilvery_date', 'like', '%' . $searchkey . '%')  ;                               
                    });			
        } 
		$total_rows = $order->get()->count();
	   $all_records = array();
	   
		if ($total_rows > 0) {
			$orderData = $order->skip($page)
					->take($rows)
					->get();
	 
			$index = 0;
			$i = 1;
			foreach ($orderData as $value) {	 
                $customer = Customer::find($value->customerid); 
                $all_records[$index]['orderno']   = $value->orderno; 
                $all_records[$index]['customerid']   = $customer->name; 
                $all_records[$index]['qty']   = "qty"; 
				$all_records[$index]['delilvery_date']   = $value->delilvery_date;  
				$all_records[$index]['paid']   =""; 
				$all_records[$index]['status']   = ""; 
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
