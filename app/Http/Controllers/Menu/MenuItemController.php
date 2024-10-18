<?php

namespace App\Http\Controllers\Menu;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Category;
use App\Models\Department;
use App\Models\Menu;
use App\Models\MenuItem;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MenuItemController extends Controller
{
    public function addCatToMenu(Request $request)
    {
        if($request->ajax()){
            $menuId = $request->menuId;
            $ids    = $request->ids;
            $menu   = Menu::find($menuId);
            $data   = [];

            try {
                if($menu && $menu->content == ''){
                    foreach($ids as $id){
                        $category         = Category::find($id);
                        $data[] = [
                            'menu_id'    => $menuId,
                            'title'      => $category->name,
                            'slug'       => $category->slug,
                            'type'       => 'category',
                            'created_at' => now()
                        ];
                    }
                    MenuItem::insert($data);
                    return $this->response_json('success','Menu items added.');
                }else if($menu && $menu->content != ''){

                }else{
                    return $this->response_json('error','Menu item cannot saved!');
                }
            } catch (\Exception $e) {
                return $this->response_json('error',$e->getMessage());
            }
        }
    }

    public function addPostToMenu(Request $request)
    {
        if($request->ajax()){
            $menuId = $request->menuId;
            $ids    = $request->ids;
            $menu   = Menu::find($menuId);
            $data   = [];
            if($menu && $menu->content == ''){
                foreach($ids as $id){
                    $post         = Post::find($id);
                    $data[] = [
                        'menu_id'    => $menuId,
                        'title'      => $post->title,
                        'slug'       => $post->slug,
                        'type'       => 'post',
                        'created_at' => now()
                    ];
                }
                MenuItem::insert($data);
                return $this->response_json('success','Menu items added.');
            }else if($menu && $menu->content != ''){

            }else{
                return $this->response_json('error','Something went wrong!');
            }
        }
    }

    public function addDepartmentToMenu(Request $request)
    {
        if($request->ajax()){
            $menuId = $request->menuId;
            $ids    = $request->ids;
            $menu   = Menu::find($menuId);
            $data   = [];
            if($menu && $menu->content == ''){
                foreach($ids as $id){
                    $department         = Department::find($id);
                    $data[] = [
                        'menu_id'    => $menuId,
                        'title'      => $department->name,
                        'slug'       => $department->slug,
                        'type'       => 'department',
                        'created_at' => now()
                    ];
                }
                MenuItem::insert($data);
                return $this->response_json('success','Menu items added.');
            }else if($menu && $menu->content != ''){

            }else{
                return $this->response_json('error','Something went wrong!');
            }
        }
    }

    public function addCustomLink(Request $request){
        if($request->ajax()){
            $validator = Validator::make($request->all(),[
                'menu_id'   => ['required','integer'],
                'url'       => ['required','string'],
                'link_text' => ['required','string','max:60']
            ]);

            if($validator->fails()){
                return $this->response_json(false,null,['errors'=>$validator->errors()]);
            }

            $menuId = $request->menu_id;
            $menu   = Menu::find($menuId);
            try {
                if($menu && empty($menu->content)){
                    MenuItem::insert([
                        'menu_id'    => $menuId,
                        'title'      => $request->link_text,
                        'slug'       => $request->url,
                        'type'       => 'custom',
                        'created_at' => now()
                    ]);

                    return $this->response_json('success','Menu items added.');
                }else if($menu && $menu->content != ''){

                }else{
                    return $this->response_json('error','Menu item not added!');
                }
            } catch (\Exception $e) {
                return $this->response_json('error',$e->getMessage());
            }
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
}
