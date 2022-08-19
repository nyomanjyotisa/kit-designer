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

class FabricController extends Controller
{

    /**
     * Show the users dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(): View
    {
        // echo "sizes";
        return view('inventory.fabric.list');
    }

    /**
     * Show User List
     *
     * @param Request $request
     * @return mixed
     */
    public function getSizeList(Request $request): mixed
    {
        $data = Size::get();
        return view('inventory.fabric.list', compact('data'));
    }


    public function loadDatatable(Request $request){
 
        $page = !empty($request->get("start")) ? $request->get("start") : 0;
        $rows = !empty($request->get("length")) ? $request->get("length") : 10;
		$draw = !empty($request->get("draw")) ? $request->get("draw") : 1;
		
		$searchkey = $request->search['value'];
		
		
		$fabrics = Fabric::select("*");
		
		
		if (!empty($searchkey)) {			
                $fabrics = $fabrics->where(function ($query) use ($searchkey) {
                        $query->orWhere('name', 'like', '%' . $searchkey . '%')  ;                               
                    });			
        } 
		$total_rows = $fabrics->get()->count();
	   $all_records = array();
	   
		if ($total_rows > 0) {
			$fabricData = $fabrics->skip($page)
					->take($rows)
					->get();
	 
			$index = 0;
			$i = 1;
			foreach ($fabricData as $value) {	  
				$all_records[$index]['name']   = $value->fabric; 
                $all_records[$index]['action']   ='<a href="'.url('fabrics/edit/' . $value->id).'" data-id="'.$value->id.'" class=" btn btn-outline-primary btn-semi-rounded  edit_data">Edit</a>';
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

    /**
     * User Create
     *
     * @return mixed
     */
    public function create(): mixed
    {
        try {
            return view('inventory.fabric.create');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Store User
     *
     * @param UserRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {  
        try {
            // store Fabric information  
            $fabric = Fabric::create([
                'fabric' => $request->fabric,
               
            ]);    
             if(!empty($request->colour)){ 
                foreach($request->colour as $colorString){
                    $colorArray = ($colorString)?explode('|',$colorString):array();
                    if(!empty($colorArray)){
                        $fabric_colour = Fabric_colour::create([
                            'name' => $colorArray[0],
                            'pms' => $colorArray[1],
                            'hex' => str_replace("#","",$colorArray[2]),
                            'fabricId'=> $fabric->id 
                        ]);
                    }
                }
                  
            }
            // Create new product success message 
            return redirect('fabrics')->with('success', 'New fabric created!');
            // //     } 
            // return redirect('fabrics')->with('error', 'Failed to create new fabric! Try again.');
        } catch (\Exception $e) {
            $bug = $e->getMessage();
            //  print_r($bug);
           return redirect("tags")->back()->with('error', $bug);
        }
    }

    /**
     * Edit User
     *
     * @param int $id
     * @return mixed
     */
    public function edit($id): mixed
    {
      
        try {
            $fabric = Fabric::find($id); 
           
            if ($fabric) { 
                $fabric_colour = Fabric_colour::where('fabricId',$fabric->id)->get();
                return view('inventory.fabric.edit', compact('fabric','fabric_colour'));
            }

            return redirect('404');
        } catch (\Exception $e) {
            $bug = $e->getMessage(); 
            return redirect()->back()->with('error', $bug);
        }
    }

    /**
     * Update User
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request): RedirectResponse
    {
        // update user info
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'fabric' => 'required',
            
        ]); 
        if ($validator->fails()) {
            return redirect()->back()->withInput()->with('error', $validator->messages()->first());
        } 
        try {
            if ($fabric = Fabric::find($request->id)) {
                $payload = [
                    'fabric' => $request->fabric, 
                     
                ];
                $update = $fabric->update($payload); 
                return redirect()->back()->with('success', 'Fabric information updated succesfully!');
            }

            // return redirect()->back()->with('error', 'Failed to update size! Try again.');
        } catch (\Exception $e) {
            $bug = $e->getMessage();
// print_r( $bug);die;
            return redirect()->back()->with('error', $bug);
        }
    }



    //save Fabric Colour start
    public function savecolour(Request $request): RedirectResponse
    {

        // print_r($request->all());die;
        // update user info
        try{
                $validator = Validator::make($request->all(), [
                    'id' => 'required',
                    'colourName' => 'required',
                    'pms' => 'required',
                    'hex' => 'required',
                    
                ]); 
                if ($validator->fails()) {
                    return redirect()->back()->withInput()->with('error', $validator->messages()->first());
                } 

                $fabric_colour = Fabric_colour::create([
                    'name' => $request->colourName,
                    'pms' => $request->pms,
                    'hex' => str_replace("#","",$request->hex),
                    'fabricId'=>$request->id
                
                ]);  
                return redirect()->back()->with('success', 'Fabric information updated succesfully!');
            } catch (\Exception $e) {
                $bug = $e->getMessage();
        // print_r( $bug);die;
                return redirect()->back()->with('error', $bug);
            }
    }
    //save Fabric Colour end

    /**
     * Delete User
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete($id): RedirectResponse
    {
        if ($user = User::find($id)) {
            $user->delete();

            return redirect('users')->with('success', 'User removed!');
        }

        return redirect('users')->with('error', 'User not found');
    }
    public function deletecolour(Request $request): RedirectResponse
    {

        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'colours'=>'required' 
        ]); 
        if ($validator->fails()) {
            return redirect()->back()->withInput()->with('error', $validator->messages()->first());
        } 
        if(!empty($request->colours)){
            foreach($request->colours as $colourId){
                if ($fabric_colour = Fabric_colour::find($colourId)) {
                    $fabric_colour->delete(); 
                }
            }
            return redirect()->back()->with('success', 'Fabric information updated succesfully!');
        }
        
        
        

        return redirect()->back()->with('error', $bug);
    }
}
