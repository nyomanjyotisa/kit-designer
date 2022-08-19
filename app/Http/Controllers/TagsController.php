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
use Storage;
class TagsController extends Controller
{

    /**
     * Show the tags dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(): View
    { 
        $category = Category::get();
        return view('inventory.tags.list',compact('category'));
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
		$tags = Tags::select("*"); 
		if (!empty($searchkey)) {			
                $tags = $tags->where(function ($query) use ($searchkey) {
                        $query->orWhere('name', 'like', '%' . $searchkey . '%')  ;                               
                    });			
        } 
		$total_rows = $tags->get()->count();
	    $all_records = array(); 
		if ($total_rows > 0) {
			$tagsData = $tags->skip($page)
					->take($rows)
					->get();
	 
			$index = 0;
			$i = 1;
			foreach ($tagsData as $value) {	 
				$all_records[$index]['checkbox']   ='<label class="custom-control custom-checkbox">
                                                        <input type="checkbox" class="custom-control-input select_all_child" id="" name="" value="option2">
                                                        <span class="custom-control-label">&nbsp;</span>
                                                    </label>';
           
				$all_records[$index]['name']   = $value->name; 
				$all_records[$index]['matchine_name']   = $value->machine_name;  
                $getCategory = Category::find($value->tag_category);
				$all_records[$index]['category']   =  (isset($getCategory->name) && $getCategory)?$getCategory->name:""; 
                $all_records[$index]['action']   ='<button data-id="'.$value->id.'" data-name="'.$value->name.'" data-matchine_name="'.$value->matchine_name.'" data-category="'.$value->tag_category.'" class="btn btn-outline-primary btn-semi-rounded edit_data" href="#tagEdit" data-toggle="modal" data-target="#tagEdit">Edit</button>  &nbsp;<a href="'.url('tags/delete/' . $value->id).'" data-id="'.$value->id.'" class=" btn btn-outline-primary btn-semi-rounded  edit_data">Delete</a>';
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
     * tag Create
     *
     * @return mixed
     */
    public function create(): mixed
    {
        try { 
            return view('inventory.designs.create');
        } catch (\Exception $e) {
            return redirect('tags')->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Store tag
     *
     * @param UserRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {   
        try { 
            $tags = Tags::create([
                'tag_category' => $request->categoryid, 
                'name' => $request->tagname,
                'machine_name' => str_replace(' ','-',$request->tagname), 
            ]);   
            return redirect('tags')->with('success', 'New category created!'); 
        } catch (\Exception $e) {
            $bug = $e->getMessage();  
             return redirect('tags')->back()->with('error', $bug);
        }
    }

    /**
     * Edit tag
     *
     * @param int $id
     * @return mixed
     */ 

    /**
     * Update Tag
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request): RedirectResponse
    { 
        // update tag info 
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'name' => 'required', 
            'tag_category' => 'required'
            
        ]); 
        if ($validator->fails()) { 
            return redirect('tags')->back()->withInput()->with('error', $validator->messages()->first());
        } 
        try {
            if ($Category = Tags::find($request->id)) {
                $payload = [
                    'name' => $request->name, 
                    'machine_name' => str_replace(' ','-',$request->name), 
                    'tag_category' => $request->tag_category  
                ];
                $update = $Category->update($payload); 
                return redirect('tags')->with('success', 'Tags information updated succesfully!');
            } 
            return redirect('tags')->with('error', 'Failed to update tags! Try again.');
        } catch (\Exception $e) {
            $bug = $e->getMessage();  
            return redirect('tags')->with('error', $bug);
        }
    } 
    /**
     * Delete User
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete($id): RedirectResponse
    {
        if ($tags = Tags::find($id)) {
            $tags->delete(); 
            return redirect('tags')->with('success', 'User removed!');
        } 
        return redirect('tags')->with('error', 'User not found');
    }
}
