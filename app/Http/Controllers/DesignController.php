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
use File;
use Storage;
class DesignController extends Controller
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
       $tagList = Tags::whereIn('id',$tags)->where('tag_category','4')->orderby('id','desc')->get();   
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
    public function create(): mixed
    {
        try { 
            $category = Category::get();
            $tags_list = array();
            $i = 0;
            foreach($category as $categ){ 
                // $tags_list['category'][] = $categ->name;
                $tags = Tags::where('tag_category',$categ->id)->get();  
                $tags_list[$i]['categoryid'] = $categ->id;
                $tags_list[$i]['category_name'] = $categ->name;
                $j = 0;
                $tag = array();       
                if(!empty($tags)){
                    foreach($tags as $tg){
                        $tag['tagid'] = $tg->id;
                        $tag['tagname'] = $tg->name;
                        $tags_list[$i]['tags'][$j] = $tag; 
                        $j++;
                    }
                } 
                
                $i++;
               
            } 
            return view('inventory.designs.create',compact('tags','tags_list'));
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
          
            $category_array =array();   
            $tags_array =array();   
            if($request->tags){
                foreach($request->tags as $category=>$tags){ 
                    
                    if(!in_array($category,$category_array)){
                        $category_array[] = $category;
                    }
                    foreach($tags as $tg){
                        $tags_array[] = $tg; 
                    }
                    
                   
                }
            }
        //   print_r($tags_array);
        //   echo "<br>";
        //   print_r($category_array);
        //   die;
            $design = Designproduct::create([
                'design_pro_name' => $request->design_pro_name,
                'design_product_set_id' => ($request->design_product_set_id)?$request->design_product_set_id:0,
                'design_product_url' => ($request->design_product_url)?str_replace(" ","-",$request->design_product_url):"",
                'design_weight' => $request->design_weight,
                'design_tags' => ($tags_array)?implode(',',$tags_array):"",
                'design_category' => ($category_array)?implode(',',$category_array):"", 
            ]);  

            $pathDesign = public_path('img/designs/'.$design->id);
            if(!file_exists($pathDesign)){
                File::makeDirectory($pathDesign);
            }  
            $name = '';  
            if ($request->hasfile('design_thumbnail')) {
                $file = $request->file('design_thumbnail');
                $name = time() . '.' . $file->extension();
                $file->move(public_path() . '/img/designs/' . $design->id . '/', $name); 
            }  
 
            $update_image_payload = array('design_thumbnail'=>$name);
            $find = Designproduct::find($design->id);
             $update_thumbnail =  $find->update($update_image_payload); 
            // Create new product success message 
            return redirect('designs')->with('success', 'New Design product created!');
            
        } catch (\Exception $e) {
            $bug = $e->getMessage(); 
            // print_r( $bug);die;
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
            $design = Designproduct::find($id);  
            if ($design) {  
                $category = Category::get();
                $tags_list = array();
                $i = 0;
                foreach($category as $categ){ 
                    // $tags_list['category'][] = $categ->name;
                    $tags = Tags::where('tag_category',$categ->id)->get();  
                    $tags_list[$i]['categoryid'] = $categ->id;
                    $tags_list[$i]['category_name'] = $categ->name;
                    $j = 0;
                    $tag = array();       
                    if(!empty($tags)){
                        foreach($tags as $tg){
                            $tag['tagid'] = $tg->id;
                            $tag['tagname'] = $tg->name;
                            $tags_list[$i]['tags'][$j] = $tag; 
                            $j++;
                        }
                    } 
                    
                    $i++;
                   
                } 
                return view('inventory.designs.edit', compact('design','tags_list'));
            } 
            return redirect('404');
        } catch (\Exception $e) {
            $bug = $e->getMessage(); 
            return redirect()->back()->with('error', $bug);
        }
    }



    /**
     * 
     * view Design product details start
     */
    public function show($id): mixed
    { 
        try {
            $design = Designproduct::find($id);   
            // echo "<pre>";
            // print_r($design);die;
            
            if ($design) {    
                $productGroup =  explode(',',$design->design_tags);
                $productGroupCategory =  explode(',',$design->design_category);
                $tag = array();
                $sports = array();
                foreach($productGroup as $tagid){
                    $tag_detail = Tags::find($tagid);
                    if($tag_detail->tag_category==4){
                        $tag[] = $tag_detail->name;
                    }
                    if($tag_detail->tag_category==5){
                        $sports[] = $tag_detail->name;
                    }
                   
                } 
                $patterns = Designpattern::where('product_design_id',$id)->get();
                $styles = Patternstyle::where('design_id',$id)->get();                
                return view('inventory.designs.show', compact('design','tag','sports','patterns','styles'));
            } 
            return redirect('404');
        } catch (\Exception $e) {
            $bug = $e->getMessage(); 
            return redirect()->back()->with('error', $bug);
        }
    }
    /* view design product end */

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
            'design_pro_name' => 'required',  
        ]); 
        if ($validator->fails()) {
            return redirect()->back()->withInput()->with('error', $validator->messages()->first());
        } 
        try {
            if ($Designproduct = Designproduct::find($request->id)) { 
                $name = '';  
                if($Designproduct->design_thumbnail){
                    $name = $Designproduct->design_thumbnail;
                } 
                if ($request->hasfile('design_thumbnail')) {
                    $file = $request->file('design_thumbnail');
                    $name = time() . '.' . $file->extension();
                    $file->move(public_path() . '/img/designs/' . $request->id . '/', $name); 
                }


                $category_array =array();   
                $tags_array =array();   
                if($request->tags){
                    foreach($request->tags as $category=>$tags){ 
                        
                        if(!in_array($category,$category_array)){
                            $category_array[] = $category;
                        }
                        foreach($tags as $tg){
                            $tags_array[] = $tg; 
                        }
                        
                       
                    }
                }
                $payload = [
                    'design_pro_name' => $request->design_pro_name, 
                    'design_product_url' => ($request->design_product_url)?str_replace(" ","-",$request->design_product_url):"", 
                    'design_product_set_id' => $request->design_product_set_id, 
                    'design_thumbnail' => $name, 
                    'design_weight' => $request->design_weight,  
                    'design_tags' => ($tags_array)?implode(',',$tags_array):"",
                    'design_category' => ($category_array)?implode(',',$category_array):"", 
                     
                ];
                $update = $Designproduct->update($payload); 
                return redirect()->back()->with('success', 'Design product information updated succesfully!');
            } 
            return redirect()->back()->with('error', 'Failed to update design! Try again.');
        } catch (\Exception $e) {
            $bug = $e->getMessage(); 
            // print_r($bug);
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
                if($designThumbnail && file_exists(public_path() . '/img/designs/' . $design->id . '/'. $designThumbnail)){
                       unlink(public_path() . '/img/designs/' . $design->id . '/'. $designThumbnail);
                       File::cleanDirectory(public_path() . '/img/designs/'.$id);
                       $response = rmdir(public_path() . '/img/designs/'.$id);
                } 
            } 
            return redirect('designs')->with('success', 'User removed!');
        }

        return redirect('designs')->with('error', 'User not found');
    }

}