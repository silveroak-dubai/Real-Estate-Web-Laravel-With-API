<?php

namespace App\Http\Controllers\Menu;

use App\Models\Blog;
use App\Models\Menu;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\MenuItem;

class MenuController extends Controller
{
    public function index(Request $request) {
        $menuitems = [];
        $desiredMenu = '';
        $id = $request->get('id'); // Retrieve the 'id' parameter from the request

        if (isset($id) && $id != 'new') {
            $desiredMenu = Menu::where('id', $id)->first();
            if ($desiredMenu && !empty($desiredMenu->content)) {
                // Decode JSON to an associative array
                $menuitems = json_decode($desiredMenu->content, true);

                if (isset($menuitems[0])) { // Check if there's at least one menu item
                    $menuitems = $menuitems[0]; // Access the first menu item
                    foreach ($menuitems as &$menu) {
                        $menu['title'] = MenuItem::where('id', $menu['id'])->value('title');
                        $menu['name'] = MenuItem::where('id', $menu['id'])->value('name');
                        $menu['slug'] = MenuItem::where('id', $menu['id'])->value('slug');
                        $menu['target'] = MenuItem::where('id', $menu['id'])->value('target');
                        $menu['type'] = MenuItem::where('id', $menu['id'])->value('type');

                        // Check if children exist and update their properties
                        if (!empty($menu['children'][0])) {
                            foreach ($menu['children'][0] as &$child) {
                                $child['title'] = MenuItem::where('id', $child['id'])->value('title');
                                $child['name'] = MenuItem::where('id', $child['id'])->value('name');
                                $child['slug'] = MenuItem::where('id', $child['id'])->value('slug');
                                $child['target'] = MenuItem::where('id', $child['id'])->value('target');
                                $child['type'] = MenuItem::where('id', $child['id'])->value('type');
                            }
                        }
                    }
                }
            } else {
                // Fallback if no content exists
                $menuitems = MenuItem::where('menu_id', $desiredMenu->id)->get();
            }
        } else {
            // Handle the case when no specific menu ID is provided
            $desiredMenu = Menu::orderby('id', 'DESC')->first();
            if ($desiredMenu && !empty($desiredMenu->content)) {
                // Decode JSON to an associative array
                $menuitems = json_decode($desiredMenu->content, true);

                if (isset($menuitems[0])) { // Check if there's at least one menu item
                    $menuitems = $menuitems[0]; // Access the first menu item
                    foreach ($menuitems as &$menu) {
                        $menu['title'] = MenuItem::where('id', $menu['id'])->value('title');
                        $menu['name'] = MenuItem::where('id', $menu['id'])->value('name');
                        $menu['slug'] = MenuItem::where('id', $menu['id'])->value('slug');
                        $menu['target'] = MenuItem::where('id', $menu['id'])->value('target');
                        $menu['type'] = MenuItem::where('id', $menu['id'])->value('type');

                        // Check if children exist and update their properties
                        if (!empty($menu['children'][0])) {
                            foreach ($menu['children'][0] as &$child) {
                                $child['title'] = MenuItem::where('id', $child['id'])->value('title');
                                $child['name'] = MenuItem::where('id', $child['id'])->value('name');
                                $child['slug'] = MenuItem::where('id', $child['id'])->value('slug');
                                $child['target'] = MenuItem::where('id', $child['id'])->value('target');
                                $child['type'] = MenuItem::where('id', $child['id'])->value('type');
                            }
                        }
                    }
                }
            } else {
                $menuitems = MenuItem::where('menu_id', $desiredMenu->id)->get();
            }
        }

        $this->set_page_data('Menu', 'Menu');
        return view('menu.index', [
            'categories' => Category::all(),
            'posts' => Blog::all(),
            'menus' => Menu::all(),
            'desiredMenu' => $desiredMenu,
            'menuitems' => $menuitems
        ]);
    }


      public function store(Request $request){
        $data = $request->all();
        if(Menu::create($data)){
          $newdata = Menu::orderby('id','DESC')->first();
          return redirect("manage-menus?id=$newdata->id")->with('success','Menu saved successfully !');
        }else{
          return redirect()->back()->with('error','Failed to save menu !');
        }
      }

    public function updateMenu(Request $request){
        $newdata             = $request->all();
        $menu                = Menu::findOrFail($request->menuid);
        $content             = $request->data;
        $newdata             = [];
        $newdata['location'] = $request->location;
        $newdata['content']  = json_encode($content);
        $menu->update($newdata);
    }

    public function destroy(Request $request){
        MenuItem::where('menu_id',$request->id)->delete();
        Menu::findOrFail($request->id)->delete();
        return redirect('manage-menus')->with('success','Menu deleted successfully');
    }
}
