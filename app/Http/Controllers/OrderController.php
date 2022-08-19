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
use App\Models\Order; 
use App\Models\Productset_size;
use App\Models\OrderItem;
use App\Models\Country; 
use Storage;
class OrderController extends Controller
{

    public function __construct()
    {
        $country = Country::get();
        $this->country = $country;
    }

    /**
     * Show the tags dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(): View
    {  
        return view('orders.list');
    }

    
    /**
     * Order Create
     *
     * @return mixed
     */
    public function create(): mixed
    {
        try { 
            $country  =$this->country;
            return view('orders.create',compact('country'));
        } catch (\Exception $e) {
            return redirect('Orders')->with('error', $e->getMessage());
        }
    }

    // store order data

    public function store(Request $request): RedirectResponse
    { 
        try{
               // update user info
            $validator = Validator::make($request->all(), [
                'firstname' => 'required',
                'lastname' => 'required',  
                'address' => 'required',  
                'city' => 'required',  
                'postcode' => 'required',  
                'emailaddress' => 'required',  
                'mobilephone' => 'required',  
                'workphone' => 'required',  
            ]); 
            if ($validator->fails()) {
                return redirect()->back()->withInput()->with('error', $validator->messages()->first());
            } 
            $get_last_Order_id = Order::max('id');
            if($get_last_Order_id){
                $ordernumber = $get_last_Order_id+1;
            }else{
                $ordernumber = 0001;
            }
            $ordernumber = $get_last_Order_id+1;
            $orders = Order::create([
                'firstname' => $request->firstname, 
                'lastname' => $request->lastname,
                'address' => $request->address,
                'city' => $request->city,
                'postcode' => $request->postcode,
                'country' => $request->country,
                'emailaddress' => $request->emailaddress,
                'mobilephone' => $request->mobilephone,
                'workphone' => $request->workphone,
                'ordernumber'=> $ordernumber 
            ]);   
     
            return redirect('orders/edit/'.$orders->id)->with('success', 'New order created!'); 
        }catch (\Exception $e) {
            $bug = $e->getMessage();  
            // print_r(    $bug );die;
            return redirect()->back()->with('error', $bug);
        } 
    }
    

     /**
     * Edit Design
     *
     * @param int $id
     * @return mixed
     */
    public function edit($id): mixed
    { 
        try {
            $orders = Order::find($id);  
            if ($orders) {    
                $OrderItem = OrderItem::where('orderid',$id)->first();  
                if( $OrderItem ){
                    $orders = Order::leftJoin('order_items', function($join) {
                        $join->on('orders.id', '=', 'order_items.orderid');
                      })
                      ->where('orders.id',$id)
                      ->first();
                }  
                // $sizes = json_decode($orders->qty,true);
                // if(!empty($sizes)){
                //     foreach($sizes as $key=>$val){
                      
                //     }
                // } 
                $country  =$this->country;
                return view('orders.edit', compact('orders','country'));
            } 
            return redirect('404');
        } catch (\Exception $e) {
            $bug = $e->getMessage(); 
            return redirect()->back()->with('error', $bug);
        }
    }

    public function loadDatatable(Request $request){
        $page = !empty($request->get("start")) ? $request->get("start") : 0;
        $rows = !empty($request->get("length")) ? $request->get("length") : 10;
		$draw = !empty($request->get("draw")) ? $request->get("draw") : 1;
		
		$searchkey = $request->search['value'];
		
		
		$order = Order::select("*");
		
		
		if (!empty($searchkey)) {			
                $order = $order->where(function ($query) use ($searchkey) {
                        $query->orWhere('firstname', 'like', '%' . $searchkey . '%')  ;                               
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
				$all_records[$index]['ordernumber']   = $value->ordernumber; 
				$all_records[$index]['firstname']   = $value->firstname; 
				$all_records[$index]['lastname']   = $value->lastname; 
				$all_records[$index]['address']   = $value->address; 
                $all_records[$index]['action']   ='<a href="'.url('orders/edit/' . $value->id).'" data-id="'.$value->id.'" class=" btn btn-outline-primary btn-semi-rounded  edit_data">Edit</a>';
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



    // Update Orders start
    public function update(Request $request): RedirectResponse
    { 


        // print_r($request->sizeqty);
        // echo json_encode($request->sizeqty,true);
        // die;
        // update productset info
        $validator = Validator::make($request->all(), [
            'id' => 'required',  
        ]); 
        if ($validator->fails()) {
            return redirect()->back()->withInput()->with('error', $validator->messages()->first());
        } 

        try{
            // add sizes for orders start
                if(isset($request->addSizes)){
                    if($request->sizes){
                    $sizes = implode(',',$request->sizes);
                    $OrderItemCreate = OrderItem::create([
                        'orderid'=>$request->id,
                        'sizes'=>$sizes,
                        'qty'=>json_encode($request->sizeqty,true),
                        'productset_id'=>$request->design_product_set_id
                    ]);
                    }
                    return redirect('orders')->with('success', 'Item added successfully!');
            }
            // add sizes for orders end

            // update orders start
            if(isset($request->SaveAndContinue)){
                if($orders = Order::find($request->id)){
                    $payload = [
                        'firstname'=>$request->firstname,
                        'lastname'=>$request->lastname,
                        'address'=>$request->address,
                        'city'=>$request->city,
                        'postcode'=>$request->firstname,
                        'country'=>$request->country,
                        'emailaddress'=>$request->emailaddress,
                        'mobilephone'=>$request->mobilephone,
                        'workphone'=>$request->workphone
                    ];
                    $orders->update($payload);
                }
                return redirect('orders')->with('success', 'Order updated successfully!');
            }
            // update orders end
        }catch (\Exception $e) {
            $bug = $e->getMessage();  
            return redirect()->back()->with('error', $bug);
        }
        
    }
    // Update Orders end
    

}
