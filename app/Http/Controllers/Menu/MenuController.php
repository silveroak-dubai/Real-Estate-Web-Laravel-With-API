<?php

namespace App\Http\Controllers\Menu;

use App\Models\Menu;
use App\Models\Post;
use App\Models\Category;
use App\Models\MenuItem;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Traits\ResponseMessage;
use Illuminate\Support\Facades\Session;
use Yajra\DataTables\Facades\DataTables;

class MenuController extends Controller
{
    use ResponseMessage;

    public function index(Request $request){
        if($request->ajax()){
            if($request->ajax()){

                $getData = Menu::orderBy('id','desc');
                return DataTables::eloquent($getData)
                    ->addIndexColumn()
                    ->filter(function ($query) use ($request) {
                        if (!empty($request->search)) {
                            $query->where('title', 'LIKE', "%$request->search%");
                        }
                    })
                    ->addColumn('created_at', function($row){
                        return dateFormat($row->created_at);
                    })
                    ->addColumn('location', function($row){
                        return MENU_LOCATION_LABEL[$row->location];
                    })
                    ->addColumn('action', function($row){
                        $action = '<div class="d-flex align-items-center justify-content-end">';
                        if(permission('blog-edit')){
                        $action .= '<a href="'.url('menus/manage?id='.$row->id).'" class="btn-style btn-style-edit ms-1" ><i class="fa fa-edit"></i></a>';
                        }
                        if(permission('blog-delete')){
                        $action .= '<button type="button" class="btn-style btn-style-danger delete_data ms-1" data-id="' . $row->id . '" data-name="' . $row->title . '"><i class="fa fa-trash"></i></button>';
                        }
                        $action .= '</div>';

                        return $action;
                    })
                    ->rawColumns(['action','location'])
                    ->make(true);
            }
        }

        $this->set_page_data('Menu List','Menu List');
        return view('menu.list');
    }

    public function create(Request $request)
    {
        $menuitems = '';
        $desiredMenu = '';
        $id = $request->get('id');
        if (isset($id) && $id != 'new') {
            $desiredMenu = Menu::where('id', $id)->first();

            if (!empty($desiredMenu->content)) {
                $menuitems = json_decode($desiredMenu->content);
                foreach ($menuitems as $menu) {
                    $menuItem = MenuItem::where('id', $menu->id)->first();

                    if ($menuItem) {
                        $menu->title   = $menuItem->title;
                        $menu->name    = $menuItem->name;
                        $menu->slug    = $menuItem->slug;
                        $menu->target  = $menuItem->target;
                        $menu->type    = $menuItem->type;
                        $menu->classes = $menuItem->classes;

                        if (!empty($menu->children)) {
                            foreach ($menu->children as $child) {
                                $childItem = MenuItem::where('id', $child->id)->first();
                                if ($childItem) {
                                    $child->title   = $childItem->title;
                                    $child->name    = $childItem->name;
                                    $child->slug    = $childItem->slug;
                                    $child->target  = $childItem->target;
                                    $child->type    = $childItem->type;
                                    $child->classes = $childItem->classes;
                                }
                            }
                        }
                    }
                }
            } else {
                $menuitems = MenuItem::where('menu_id', $desiredMenu->id)->get();
            }
        } else {
            $desiredMenu = '';
        }

        $data['categories']  = Category::get(['id','name']);
        $data['posts']       = Post::get(['id','title']);
        $data['menus']       = Menu::get(['id','title']);
        $data['desiredMenu'] = $desiredMenu;
        $data['menuitems']   = $menuitems;

        $this->set_page_data('New Menu','New Menu');
        return view('menu.index', $data);
    }

    public function store(Request $request)
    {
        $data = $request->all();
        if (Menu::create($data)) {
            $newdata = Menu::orderby('id', 'DESC')->first();
            Session::flash('success', 'Menu saved successfully !');
            return redirect("menus/manage?id=$newdata->id")->with('success', 'Menu has been saved successful.');
        } else {
            return back()->with('error', 'Failed to save menu !');
        }
    }

    public function updateMenu(Request $request)
    {
        if($request->ajax()){
            $menu = Menu::find($request->menuid);
            if($menu){
                $menu->update([
                    'location'=>$request->location,
                    'content'=>json_encode($request->data)
                ]);
                return $this->response_json('success','Menu Updated Successful.');
            }else{
                return $this->response_json('error','Menu not saved.');
            }
        }
    }

    public function addCatToMenu(Request $request)
    {
        $data = $request->all();
        $menuid = $request->menuid;
        $ids = $request->ids;
        $menu = Menu::findOrFail($menuid);
        if($menu->content == ''){
          foreach($ids as $id){
            $data['title'] = Category::where('id',$id)->value('name');
            $data['slug'] = Category::where('id',$id)->value('slug');
            $data['type'] = 'category';
            $data['menu_id'] = $menuid;
            $data['updated_at'] = NULL;
            MenuItem::create($data);
          }
        }else{
          $olddata = json_decode($menu->content,true);
          foreach($ids as $id){
            $data['title'] = Category::where('id',$id)->value('name');
            $data['slug'] = Category::where('id',$id)->value('slug');
            $data['type'] = 'category';
            $data['menu_id'] = $menuid;
            $data['updated_at'] = NULL;
            MenuItem::create($data);
          }
          foreach($ids as $id){
            $array['title'] = Category::where('id',$id)->value('name');
            $array['slug'] = Category::where('id',$id)->value('slug');
            $array['type'] = 'category';
            $array['target'] = NULL;
            $array['id'] = MenuItem::where('slug',$array['slug'])->where('title',$array['title'])->where('type',$array['type'])->value('id');
            $array['children'] = [[]];
            array_push($olddata, ['id'=>$array['id']]);
            $olddata = json_encode($olddata);
            $menu->update(['content'=>$olddata]);
          }
        }
      }

      public function addPostToMenu(Request $request){
        $data = $request->all();
        $menuid = $request->menuid;
        $ids = $request->ids;
        $menu = menu::findOrFail($menuid);
        if($menu->content == ''){
          foreach($ids as $id){
            $data['title'] = Post::where('id',$id)->value('title');
            $data['slug'] = Post::where('id',$id)->value('slug');
            $data['type'] = 'post';
            $data['menu_id'] = $menuid;
            $data['updated_at'] = NULL;
            MenuItem::create($data);
          }
        }else{
          $olddata = json_decode($menu->content,true);
          foreach($ids as $id){
            $data['title'] = Post::where('id',$id)->value('title');
            $data['slug'] = Post::where('id',$id)->value('slug');
            $data['type'] = 'post';
            $data['menu_id'] = $menuid;
            $data['updated_at'] = NULL;
            MenuItem::create($data);
          }
          foreach($ids as $id){
            $array['title'] = Post::where('id',$id)->value('title');
            $array['slug'] = Post::where('id',$id)->value('slug');
            $array['type'] = 'post';
            $array['target'] = NULL;
            $array['id'] = MenuItem::where('slug',$array['slug'])->where('title',$array['title'])->where('type',$array['type'])->orderby('id','DESC')->value('id');
            $array['children'] = [[]];
            array_push($olddata, ['id'=>$array['id']]);
            $olddata = json_encode($olddata);
            $menu->update(['content'=>$olddata]);
          }
        }
      }

      public function addCustomLink(Request $request){
        $data = $request->all();
        $menuid = $request->menuid;
        $menu = menu::findOrFail($menuid);
        if($menu->content == ''){
          $data['title'] = $request->link;
          $data['slug'] = $request->url;
          $data['type'] = 'custom';
          $data['menu_id'] = $menuid;
          $data['updated_at'] = NULL;
          MenuItem::create($data);
        }else{
          $olddata = json_decode($menu->content,true);
          $data['title'] = $request->link;
          $data['slug'] = $request->url;
          $data['type'] = 'custom';
          $data['menu_id'] = $menuid;
          $data['updated_at'] = NULL;
          MenuItem::create($data);
          $array = [];
          $array['title'] = $request->link;
          $array['slug'] = $request->url;
          $array['name'] = NULL;
          $array['type'] = 'custom';
          $array['target'] = NULL;
          $array['id'] = MenuItem::where('slug',$array['slug'])->where('name',$array['name'])->where('type',$array['type'])->orderby('id','DESC')->value('id');
          $array['children'] = [[]];
          array_push($olddata, ['id'=>$array['id']]);
          $olddata = json_encode($olddata);
          $menu->update(['content'=>$olddata]);
        }
      }



    public function updateMenuItem(Request $request)
    {
        $data = $request->all();
        $item = MenuItem::findOrFail($request->id);
        $item->update($data);
        return redirect()->back();
    }

    public function deleteMenuItem($id, $key, $in = '')
    {
        $menuitem = MenuItem::findOrFail($id);
        $menu = Menu::where('id', $menuitem->menu_id)->first();

        if ($menu->content != '') {
            $data = json_decode($menu->content, true); // Decode JSON to array
            if ($in == '') {
                if (isset($data[$key])) {
                    unset($data[$key]);
                }
            } else {
                if (isset($data[$key]['children'][0][$in])) {
                    unset($data[$key]['children'][0][$in]);
                }
            }

            $newdata = json_encode($data);
            $menu->update(['content' => $newdata]);
        }

        $menuitem->delete();
        return back()->with('success', 'Menu item deleted successfully.');
    }


    public function delete(Request $request)
    {
        if(permission('achievement-delete')){
            $result = Menu::find($request->id);
            if($result){
                $result->delete();
                return $this->delete_message($result);
            }else{
                return $this->response_json('error','Data Cannot Delete',null,204);
            }
        }else{
            return $this->response_json('error',UNAUTORIZED_BLOCK,null,204);
        }

    }
}
