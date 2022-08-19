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
use Storage;
class CustomersController extends Controller
{

    /**
     * Show the tags dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */ 


    public function store(Request $request): RedirectResponse
    { 
        try{
               // update user info
            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'phone' => 'required',  
                'email' => 'required',  
                'country' => 'required',  
                'city' => 'required',  
               
            ]); 
            if ($validator->fails()) {
                return redirect()->back()->withInput()->with('error', $validator->messages()->first());
            }  
            $orders = Customer::create([
                'name' => $request->name, 
                'phone' => $request->phone,
                'email' => $request->email,
                'country' => $request->country,
                'city' => $request->city  
            ]);   
     
            return redirect('sales/create')->with('success', 'New Customer created!'); 
        }catch (\Exception $e) {
            $bug = $e->getMessage();   
            return redirect()->back()->with('error', $bug);
        } 
    }

    
    
}
