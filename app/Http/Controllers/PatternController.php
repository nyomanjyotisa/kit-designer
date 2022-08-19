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
use App\Models\Tags; 
use App\Models\Category; 
use App\Models\Designpattern; 
use App\Models\Patternstyle; 
use App\Models\Svgcolor; 
use App\Models\Styledetail; 
use Storage;
use File;
class PatternController extends Controller
{

    /**
     * Show the Design dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(): View
    {
      
       $DesignProducts = Designproduct::get();
       $product_tag = array();
       foreach($DesignProducts as $ProductTags){
         $product_tag[] = $ProductTags->design_tags;
       }   
       $protag = implode(',',$product_tag); 
       $tags = array_unique(explode(',',$protag));  
       $tagList = Tags::whereIn('id',$tags)->orderby('id','desc')->get();   
       return view('inventory.designs.list',compact('tagList','DesignProducts'));
    }

    /**
     * Show User List
     *
     * @param Request $request
     * @return mixed
     */ 
    public function loadDatatable(Request $request){ 
        $page = !empty($request->get("start")) ? $request->get("start") : 0;
        $rows = !empty($request->get("length")) ? $request->get("length") : 10;
		$draw = !empty($request->get("draw")) ? $request->get("draw") : 1; 
		$searchkey = $request->search['value'];  
		$design = Designproduct::select("*"); 
		if (!empty($searchkey)) {			
                $design = $design->where(function ($query) use ($searchkey) {
                            $query->orWhere('design_pro_name', 'like', '%' . $searchkey . '%')  ;                               
                        });			
        } 
		$total_rows = $design->get()->count();
	    $all_records = array(); 
		if ($total_rows > 0) {
			$designData = $design->skip($page)
					->take($rows)
					->get(); 
			$index = 0;
			$i = 1;
			foreach ($designData as $value) {	 
				$all_records[$index]['checkbox']   ='<label class="custom-control custom-checkbox">
                                                        <input type="checkbox" class="custom-control-input select_all_child" id="" name="" value="option2">
                                                        <span class="custom-control-label">&nbsp;</span>
                                                    </label>';
           
				 $all_records[$index]['name']   = $value->design_pro_name;
                 $all_records[$index]['thumbnail']   = ($value->design_thumbnail)? "<img src='".url('img/designs/'.$value->id.'/'.$value->design_thumbnail)."' width='50px' height='50px'>":"";
                 $designgroup = array();
                 $sport = array();
                 if($value->design_tags){
                    $designtags = explode(',',$value->design_tags); 
                    foreach($designtags as $val){
                        $tag = Tags::find($val);  
                        if($tag->tag_category==4){
                             $designgroup[] =  $tag->name;
                        }
                        if($tag->tag_category==5){
                            $sport[] =  $tag->name;
                       } 
                    } 
                } 
                $tagg = ($sport)? implode(',',$sport):""; 
				$all_records[$index]['tag']   =  ($designgroup)?"<strong>DesignGroup :</strong>".implode(',',$designgroup)."<br><strong>Sport: </strong>".$tagg:"" ; 
                $categories = array();
                if($value->design_category){
                    $category = explode(',',$value->design_category);
                    foreach($category as $categ){
                        $category = Category::find($categ);
                        $categories[] =  $category->name;
                    } 
                }  
				$all_records[$index]['category']   = ($categories)? implode(',',$categories):""; 
                $all_records[$index]['action']   ='<a href="'.url('designs/edit/' . $value->id).'" data-id="'.$value->id.'" class=" btn btn-outline-primary btn-semi-rounded  edit_data">Edit</a>&nbsp;<a href="'.url('designs/delete/' . $value->id).'" data-id="'.$value->id.'" class=" btn btn-outline-primary btn-semi-rounded  delete_data">Delete</a>';
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
     * Design Create
     *
     * @return mixed
     */
    public function create($designproduct_id): mixed
    {
        try {  
            $product_design_id = $designproduct_id;
            return view('inventory.pattern.create',compact('product_design_id'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Store Design
     *
     * @param UserRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {  
 
        try {
            // store Design information   
            $design_pattern = Designpattern::create([
                'product_design_id' => $request->product_design_id, 
                'parent_product_set' => ($request->parent_product_set)?$request->parent_product_set:0,
                'patternName' => $request->patternName,
                'patternURL' => str_replace(' ','-',$request->patternURL),
                'patternweight' => $request->patternweight 
            ]);   
            $pathDesign = public_path('img/designs/'.$request->product_design_id);
            if(!file_exists($pathDesign)){
                File::makeDirectory($pathDesign);
            }  
            $path = public_path('img/designs/'.$request->product_design_id.'/patterns');  
            if(!file_exists($path)){ 
                    File::makeDirectory($path);
                $path2 = public_path('img/designs/'.$request->product_design_id.'/patterns/'.$design_pattern->id);
                if(!file_exists($path2)){
                    File::makeDirectory($path2);
                }  
            } 
            // Create new product success message 
            return redirect('designs')->with('success', 'New Design product created!');
            
        } catch (\Exception $e) {
            $bug = $e->getMessage(); 
            // print_r($bug);die;
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
            $pattern = Designpattern::find($id);  
            if ($pattern) {  
                
                return view('inventory.pattern.edit', compact('pattern'));
            } 
            return redirect('404');
        } catch (\Exception $e) {
            $bug = $e->getMessage(); 
            return redirect()->back()->with('error', $bug);
        }
    }

    /**
     * Update Design
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request): RedirectResponse
    { 

        // update user info
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'patternName' => 'required',  
        ]); 
        if ($validator->fails()) {
            return redirect()->back()->withInput()->with('error', $validator->messages()->first());
        } 
        try {
            if ($Designpattern = Designpattern::find($request->id)) { 
             
                if(isset($request->deletebtn)){ 
                    $patternStyles = Patternstyle::where('pattern_id',$request->id)->get(); 
                    if($patternStyles){
                    foreach($patternStyles as $styles){
                      $details = Styledetail::where('styleid',$styles)->get();
                      $svgData = Svgcolor::where('styleId',$styles)->get();
                      if($svgData){
                        Svgcolor::where('styleId',$styles)->delete();
                      } 
                      if($details){
                        Styledetail::where('styleid',$styles)->delete();
                      } 
                    } 
                    Patternstyle::where('pattern_id',$request->id)->delete();
                    }
                    $Designpattern->delete(); 
                    return redirect("designs")->with('success', 'Design product pattern deleted succesfully!'); 
                }  
                $payload = [
                    'parent_product_set' => ($request->parent_product_set)?$request->parent_product_set:0,
                    'patternName' => $request->patternName,
                    'patternURL' => str_replace(' ','-',$request->patternURL),
                    'patternweight' => $request->patternweight 
                ];
                $update = $Designpattern->update($payload); 
               
                return redirect('designs')->with('success', 'Design product pattern information updated succesfully!');
            } 
             
            // return redirect()->back()->with('error', 'Failed to update design! Try again.');
        } catch (\Exception $e) {
            $bug = $e->getMessage(); 
            // print_r($bug);die;
            return redirect()->back()->with('error', $bug);
        }
    }
 
    /**
     * Delete Design
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */

     //delete product with image and its directory start
    public function delete($id): RedirectResponse
    {  
        if ($design = Designproduct::find($id)) {   
            $designThumbnail = $design->design_thumbnail;
            $designDelete = $design->delete();
            if($designDelete){
                if(file_exists(public_path() . '/img/designs/' . $design->id . '/'. $designThumbnail)){
                       unlink(public_path() . '/img/designs/' . $design->id . '/'. $designThumbnail);
                    //    $response = rmdir(public_path() . '/img/designs/'.$id);
                } 
            } 
            return redirect('designs')->with('success', 'User removed!');
        }

        return redirect('designs')->with('error', 'User not found');
    }

}