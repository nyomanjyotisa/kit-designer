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
use Storage;
class CategoryController extends Controller
{ 
    /**
     * Show the Category dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(): View
    { 
        return view('inventory.category.list');
    }

    /**
     * Show Category List
     *
     * @param Request $request
     * @return mixed
     */ 
    public function loadDatatable(Request $request){
 
        $page = !empty($request->get("start")) ? $request->get("start") : 0;
        $rows = !empty($request->get("length")) ? $request->get("length") : 10;
		$draw = !empty($request->get("draw")) ? $request->get("draw") : 1; 
		$searchkey = $request->search['value'];  
		$category = Category::select("*"); 
		if (!empty($searchkey)) {			
                $category = $category->where(function ($query) use ($searchkey) {
                        $query->orWhere('name', 'like', '%' . $searchkey . '%')  ;                               
                    });			
        } 
		$total_rows = $category->get()->count();
	    $all_records = array(); 
		if ($total_rows > 0) {
			$categoryData = $category->skip($page)
					->take($rows)
					->get();
	 
			$index = 0;
			$i = 1;
			foreach ($categoryData as $value) {	 
			 
           
				 $all_records[$index]['name']   = $value->name; 
				 $all_records[$index]['matchine_name']   = $value->matchine_name; 
                $all_records[$index]['action']   ='<button data-id="'.$value->id.'" data-name="'.$value->name.'" data-matchine_name="'.$value->matchine_name.'" class="btn btn-outline-primary btn-semi-rounded edit_data" href="#categoryEdit" data-toggle="modal" data-target="#categoryEdit">Edit</button> &nbsp;<a href="'.url('categories/delete/' . $value->id).'" data-id="'.$value->id.'" class=" btn btn-outline-primary btn-semi-rounded">Delete</a>';
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
     * Category Create
     *
     * @return mixed
     */
    public function create(): mixed
    {
        try { 
            return view('inventory.designs.create');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Store Category
     *
     * @param UserRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {  
        try { 
            $design = Category::create([
                'name' => $request->name, 
                'matchine_name' => str_replace(' ','-',$request->name), 
            ]);   
            return redirect('categories')->with('success', 'New category created!');
            
        } catch (\Exception $e) {
            $bug = $e->getMessage(); 
             return redirect()->back()->with('error', $bug);
        }
    }

    /**
     * Edit Category
     *
     * @param int $id
     * @return mixed
     */ 

    /**
     * Update Category
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request): RedirectResponse
    {
        // update category info
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'name' => 'required',
            // 'matchine_name' => 'required',
            
        ]); 
        if ($validator->fails()) {
            return redirect()->back()->withInput()->with('error', $validator->messages()->first());
        } 
        try {
            if ($Category = Category::find($request->id)) {
                $payload = [
                    'name' => $request->name, 
                     'matchine_name' => str_replace(' ','-',$request->name)
                ];
                $update = $Category->update($payload); 
                return redirect()->back()->with('success', 'Category information updated succesfully!');
            } 
            return redirect()->back()->with('error', 'Failed to update category! Try again.');
        } catch (\Exception $e) {
            $bug = $e->getMessage(); 
            return redirect()->back()->with('error', $bug);
        }
    } 

    /**
     * Delete Category
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete($id): RedirectResponse
    {
        if ($category = Category::find($id)) {
            $category->delete(); 
            return redirect('categories')->with('success', 'Category removed!');
        } 
        return redirect('categories')->with('error', 'Category not found');
    } 
}
