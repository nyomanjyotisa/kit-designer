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
use File;
use Storage;
class PatternStyleController extends Controller
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

    //  --------use method here
  
    /**
     * Design Create
     *
     * @return mixed
     */
    public function create($designid=null,$patternid=null,$add=null,$gender=null): mixed
    { 
        try {
            
            $patterns = Designpattern::where('product_design_id',$designid)->get();
            return view('inventory.patternstyle.create',compact('patterns','patternid','designid','gender'));
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

      
        // print_r($request->all());die;
        try { 
                 $name = "";
            if(isset($request->savecontinue)){ 
                $validator = Validator::make($request->all(), [ 
                    'styleName' => 'required',  
                    'svgfile' => 'required' 
                ]); 
                if ($validator->fails()) {
                    return redirect()->back()->withInput()->with('failed', $validator->messages()->first());
                }
            }
            if(isset($request->upload)){
                    // store Design information
                    if ($request->hasfile('svgfile')) {
                        $file = $request->file('svgfile'); 
                        if($file->extension()!='svg'){
                            return redirect('designs/'.$request->designid.'/'.$request->patternid.'/add/'.$request->gender)->with(['failed'=> 'Please upload only SVG file','stylename'=>$request->styleName]);   
                        }        
                        $name = str_replace(' ','-',$request->styleName).time() . '.' . $file->extension();                 
                        $file->move(public_path() . '/img/temporary/',$name);  
                    } 
                    
                    return redirect('designs/'.$request->designid.'/'.$request->patternid.'/add/'.$request->gender)->with(['success'=> 'New SVG uploaded!','filename'=>$name,'stylename'=>$request->styleName]);   
            } 
            
            if(isset($request->remove)){
                $removefile = $request->removefile; 
                if(file_exists(public_path() . '/img/temporary/'. $removefile)){
                    unlink(public_path() . '/img/temporary/'. $removefile); 
                }  
                return redirect('designs/'.$request->designid.'/'.$request->patternid.'/add/'.$request->gender)->with(['success'=> 'SVG successfully removed']);
            }
            // store Design information 
      
            if ($request->svgfile) {
                if($_FILES){
                    if ($request->hasfile('svgfile')) {
                        $file = $request->file('svgfile'); 
                        if($file->extension()!='svg'){
                            return redirect('designs/'.$request->designid.'/'.$request->patternid.'/add/'.$request->gender)->with(['failed'=> 'Please upload only SVG file','stylename'=>$request->styleName]);   
                        }        
                        $name = str_replace(' ','-',$request->styleName).time() . '.' . $file->extension();                 
                        $file->move(public_path() . '/img/temporary/',$name);  
                    } 
                    $temp = public_path('img/temporary/') . $name;
                   $dest = public_path('img/designs/'.$request->designid.'/patterns/'.$request->patternid.'/style/') . $name;   
                }else{
                    $temp = public_path('img/temporary/') . $request->input('svgfile');
                    $dest = public_path('img/designs/'.$request->designid.'/patterns/'.$request->patternid.'/style/') . $request->input('svgfile');   
                    $name = $request->input('svgfile');
                }
                
                    // check patterns directory exist or not if not then create start
                    $path_pattern = public_path('img/designs/'.$request->designid.'/patterns');  
                    if(!file_exists($path_pattern)){  
                            File::makeDirectory($path_pattern);
                       
                    }
                    $path2_id = public_path('img/designs/'.$request->designid.'/patterns/'.$request->patternid);
                    if(!file_exists($path2_id)){
                        File::makeDirectory($path2_id);
                    }  
                    // check patterns directory exist or not if not then create end
                
                if(!file_exists(public_path('img/designs/'.$request->designid.'/patterns/'.$request->patternid.'/style/'))){
                   
                    $path = public_path('img/designs/'.$request->designid.'/patterns/'.$request->patternid.'/style/');
                    File::makeDirectory($path);
                }
                File::move($temp, $dest); 
                // $name = $request->input('svgfile');  
             }  

            $design_pattern = Patternstyle::create([
                'design_id' => $request->designid, 
                'pattern_id' => ($request->patternid)?$request->patternid:0,
                // 'gender' => $request->gender,
                'styleName' => $request->styleName, 
                'styleImage'=>$name
            ]);    
              $style_details = Styledetail::create([
                'styleid'=>$design_pattern->id,
                'gender'=>$request->gender,
                'styleImage'=>$name
             ]);  
             $svg =  simplexml_load_file(public_path() . '/img/designs/'.$request->designid.'/patterns/'.$request->patternid.'/style/'.$name);   
            $svg_g_elements_count = count($svg->g);  
            for($i = 0;$i<$svg_g_elements_count;$i++){
              foreach($svg->g[$i]->attributes() as $a => $b) { 
                //   echo $a,'="',$b,"\"\n";
                  $svg_name = explode("Coloured_x5F_",$b);
                  $save_svg_colors = Svgcolor::create([
                    "styleId"=>$design_pattern->id,
                    'stylegender'=>$request->gender,
                    "svg_g_id"=>$b,
                    "svg_name"=>str_replace("_"," ",$svg_name[count($svg_name)-1])
                  ]); 
              }
            } 
            // Create new product style success message 
            return redirect('designs/style/edit/'.$request->designid.'/'.$request->patternid.'/'.$design_pattern->id.'/'.$request->gender)->with(['success'=> 'Style successfully created']);
            
        } catch (\Exception $e) {
            $bug = $e->getMessage(); 
              print_r($bug);die;
              return redirect('designs')->with('error', $bug);
        }
    }

    /**
     * Edit Design
     *
     * @param int $id
     * @return mixed
     */
    public function edit($designid=null,$patternid=null,$styleid = null,$gender = 1): mixed
    {  
        try {
              $patterns = Designpattern::where('product_design_id',$designid)->get();
              $Patternstyle = Patternstyle::find($styleid);  
            if ($patterns && $Patternstyle) {  
                if($check = Styledetail::where('styledetails.styleid',$styleid)->where('styledetails.gender',$gender)->get()->count()>0){ 
                    $Patternstyle = Patternstyle::select('styledetails.styleImage as st_Image','patternstyles.id as id','patternstyles.styleName as styleName','styledetails.gender as gender')->leftJoin('styledetails','styledetails.styleid','=','patternstyles.id')->where('styledetails.gender',$gender)->where('patternstyles.id',$styleid)->first(); 
                }else{ 
                    $Patternstyle = Patternstyle::find($styleid);   
                } 
                  $colorSelection = Svgcolor::where('styleId',$styleid)->where('stylegender',$gender)->get(); 
                   $fabric = Fabric::get();
                  return view('inventory.patternstyle.edit',compact('patterns','patternid','designid','Patternstyle','colorSelection','fabric','styleid','gender'));
                //  return view('inventory.patternstyle.edit', compact('patterns'));
            } 
            return redirect('404');
        }catch (\Exception $e) {
            $bug = $e->getMessage(); 
            // print_r($bug);
            return redirect()->back()->with('error', $bug);
        }
    }


    public function show($designid = 0,$patternid = 0,$styleid = 0){
        try{
            return view('inventory.patternstyle.show');
        }catch(Exception $e){
            $but = $e->getMessage();
            return redirect()->back()->with('error',$bug);
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
        $validator = Validator::make($request->all(), [ 
            'styleName' => 'required',  
        ]); 
        if ($validator->fails()) {
            return redirect()->back()->withInput()->with('error', $validator->messages()->first());
        } 
        try { 
            // Delete style start
            if(isset($request->deletestyle)){
                // echo "IN";die;
                $style = Styledetail::where('gender',$request->ngender)->where('styleid',$request->styleid)->first();
                if(!empty($style)){ 
                    $style->delete();
                
                }
                $getStyleColorSelection = Svgcolor::where('styleId',$request->styleid)->where('stylegender',$request->ngender)->get();
                if( $getStyleColorSelection ){  
                   $delete =  Svgcolor::where('styleId',$request->styleid)->where('stylegender',$request->ngender)->delete(); 
                }  
                $details_style_details = Styledetail::where('styleid',$request->styleid)->get();
                $details_style_color = Svgcolor::where('styleId',$request->styleid)->get();
                if($details_style_details->count()==0 && $details_style_color->count()==0){
                     $Patternstyle = Patternstyle::find($request->styleid); 
                     $Patternstyle->delete();
                } 
                return redirect('designs/show/'.$request->designid)->with('success', "deleted successfully"); 
            }
            // Delete Style End
            // Styledetail 
            $name = "";

            if(isset($request->changeSvg)){     
                $svgfile = '';
                $getStyleColorSelection = Svgcolor::where('styleId',$request->styleid)->where('stylegender',$request->ngender)->get();
                if( $getStyleColorSelection ){  
                   $delete =  Svgcolor::where('styleId',$request->styleid)->where('stylegender',$request->ngender)->delete(); 
                } 
                if($Designpattern = Styledetail::where('gender',$request->ngender)->where('styleid',$request->styleid)->first()){
                  
                    // print_r($Designpattern);die;
                     $Designpattern->styleImage = "";
                     $Designpattern->update();
                } 
                return redirect()->back()->withInput()->with('success', $validator->messages()->first()); 
                
            }

            if(isset($request->upload)){
                // store Design information 

                    $name = "";
                    if ($request->hasfile('svgfile')) {
                        $file = $request->file('svgfile'); 
                        if($file->extension()!='svg'){
                            return redirect('designs/style/edit/'.$request->designid.'/'.$request->patternid.'/'.$request->styleid.'/'.$request->ngender)->with(['failed'=> 'Please upload only SVG file','stylename'=>$request->styleName]);   
                        } 
                        $name = str_replace(' ','-',$request->styleName).time() . '.' . $file->extension();  
                        $file->move(public_path() . '/img/temporary/',$name);     
                    } 
                    return redirect('designs/style/edit/'.$request->designid.'/'.$request->patternid.'/'.$request->styleid.'/'.$request->ngender)->with(['success'=> 'New SVG uploaded!','filename'=>$name,'stylename'=>$request->styleName]);   
            } 

            if(isset($request->remove)){
                $removefile = $request->removefile; 
                if(file_exists(public_path() . '/img/temporary/'. $removefile)){
                    unlink(public_path() . '/img/temporary/'. $removefile); 
                }   
                return redirect('designs/style/edit/'.$request->designid.'/'.$request->patternid.'/'.$request->styleid.'/'.$request->ngender)->with(['success'=> 'SVG successfully removed']);
            }
            // store Design information  

             $GetExistStyle = Styledetail::where('styleid',$request->styleid)->where('gender',$request->ngender)->first();
   
             if(empty($GetExistStyle)){  
                // echo "Hello2";die;
                 if ($request->svgfile) {

                    // check patterns directory exist or not if not then create start
                    $path_pattern = public_path('img/designs/'.$request->designid.'/patterns');  
                    if(!file_exists($path_pattern)){  
                            File::makeDirectory($path_pattern);
                       
                    }
                    $path2_id = public_path('img/designs/'.$request->designid.'/patterns/'.$request->patternid);
                    if(!file_exists($path2_id)){
                        File::makeDirectory($path2_id);
                    }  
                    // check patterns directory exist or not if not then create end

                    $temp = public_path('img/temporary/') . $request->input('svgfile');
                    $dest = public_path('img/designs/'.$request->designid.'/patterns/'.$request->patternid.'/style/') . $request->input('svgfile'); 
                    File::move($temp, $dest); 
                    $name = $request->input('svgfile'); 
                } 
                 $style_details = Styledetail::create([
                     'styleid'=>$request->styleid,
                     'gender'=>$request->ngender,
                     'styleImage'=>$name
                  ]); 
     
                 $svg =  simplexml_load_file(public_path() . '/img/designs/'.$request->designid.'/patterns/'.$request->patternid.'/style/'.$name);  
                 $svg_g_elements_count = count($svg->g);  
                 for($i = 0;$i<$svg_g_elements_count;$i++){
                   foreach($svg->g[$i]->attributes() as $a => $b) { 
                     //   echo $a,'="',$b,"\"\n";
                       $svg_name = explode("Coloured_x5F_",$b);
                       $save_svg_colors = Svgcolor::create([
                         "styleId"=>$request->styleid,
                         "svg_g_id"=>$b,
                         "stylegender"=>$request->ngender,
                         "svg_name"=>str_replace("_"," ",$svg_name[count($svg_name)-1])
                       ]); 
                   }
                 } 
                 if(isset($request->saveClose)){    
                    return redirect('designs/show/'.$request->designid)->with(['success'=> 'New SVG uploaded!','filename'=>$name]);
                 }else{
                    return redirect('designs/style/edit/'.$request->designid.'/'.$request->patternid.'/'.$request->styleid.'/'.$request->ngender)->with(['success'=> 'New SVG uploaded!','filename'=>$name]);
                 }

                    
             }
 
             if($GetExistStyle && $GetExistStyle->count()>0){
                // echo "Hello1";die;
            if ($Designpattern = Patternstyle::find($request->styleid)) {    
                    // update color selection info   
                    $name = $GetExistStyle->styleImage;
                    if ($request->svgfile) {
                        $temp = public_path('img/temporary/') . $request->input('svgfile');
                        $dest = public_path('img/designs/'.$request->designid.'/patterns/'.$request->patternid.'/style/') . $request->input('svgfile'); 
                        File::move($temp, $dest); 
                        $name = $request->input('svgfile'); 
                     }  
                     
                        $updateDe  =  [
                            "styleImage"=>$name
                        ];
                        // $styledet = Styledetail::where("styleid",$Designpattern->id)->where('gender',$request->ngender)->first();
                        $GetExistStyle->update( $updateDe );     
                
                    $getStyleColorSelection = Svgcolor::where('styleId',$request->styleid)->where('stylegender',$request->ngender)->get(); 
                    if(!empty($getStyleColorSelection) && $getStyleColorSelection->count()>0){
                        // echo "Hello5";
                        // $name = $Designpattern->styleImage;
                        foreach($getStyleColorSelection as $colorSelected){
                            $colorSelectId = $colorSelected['svg_g_id'];
                            $svg_g_id=  (isset($request->svgstyle[$colorSelectId]['svg_g_id']))?$request->svgstyle[$colorSelectId]['svg_g_id'][$colorSelected->id]:""; 
                            $svgfabric  =  (isset($request->svgstyle[$colorSelectId]['fabric']))? $request->svgstyle[$colorSelectId]['fabric'][$colorSelected->id]:""; 
                            $svgsublimated = (isset($request->svgstyle[$colorSelectId]['svgsublimated']))? $request->svgstyle[$colorSelectId]['svgsublimated'][$colorSelected->id]:0;  
                            $colorSelectionPayload = [
                                // 'svg_g_id'=>$svg_g_id, 
                                'svgfabric'=> $svgfabric,
                                'svgsublimated'=>($svgsublimated=='on')?1:0
                            ];     
                            $update_color_selection = Svgcolor::find($colorSelected['id']);
                            $updateColorSelec =   $update_color_selection->update($colorSelectionPayload); 
                        }  
                        
                    }else{ 
                        // echo "Hello6";
                        // if(empty($request->svgfile)){  
                            $svg =  simplexml_load_file(public_path() . '/img/designs/'.$Designpattern->design_id.'/patterns/'.$Designpattern->pattern_id.'/style/'.$name);  
                            $svg_g_elements_count = count($svg->g);  
                            for($i = 0;$i<$svg_g_elements_count;$i++){
                              foreach($svg->g[$i]->attributes() as $a => $b) { 
                                //   echo $a,'="',$b,"\"\n";
                                  $svg_name = explode("Coloured_x5F_",$b);
                                  $save_svg_colors = Svgcolor::create([
                                    "styleId"=>$Designpattern->id,
                                    "svg_g_id"=>$b,
                                    "stylegender"=>$request->ngender,
                                    "svg_name"=>str_replace("_"," ",$svg_name[count($svg_name)-1])
                                  ]); 
                              }
                            } 
                            
                        // } 
                    }
                $GetExistStyleImage = Styledetail::where('styleid',$request->styleid)->where('styleImage','!=','')->orderby('gender','asc')->first(); 
                $payload = [
                    'styleName' => $request->styleName,   
                    'gender' => $request->gender ,
                    'styleImage'=>(isset($GetExistStyleImage->styleImage))?$GetExistStyleImage->styleImage:""
                ];   
                $update = $Designpattern->update($payload);     


                if(isset($request->saveClose)){  
                    return redirect('designs/show/'.$request->designid);   
                }else{
                    return redirect('designs/style/edit/'.$request->designid.'/'.$request->patternid.'/'.$request->styleid.'/'.$request->ngender)->with(['success'=> 'New SVG uploaded!','filename'=>$name]);   
                }
               
            } 

        }
        
            return redirect()->with('error', 'Failed to update design! Try again.');
        } catch (\Exception $e) {
            $bug = $e->getMessage(); 
             print_r($bug);die;
            // return redirect()->with('error', $bug);
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
                       $response = rmdir(public_path() . '/img/designs/'.$id);
                } 
            } 
            return redirect('designs')->with('success', 'User removed!');
        }

        return redirect('designs')->with('error', 'User not found');
    }

}