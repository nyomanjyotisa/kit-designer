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

class SizeController extends Controller
{

    /**
     * Show the Size dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(): View
    { 
        return view('inventory.sizes.list');
    }

    /**
     * Show Size List
     *
     * @param Request $request
     * @return mixed
     */ 

    public function loadDatatable_mens(Request $request){ 
        $page = !empty($request->get("start")) ? $request->get("start") : 0;
        $rows = !empty($request->get("length")) ? $request->get("length") : 10;
		$draw = !empty($request->get("draw")) ? $request->get("draw") : 1; 
		$searchkey = $request->search['value']; 
		$productset = Size::where('gender',1)->select("*")->orderby('weight','asc'); 
		if (!empty($searchkey)) {			
                $productset = $productset->where(function ($query) use ($searchkey) {
                        $query->orWhere('name', 'like', '%' . $searchkey . '%')
                                                   
                                ->orWhere('weight', 'like', '%' . $searchkey . '%')                            
                                ->orWhere('short', 'like', '%' . $searchkey . '%');                               
                    });			
        } 
		$total_rows = $productset->get()->count();
	    $all_records = array(); 
		if ($total_rows > 0) {
			$serviceData = $productset->skip($page)
					->take($rows)
					->get();
	 
			$index = 0;
			$i = 1;
			foreach ($serviceData as $value) {	  
            
				$all_records[$index]['name']   = $value->name;
			 
				$all_records[$index]['code']   = $value->short; 
				$all_records[$index]['weight']   = $value->weight; 
                $all_records[$index]['action']   ='<a href="'.url('sizes/edit/' . $value->id).'" data-id="'.$value->id.'" class=" btn btn-outline-primary btn-semi-rounded  edit_data">Edit</a>  &nbsp;<a href="'.url('sizes/delete/' . $value->id).'" data-id="'.$value->id.'" class=" btn btn-outline-primary btn-semi-rounded  edit_data">Delete</a>';
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
    public function loadDatatable_womens(Request $request){ 
        $page = !empty($request->get("start")) ? $request->get("start") : 0;
        $rows = !empty($request->get("length")) ? $request->get("length") : 10;
		$draw = !empty($request->get("draw")) ? $request->get("draw") : 1; 
		$searchkey = $request->search['value']; 
		$productset = Size::where('gender',2)->select("*")->orderby('weight','asc'); 
		if (!empty($searchkey)) {			
                $productset = $productset->where(function ($query) use ($searchkey) {
                        $query->orWhere('name', 'like', '%' . $searchkey . '%')
                                             
                                ->orWhere('weight', 'like', '%' . $searchkey . '%')                            
                                ->orWhere('short', 'like', '%' . $searchkey . '%');                               
                    });			
        } 
		$total_rows = $productset->get()->count();
	    $all_records = array(); 
		if ($total_rows > 0) {
			$serviceData = $productset->skip($page)
					->take($rows)
					->get();
	 
			$index = 0;
			$i = 1;
			foreach ($serviceData as $value) {	  
         
				$all_records[$index]['name']   = $value->name;
			 
				$all_records[$index]['code']   = $value->short; 
				$all_records[$index]['weight']   = $value->weight; 
                $all_records[$index]['action']   ='<a href="'.url('sizes/edit/' . $value->id).'" data-id="'.$value->id.'" class=" btn btn-outline-primary btn-semi-rounded  edit_data">Edit</a>  &nbsp;<a href="'.url('sizes/delete/' . $value->id).'" data-id="'.$value->id.'" class=" btn btn-outline-primary btn-semi-rounded  edit_data">Delete</a>';
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
    public function loadDatatable_kids(Request $request){ 
        $page = !empty($request->get("start")) ? $request->get("start") : 0;
        $rows = !empty($request->get("length")) ? $request->get("length") : 10;
		$draw = !empty($request->get("draw")) ? $request->get("draw") : 1; 
		$searchkey = $request->search['value']; 
		$productset = Size::where('gender',3)->select("*")->orderby('weight','asc'); 
		if (!empty($searchkey)) {			
                $productset = $productset->where(function ($query) use ($searchkey) {
                        $query->orWhere('name', 'like', '%' . $searchkey . '%')
                                              
                                ->orWhere('weight', 'like', '%' . $searchkey . '%')                            
                                ->orWhere('short', 'like', '%' . $searchkey . '%');                               
                    });			
        } 
		$total_rows = $productset->get()->count();
	    $all_records = array(); 
		if ($total_rows > 0) {
			$serviceData = $productset->skip($page)
					->take($rows)
					->get();
	 
			$index = 0;
			$i = 1;
			foreach ($serviceData as $value) {	  
            
				$all_records[$index]['name']   = $value->name;
	 
				$all_records[$index]['code']   = $value->short; 
				$all_records[$index]['weight']   = $value->weight; 
                $all_records[$index]['action']   ='<a href="'.url('sizes/edit/' . $value->id).'" data-id="'.$value->id.'" class=" btn btn-outline-primary btn-semi-rounded  edit_data">Edit</a>  &nbsp;<a href="'.url('sizes/delete/' . $value->id).'" data-id="'.$value->id.'" class=" btn btn-outline-primary btn-semi-rounded  edit_data">Delete</a>';
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
    public function loadDatatable_unisex(Request $request){ 
        $page = !empty($request->get("start")) ? $request->get("start") : 0;
        $rows = !empty($request->get("length")) ? $request->get("length") : 10;
		$draw = !empty($request->get("draw")) ? $request->get("draw") : 1; 
		$searchkey = $request->search['value']; 
		$productset = Size::where('gender',4)->select("*")->orderby('weight','asc'); 
		if (!empty($searchkey)) {			
                $productset = $productset->where(function ($query) use ($searchkey) {
                        $query->orWhere('name', 'like', '%' . $searchkey . '%')
                                         
                                ->orWhere('weight', 'like', '%' . $searchkey . '%')                            
                                ->orWhere('short', 'like', '%' . $searchkey . '%');                               
                    });			
        } 
		$total_rows = $productset->get()->count();
	    $all_records = array(); 
		if ($total_rows > 0) {
			$serviceData = $productset->skip($page)
					->take($rows)
					->get();
	 
			$index = 0;
			$i = 1;
			foreach ($serviceData as $value) {	   
				$all_records[$index]['name']   = $value->name; 
				$all_records[$index]['code']   = $value->short; 
				$all_records[$index]['weight']   = $value->weight; 
                $all_records[$index]['action']   ='<a href="'.url('sizes/edit/' . $value->id).'" data-id="'.$value->id.'" class=" btn btn-outline-primary btn-semi-rounded  edit_data">Edit</a>  &nbsp;<a href="'.url('sizes/delete/' . $value->id).'" data-id="'.$value->id.'" class=" btn btn-outline-primary btn-semi-rounded  edit_data">Delete</a>';
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
     * Size Create
     *
     * @return mixed
     */
    public function create(): mixed
    {
        try {
            return view('inventory.sizes.create');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Store Size
     *
     * @param UserRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(UserRequest $request): RedirectResponse
    { 

        try {
            // store product information
            $size = Size::create([
                'name' => $request->size,
                'gender' => $request->gender,
                'short' => $request->code,
                'weight' => $request->weight,
            ]);  
            // Create new product success message 
            return redirect('sizes')->with('success', 'New size created!');
          
            // return redirect('sizes')->with('error', 'Failed to create new product! Try again.');
        } catch (\Exception $e) {
            $bug = $e->getMessage(); 
            return redirect("sizes")->back()->with('error', $bug);
        }
    }

    /**
     * Edit Size
     *
     * @param int $id
     * @return mixed
     */
    public function edit($id): mixed
    {
        try {
            $sizes = Size::find($id); 
            if ($sizes) { 
                return view('inventory.sizes.edit', compact('sizes'));
            } 
            return redirect('404');
        } catch (\Exception $e) {
            $bug = $e->getMessage();

            return redirect()->back()->with('error', $bug);
        }
    }

    /**
     * Update Size
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request): RedirectResponse
    {
         
        // update Size info
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'size' => 'required',
            'gender' => 'required',
            'code' => 'required',
            'weight' => 'required',
        ]);  
        if ($validator->fails()) {
            return redirect()->back()->withInput()->with('error', $validator->messages()->first());
        } 
        try {
            if ($size = Size::find($request->id)) {
                $payload = [
                    'name' => $request->size,
                    'gender' => $request->gender,
                    'short' => $request->code,
                    'weight' => $request->weight, 
                ]; 
                $update = $size->update($payload); 
                return redirect()->back()->with('success', 'Size information updated succesfully!');
            }

            return redirect()->back()->with('error', 'Failed to update size! Try again.');
        } catch (\Exception $e) {
            $bug = $e->getMessage(); 
            return redirect()->back()->with('error', $bug);
        }
    }

    /**
     * Delete Size
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete($id): RedirectResponse
    {
        if ($size = Size::find($id)) {
            $size->delete();

            return redirect('sizes')->with('success', 'Size removed!');
        } 
        return redirect('sizes')->with('error', 'Size not found');
    }
}
