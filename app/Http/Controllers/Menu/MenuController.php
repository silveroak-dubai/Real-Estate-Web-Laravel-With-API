<?php

namespace App\Http\Controllers\Menu;

use App\Models\Menu;
use App\Models\Post;
use App\Models\Category;
use App\Models\MenuItem;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Traits\ResponseMessage;
use Illuminate\Support\Facades\Session;
use Yajra\DataTables\Facades\DataTables;

class MenuController extends Controller
{
    use ResponseMessage;

    public function index(Request $request){
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
        $data['departments'] = Department::get(['id','name']);
        $data['menus']       = Menu::get(['id','title']);
        $data['desiredMenu'] = $desiredMenu;
        $data['menuitems']   = $menuitems;

        $this->set_page_data('New Menu','New Menu');
        return view('menu.index', $data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'menu_name'=>['required','string','max:100']
        ]);
        $result = Menu::create(['title'=>$request->menu_name]);
        if ($result) {
            return redirect("menus/manage?id=$result->id")->with('success', 'Menu has been saved successful.');
        } else {
            return back()->with('error', 'Failed to save menu!');
        }
    }

    public function updateMenu(Request $request)
    {
        if($request->ajax()){
            $menu = Menu::find($request->menuid);
            if($menu){
                $menu->update([
                    'location' => $request->location,
                    'content'  => json_encode($request->data)
                ]);
                return $this->response_json('success','Menu Updated Successful.');
            }else{
                return $this->response_json('error','Menu not saved.');
            }
        }
    }

    public function delete(Request $request)
    {
        if($request->ajax()){
            if(permission('achievement-delete')){
                $result = Menu::find($request->id);
                if($result){
                    $result->delete();
                    return $this->delete_message($result,'Menu');
                }else{
                    return $this->response_json('error','Menu Cannot Delete',null,204);
                }
            }else{
                return $this->response_json('error',UNAUTORIZED_BLOCK,null,204);
            }
        }
    }
}
