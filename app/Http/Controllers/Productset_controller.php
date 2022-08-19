<?php 
namespace App\Http\Controllers; 
use App\Http\Requests\UserRequest;
use DataTables;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;
use Spatie\Permission\Models\Role;
use App\Models\Productset;
use App\Models\Productset_image;
use App\Models\Size;
use App\Models\Tags;
use App\Models\Tag_category;
use App\Models\Productset_document;
use App\Models\Productset_size; 

class Productset_controller extends Controller
{

    /**
     * Show the users dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(): View
    {
        return view('inventory');
    }

    /**
     * Show Product set List
     *
     * @param Request $request
     * @return mixed
     */

    public function getProductSet(Request $request): mixed
    {
        $data = Productset::where('parent_productset_id','0')->first();
        $size = Size::get(); 
        return view('inventory.productset.list', compact('data','size'));
    } 

    public function loadDatatable(Request $request){ 
        $page = !empty($request->get("start")) ? $request->get("start") : 0;
        $rows = !empty($request->get("length")) ? $request->get("length") : 10;
		$draw = !empty($request->get("draw")) ? $request->get("draw") : 1; 
		$searchkey = $request->search['value'];  
		$productset = Productset::select("*"); 
		if (!empty($searchkey)) {			
                $productset = $productset->where(function ($query) use ($searchkey) {
                    $query->orWhere('product_set', 'like', '%' . $searchkey . '%')
                            ->orWhere('productset_description', 'like', '%' . $searchkey . '%');                               
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
				$all_records[$index]['checkbox']   ='<label class="custom-control custom-checkbox">
                <input type="checkbox" class="custom-control-input select_all_child" id="" name="" value="option2">
                <span class="custom-control-label">&nbsp;</span>
            </label>';
				$all_records[$index]['name']   = $value->product_set;
				$all_records[$index]['description']   = $value->productset_description; 
                $all_records[$index]['action']   ='<a href="'.url('products/set/edit/' . $value->id).'" data-id="'.$value->id.'" class=" btn btn-outline-primary btn-semi-rounded  edit_data">Edit</a>&nbsp;<a href="'.url('products/set/delete/' . $value->id).'" data-id="'.$value->id.'" class=" btn btn-outline-primary btn-semi-rounded  delete_data">Delete</a>';
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
     * Product set Create
     *
     * @return mixed
     */
    public function create($parentId = 0): mixed
    {
        try {
            $sizeMens = Size::where('gender','1')->orderby('weight','asc')->get();
            $sizeWomens = Size::where('gender','2')->orderby('weight','asc')->get();
            $sizeKids = Size::where('gender','3')->orderby('weight','asc')->get();
            $sizeUnisex = Size::where('gender','4')->orderby('weight','asc')->get();
            $Tags = Tags::get();
            $Tag_category = Tag_category::get(); 
            $productset = Productset::get(); 
            $parentChild = array();   
            return view('inventory.productset.create', compact('sizeMens','sizeWomens','sizeKids','sizeUnisex','Tags','Tag_category','productset','parentId'));
        } catch (\Exception $e) {
            $bug = $e->getMessage(); 
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function getParentChild($parentId = 0, $sub_mark = ''){
        $child = Productset::where('parent_productset_id',$parentId)->get(); 
        if($child->count()>0){
            foreach($child as $ch){ 
                echo '<option value="'.$ch->id.'">'.$sub_mark.$ch->product_set.'</option>'; 
                $this->getParentChild($ch->id,$sub_mark."---");
            }
        }  
    } 

    
    public function getParentChild_edit($id,$parentId = 0, $sub_mark = ''){
        $child = Productset::where('parent_productset_id',$parentId)->get(); 
        if($child->count()>0){
            foreach($child as $ch){ 
                $selected= '';
                if($ch->id==$id){
                    $selected = "selected";
                }
                echo '<option value="'.$ch->id.'" '.$selected.' >'.$sub_mark.$ch->product_set.'</option>'; 
                $this->getParentChild_edit($id,$ch->id,$sub_mark."---");
            }
        }  
    } 


    public function getParentChild_list($parentId = 0, $sub_mark = '',$addTr=0){ 
        $child = Productset::where('parent_productset_id',$parentId)->where('parent_productset_id','!=','0')->get();  
        if($child->count()>0){ 
            foreach($child as $ch){  
            // echo '<option value="'.$ch->id.'">'.$sub_mark.$ch->product_set.'</option>';   
            if($addTr!=0 && $parentId!='default'){
                echo '<tr  data-toggle="collapse" data-target="#par_'.$parentId.'" data-id="'.$ch->id.'" id="p_'.$parentId.'" class="accordion-toggle hidden show_data  p_'.$parentId.'">
                <td colspan="12" class="hiddenRow">
                    <div class="accordian-body collapse" id="set_'.$parentId.'">
                        <table class="table">  
                            <tbody>  
                                <tr data-toggle="collapse" class="accordion-toggle"
                                    data-target="#set_'.$ch->id.'">
                                    <td></td>
                                    <td></td>
                                    <td><button class="btn btn-default btn-xs"><span class="ik ik-plus"></span></button> '.$sub_mark.$ch->product_set.'</td> 
                                    <td><a href="'.url('products/set/edit/' . $ch->id).'" class="btn btn-outline-primary btn-semi-rounded " data-id="'.$ch->id.'">Edit</a> &nbsp; <a href="'.url('products/productset/create/' . $ch->id).'" data-id="'.$ch->id.'" class="btn btn-outline-primary btn-semi-rounded ">Add</a>&nbsp;<a href="'.url('products/set/delete/' . $ch->id).'" data-id="'.$ch->id.'" class="delete_data btn btn-outline-primary btn-semi-rounded">Delete</a></td> 
                                    <td></td>
                                </tr> 
                                </tbody>
                            </table>
                    </div>
                </td>
            </tr>';
            
                $sub_mark = "-"; 
            }else{
                echo     '<tr  data-toggle="collapse"  id="p_'.$parentId.'"  data-target="#set_'.$ch->id.'" data-id="'.$ch->id.'" class="accordion-toggle show_data hidden  default_s p_'.$parentId.'">
                <td >
                   
                </td>
                <td> <button class="btn btn-default btn-xs toggle_icon"><span  class="ik ik-plus"></span></button> '.$sub_mark.$ch->product_set.'</td>
                <td><a href="'.url('products/set/edit/' . $ch->id).'" data-id="'.$ch->id.'" class="btn btn-outline-primary btn-semi-rounded ">Edit</a> &nbsp; <a href="'.url('products/productset/create/' . $ch->id).'" data-id="'.$ch->id.'" class="btn btn-outline-primary btn-semi-rounded ">Add</a>&nbsp;<a href="'.url('products/set/delete/' . $ch->id).'" data-id="'.$ch->id.'" class="delete_data btn btn-outline-primary btn-semi-rounded"">Delete</a></td> 
            </tr>';
            $sub_mark = "-";
            }
           
                $this->getParentChild_list($ch->id,$sub_mark."---",strlen($sub_mark));
            }
            
           
        }  
    } 

    function getParentChild_list_sub($parentId = 0, $sub_mark = '',$addTr=0){ 
        $sub = Productset::where('parent_productset_id',$parentId)->get(); 
      
        foreach($sub as $childs){
            echo '<tr  data-toggle="collapse" data-target="#par_'.$parentId.'" data-id="'.$childs->id.'" id="p_'.$parentId.'" class="accordion-toggle hidden show_data">
            <td colspan="12" class="hiddenRow">
                <div class="accordian-body collapse" id="set_'.$parentId.'">
                    <table class="table table-striped">  
                        <tbody>  
                            <tr data-toggle="collapse" class="accordion-toggle"
                                data-target="#set_'.$childs->id.'">
                                <td></td>
                                <td><button class="btn btn-default btn-xs"><span class="ik ik-plus"></span></button></td>
                                <td>'.$childs->product_set.'</td> 
                                <td><a href="'.url('products/set/edit/' . $childs->id).'" data-id="'.$childs->id.'" class=" btn btn-outline-primary btn-semi-rounded  edit_data">Edit</a></td> 
                                <td></td>
                            </tr> 
                            </tbody>
                        </table>
                </div>
            </td>
        </tr>';

        $this->getParentChild_list_sub($childs->id,$sub_mark."***",strlen($sub_mark)); 
        }
        
    }
    // echo '
    // <tr>
    //     <td colspan="12" class="hiddenRow">
    //         <div class="accordian-body collapse" id="set_'.$ch->id.'">
    //             <table class="table table-striped">  
    //                 <tbody> 
    //                     <tr data-toggle="collapse" class="accordion-toggle"
    //                         data-target="#demo10">
    //                         <td><button class="btn btn-default btn-xs"><span class="ik ik-plus"></span></button></td>
    //                         <td>Google</td> 
    //                         <td>Google</td> 
    //                     </tr> 
    //                     </tbody>
    //                 </table>
    //         </div>
    //     </td>
    // </tr>';
    
    /**
     * Store Product set
     *
     * @param UserRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(UserRequest $request): RedirectResponse
    {   
 
         // update product set info
         $validator = Validator::make($request->all(), [
            'product_set' => 'required | string ', 
            'parent_product_set' => 'required', 
            ]); 

            if ($validator->fails()) {
                return redirect()->back()->withInput()->with('error', $validator->messages()->first());
            }
        
        try { 
            $productset = Productset::create([
                'product_set' => $request->product_set,
                'productset_description' => $request->productset_description,  
                'price_aud' => (!empty($request->price_aud))?$request->price_aud:0,
                'price_eur' => (!empty($request->price_eur))?$request->price_eur:0,
                'price_gbp' => (!empty($request->price_gbp))?$request->price_gbp:0,
                'price_usd' => (!empty($request->price_usd))?$request->price_usd:0,
                'price_nzd' => (!empty($request->price_nzd))?$request->price_nzd:0, 
                'parent_productset_id' => (!empty($request->parent_product_set))?$request->parent_product_set:"",
                'minimum' => $request->minimum,
                'discountLevel' => $request->discountLevel,
                'DisableDiscountLevels' => ($request->DisableDiscountLevels=="on")?1:0,
                'inherit_sizes' => ($request->inherit=="1")?1:0,
                'pattern'=>json_encode($request->pattern),                
            ]);  
            if (!empty($request->documents)) {
                $i = 0;
                foreach ($request->documents as $documents) { 
                    if(!empty($documents)){
                        foreach ($documents as $document_name) {
                            if($document_name){ 
                                $doc_name = "";
                                $doc_file = $request->file('documents_image')[$i][0];
                                $doc_attachemnt_name = str_replace(' ','',$document_name).'_'.time().'-'.$i. '.' . $doc_file->extension();
                                $doc_file->move(public_path() . '/img/productset/documents/' . $productset->id . '/', $doc_attachemnt_name);
                                $save_documents = Productset_document::create([
                                    'productset_id' => $productset->id,
                                    'document_name' => $document_name,
                                    'document_attachment' => $doc_attachemnt_name
                                ]);
                            }
                        }
                        $i++;
                    }
                    
                }
            }  
            
            if(!empty($request->sizes) && $request->inherit!=1){

                $size_array = array();
                foreach($request->sizes as $key=>$value){
                    $size_array[] = $value;
                }

                $save_size = Productset_size::create([
                    'productset_id' => $productset->id,
                    'size_id' => implode(',',$size_array),
                    
                ]); 
            } 
            // Create new product success message 
            return redirect('products/set')->with('success', 'New Productset created!');
            //     } 
            // return redirect('products')->with('error', 'Failed to create new product! Try again.');
        } catch (\Exception $e) {
            $bug = $e->getMessage();
            //  print_r($bug);die;
             return redirect('products/set')->with('error', $bug);
        }
    }

    /**
     * Edit Product set
     *
     * @param int $id
     * @return mixed
     */
    public function edit($id): mixed
    { 
        try {
            // $Productset = Productset::find($id); 
           $Productset =  Productset::leftJoin('productset_sizes', "productset_sizes.productset_id", "=", "productsets.id")->where('productsets.id',$id)->get();
        //    print_r( $Productset);die;
           $productset_documents = Productset_document::where('productset_id',$id)->get();
           $sizeMens = Size::where('gender','1')->orderby('weight','asc')->get();
           $sizeWomens = Size::where('gender','2')->orderby('weight','asc')->get();
           $sizeKids = Size::where('gender','3')->orderby('weight','asc')->get();
           $sizeUnisex = Size::where('gender','4')->orderby('weight','asc')->get();
            $productset_dropdown = Productset::get();
            if ($Productset) {
                return view('inventory.productset.edit', compact('Productset','sizeMens','sizeWomens','sizeKids','sizeUnisex','productset_dropdown','productset_documents'));
            } 
            return redirect('404');
        } catch (\Exception $e) {
            $bug = $e->getMessage();
            return redirect()->back()->with('error', $bug);
        }
    }

    /**
     * Update Product set
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request): RedirectResponse
    { 
        // update productset info
        $validator = Validator::make($request->all(), [
            'productset_id' => 'required', 
        ]); 
        if ($validator->fails()) {
            return redirect()->back()->withInput()->with('error', $validator->messages()->first());
        } 
        try { 
            if ($ProductSet = Productset::find($request->productset_id)) { 
                $payload = [
                    'product_set' => $request->product_set,
                    'productset_description' => $request->productset_description,  
                    'price_aud' => (!empty($request->price_aud))?$request->price_aud:0,
                    'price_eur' => (!empty($request->price_aud))?$request->price_eur:0,
                    'price_gbp' => (!empty($request->price_aud))?$request->price_gbp:0,
                    'price_usd' => (!empty($request->price_aud))?$request->price_usd:0,
                    'price_nzd' => (!empty($request->price_aud))?$request->price_nzd:0,
                    'parent_productset_id' => (!empty($request->parent_product_set) || $request->parent_product_set=="0")?$request->parent_product_set:"",
                    'minimum' => $request->minimum,
                    'discountLevel' => $request->discountLevel,
                    'DisableDiscountLevels' => ($request->DisableDiscountLevels=="on")?1:0,
                    'inherit_sizes' => ($request->inherit=="1")?1:0,
                    'pattern'=>json_encode($request->pattern)
                ];  
                $update = $ProductSet->update($payload);   
                if (!empty($request->documents)) {
                    $i = 0;
                    foreach ($request->documents as $documents) { 
                        if(!empty($documents)){
                            foreach ($documents as $document_name) {
                                if($document_name){ 
                                    $doc_name = "";
                                    $doc_file = $request->file('documents_image')[$i][0];
                                    $doc_attachemnt_name = str_replace(' ','',$document_name).'_'.time().'-'.$i. '.' . $doc_file->extension();
                                    $doc_file->move(public_path() . '/img/productset/documents/' . $request->productset_id . '/', $doc_attachemnt_name);
                                    $save_documents = Productset_document::create([
                                        'productset_id' => $request->productset_id,
                                        'document_name' => $document_name,
                                        'document_attachment' => $doc_attachemnt_name
                                    ]);
                                }
                            }
                            $i++;
                        }
                        
                    }
                }  

                if(!empty($request->sizes) && $request->inherit!=1){ 
                    $size_array = array();
                    foreach($request->sizes as $key=>$value){
                        $size_array[] = $value;
                    }  
                    $Productset_Size = Productset_size::where('productset_id',$request->productset_id);
                    $size_payload = ['size_id' => implode(',',$size_array)] ; 

                    $update_size = $Productset_Size->update($size_payload); 
                } 
                return redirect('products/set')->with('success', 'Product set information updated succesfully!');
            } 
            return redirect('products/set')->with('error', 'Failed to update product set! Try again.');
        } catch (\Exception $e) { 
            $bug = $e->getMessage(); 
            return redirect('products/set')->with('error', $bug);
        }
    } 
    /**
     * Delete Product set
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete($id): RedirectResponse
    { 
        if ($productSet = Productset::find($id)) {
            $productset_delete = $productSet->delete();  
            if($productset_delete){
                $productset_documents = Productset_document::where('productset_id',$id)->get();
                foreach($productset_documents as $doc){
                    if(file_exists(public_path() . '/img/productset/documents/' . $id . '/'. $doc->document_name)){
                        unlink(public_path() . '/img/productset/documents/' . $id . '/'.$doc->document_name); 
                    }
                }
                if(file_exists(public_path() . '/img/productset/documents/' . $id)){
                    rmdir(public_path() . '/img/productset/documents/' . $id);
                }
                $productset_doc_delete = Productset_document::where('productset_id',$id)->delete(); 
            }
            return redirect('products/set')->with('success', 'Product set removed!');
        } 
        return redirect('products/set')->with('error', 'Product set not found');
    }
}
