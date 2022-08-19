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
use Storage;
class OrganizationController extends Controller
{

    /**
     * Show the tags dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function store(Request $request): RedirectResponse
    {   
        try { 
            $name = '';
            if ($request->hasfile('organiztion_img')) { 
                    $file = $request->file('organiztion_img'); 
                    $name = time() . '.' . $file->extension();
                    $file->move(public_path() . '/img/organization/', $name); 
            }
            
            $organization = Organization::create([
                'organization' => $request->organizationname, 
                'organiztion_img' => $name,  
            ]);   
            return redirect('orders/create')->with('success', 'New orders created!'); 
        } catch (\Exception $e) {
            $bug = $e->getMessage();  
             return redirect('orders/create')->with('error', $bug);
        }
    }


    public function getOrganization(){
        $Organization = Organization::get()->toArray();
        echo json_encode($Organization,true);
    }
     
}
