<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Pagination\Paginator;
use Intervention\Image\ImageManagerStatic as Image;
use App\Service;
use App\Category;
use App\User;
use App\Helpers\Flexihelp;
class CategoriesController extends Controller
{

    public function getCategory(Request $request, $parent_slug=null,$slug=null)
    {
      // echo $parent_slug;exit;
      $data['slug']=$slug;
      $data['parent_slug']=$parent_slug;
      $category = false;
      if ($parent_slug) {
        if ($request['is_api']) {
          $id = $parent_slug;
          $category = Category::where('id', $id)->first();
         }else{
          $parent = Category::where('slug', $parent_slug)->first();
          if($slug){
            $child = Category::where('slug', $slug)->first();
            if ($parent) {
              if ($parent['id'] == $child['parent_id']) {
                $category = $child;
              }
            }
          }else{
            $category = $parent;
          }
         }
         if ($category) {
           $id = $category->id;
           $data['status'] = true;
           $data['category'] = $category;
           $children = Category::where('parent_id', $id)->orderBy('name')->get();
             foreach ($children as $child) {
                $child->children = Category::where('parent_id', $child->id)->orderBy('name')->get();
                $child->children_status = (count($child->children)>0)?true:false;
             }
             $data['children_status'] = (count($children))?true:false;
             $data['children'] = (count($children))?$children:[];
           if ($request['is_api']) {
              return response()->json($data , 200);
            }else{
               if (count($children)>0) {
                  return view('subcat',$data);
               }else{
                  return redirect()->route($request->segment(2).'_list', ['slug'=>$slug]);
               }
            }
         }else{
          if ($request['is_api']) {
            $data['status'] = false;
            $data['message'] = 'record not found';
            return response()->json($data , 400);
          }else{
            abort(404);
          }
         }
      }
    }
    public function addcategory(Request $request)
    {
      if ($request['exeed_limit']) {
        $data['status']= false;
        $data['message']=['image'=>'file exeed limit'];
        return  response()->json($data,422);
      }
        $validator = Validator::make($request->all(), [
          'name' => 'required|max:100',
          'name_ar' => 'required|max:100',
          'slug' => 'required|max:100|unique:categories',
          'intro' => 'max:2500',
          'intro_ar' => 'max:2500'
        ]);
        if ($validator->fails()) {
          $data['status']=false;
          $data['message']= $validator->errors()->toArray();
          return response()->json($data,422);
        }
        $datatostore = $request->except(['exeed_limit','image','slug']);
        if ($request->file('image'))
          $datatostore['image'] = Flexihelp::upload($request->file('image'),'categoryicon')->pathToSave;
        $datatostore['slug'] = Flexihelp::clean($request->slug);
        $category = Category::create($datatostore);
        $data['status'] = true;
        $data['category'] = $category;
        return response()->json($data , 201);
    }
    public function updateCategory(Request $request)
    {
      if ($request['exeed_limit']) {
        $data['status']= false;
        $data['message']=['image'=>'file exeed limit'];
        return  response()->json($data,422);
      }
      $cat = Category::where('id',$request->id)->first();
        $validator = Validator::make($request->all(), [
          'id'   => 'required',
          'name_ar' => 'required|max:100',
          'name' => 'required|max:100',
          'slug' => 'required|unique:categories,slug,'.$request->id.'|max:100',
          'intro'=> 'max:2500',
          'intro_ar'=> 'max:2500'
        ]);
        if ($validator->fails()) {
          $data['status']=false;
          $data['message']= $validator->errors()->toArray();
          return response()->json($data,422);
        }
        $datatostore = $request->except(['exeed_limit','id','image','slug']);
        if ($request->file('image'))
            $datatostore['image'] = Flexihelp::upload($request->file('image'),'categoryicon')->pathToSave;
        $datatostore['slug'] = Flexihelp::clean($request->slug);
        $category = Category::find($request->id)->update($datatostore);
        $data['status'] = true;
        $data['category'] = Category::find($request->id);
        return response()->json($data , 201);
    }

    public function deleteCategory($id)
    {
      $category = Category::find($id);
      if ($category) {
        $data['status'] = true;
        $data['message'] = 'Request deleted succefully';
        $category->delete();
        return response()->json($data , 200);
      }else{
        $data['status'] = false;
        $data['message'] = 'record not found';
        return response()->json($data , 400);
      }
    }
    public function filterCategory(request $request)
    {
      $search = [];
      $limit = 10;

      if ($request->name)
        $search[] = ['name','like',"%".$request->name."%"];
      if ($request->name_ar)
        $search[] = ['name','like',"%".$request->name_ar."%"];
      if ($request->intro)
        $search[] = ['intro','like',"%".$request->intro."%"];
      if ($request->intro_ar)
        $search[] = ['intro_ar','like',"%".$request->intro_ar."%"];

      if ($request->limit)
        $limit = $request->limit;

       $category = Category::where($search)->limit($limit)->orderBy('name')->get();
       foreach ($category as $cat) {
         $children = Category::where('parent_id', $cat->id)->orderBy('name')->get();
         $cat->children_status = true;
         $parent = Category::where('id', $cat->parent_id)->first();
         if ($parent['parent_id']<=0) {
           $cat->parent = $parent['slug'];
         }else{
           $reparent = Category::where('id', $parent['parent_id'])->first();
           $cat->parent = $reparent['slug'];
           $cat->sub = $parent['slug'];
         }
       }
       if (count($category)) {
         $data['status'] = true;
         $data['category'] = $category;
         return response()->json($data , 200);
       }else{
        $data['status'] = false;
        $data['message'] = 'record not found';
        return response()->json($data , 208);
       }
    }
     
    public function dependancy(Request $request)
    {
        $category = Category::where('slug', $request->slug)->first();
        if ($category) {
          $children = Category::where('parent_id', $category->id)->orderBy('name')->get();
          if (count($children)>0) {
          $data = " ";
          if ($request->stage==1){
            if ($request->subidselector) {
              $data .="<select class='form-control pl-0' name='sub' id='".$request->subidselector."' required> <option value=''>".trans('service_category.dashboard_supplier_select_category')."</option>";
            }else{
              $data .="<select class='form-control pl-0' name='sub' id='subselector' required> <option value=''>".trans('service_category.dashboard_supplier_select_category')."</option>";
            }
          } else{
            $data .="<select class='form-control pl-0' name='subsub' required> <option value=''>".trans('service_category.dashboard_supplier_select_category')."</option>";
          }
          foreach ($children as $child) {
            $name = (app()->getLocale()=="ar")?$child->name_ar:$child->name;
            $data .= "<option value='".$child->slug."'>".$name."</option>";
            $child->children_status = (count(Category::where('parent_id', $child->id)->orderBy('name')->get())>0)?true:false;
          }
         $data.="</select>";
         if ($request->stage==1){
          if ($request->subidselector) {
            $data.="
                <script type='text/javascript'>
                    $('#".$request->subidselector."').on('change',function (e) {
                        $.post('".url(app()->getLocale()."/category/dependancy")."',
                                { _token:$('meta[name=\"csrf-token\"]').attr('content'),
                                  slug: $('#".$request->subidselector."').val(),
                                  stage: 2 
                                })
                        .done(function(content){
                            $( '#".$request->subsubid."' ).empty().append( content );
                        });
                    });
                </script>";
          }else{
             $data.="
                <script type='text/javascript'>
                    $('#subselector').on('change',function (e) {
                        $.post('".url(app()->getLocale()."/category/dependancy")."',
                                { _token:$('meta[name=\"csrf-token\"]').attr('content'),
                                  slug: $('#subselector').val(),
                                  stage: 2 
                                })
                        .done(function(content){
                            $( '#subsub' ).empty().append( content );
                        });
                    });
                </script>";
          }
         }
         return $data;
          }else{
            return "";
          }
        }else{
            return "";
        }
    }
     
    public function getParents(Request $request)
    {
       
       $categories = Category::where('parent_id', 0)->orderBy('name')->get();
       if ($categories) {
         $data['status'] = true;
         foreach ($categories as $category) {
            $children = Category::where('parent_id', $category->id)->get();
            $category['children_status'] = (count($children))?true:false;
            if (count($children)) {
              foreach ($children as $child) {
                $subchildren = Category::where('parent_id', $child->id)->get();
                $child['children_status'] = (count($subchildren))?true:false;
                $child['children'] = (count($subchildren))?$subchildren:'no child categories';
              }
            }
            $category['children'] = (count($children))?$children:'no child categories';
         }
         $data['categories'] = $categories;
         if ($request['is_api']) {
           return response()->json($data , 200);
         }else{
          return view('categories',$data);
         }
       }else{
        $data['status'] = false;
        $data['message'] = 'no categories found';
         return response()->json($data , 400);
       }
    }
     
    public function getChildren()
    {
        $result = [];
        $parents_categories = Category::where("parent_id",">",0)->orderBy('name')->get(); 
        if ($parents_categories) {
        foreach($parents_categories as $cat):
          $child = Category::where("parent_id",$cat->id)->orderBy('name')->get(); 
          if (!count($child)): 
            $parent = Category::where("id",$cat->parent_id)->first(); 
            $result[] = ['category'=>$cat,'parent'=>$parent];
          endif;
        endforeach;
        $data['categories'] = $result;
        return response()->json($data , 200);
       }else{
        $data['status'] = false;
        $data['message'] = 'no categories found';
         return response()->json($data , 400);
       }
    }
     
    public function keyskills(Request $request)
    { 
       $categories = Category::where('parent_id', 0)->orderBy('name')->get();
       if ($categories) {
         $data['status'] = true;
         $result = [];
         $i = 0;
         foreach ($categories as $category) {
            $children = Category::where('parent_id', $category->id)->get();
            if (count($children)) {
              foreach ($children as $child) {
                $subchildren = Category::where('parent_id', $child->id)->get();
                if(count($subchildren)){
                  foreach ($subchildren as $subchild) {
                    $result[$i] = ['id'=>$subchild->id,
                                   'name'=>$category->name.' - '.$child->name.' - '.$subchild->name,
                                   'name_ar'=>$category->name_ar.' - '.$child->name_ar.' - '.$subchild->name_ar,
                                   'slug'=>$subchild->slug
                                  ];$i++;
                  }
                }else{
                  $result[$i] = ['id'=>$child->id,
                                 'name'=>$category->name.' - '.$child->name,
                                 'name_ar'=>$category->name_ar.' - '.$child->name_ar,
                                 'slug'=>$child->slug
                                ];$i++;
                }
              }
            }
         }
         $data['categories'] = $result;
         return response()->json($data , 200);
       }else{
        $data['status'] = false;
        $data['message'] = 'no categories found';
         return response()->json($data , 400);
       }
    }
    
    public function getFeatured()
    {
       $categories = Category::where([['parent_id', 0],['featured',1]])->orderBy('name')->limit(6)->get();
       if ($categories) {
         $data['status'] = true;
         $data['categories'] = $categories;
         return response()->json($data , 200);
       }else{
        $data['status'] = false;
        $data['message'] = 'no categories found';
         return response()->json($data , 400);
       }
    }
     
}
