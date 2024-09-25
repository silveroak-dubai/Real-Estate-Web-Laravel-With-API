<?php

namespace App\Http\Controllers\Menu;

use App\Models\Blog;
use App\Models\Menu;
use App\Models\Category;
use App\Models\MenuItem;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MenuItemController extends Controller
{
    public function addCatToMenu(Request $request){
        $data = $request->all();
        $menuid = $request->menuid;
        $ids = $request->ids;
        $menu = Menu::findOrFail($menuid);
        if($menu->content == ''){
          foreach($ids as $id){
            $data['title'] = category::where('id',$id)->value('name');
            $data['slug'] = category::where('id',$id)->value('slug');
            $data['type'] = 'category';
            $data['menu_id'] = $menuid;
            $data['updated_at'] = NULL;
            MenuItem::create($data);
          }
        }else{
          $olddata = json_decode($menu->content,true);
          foreach($ids as $id){
            $data['title'] = category::where('id',$id)->value('name');
            $data['slug'] = category::where('id',$id)->value('slug');
            $data['type'] = 'category';
            $data['menu_id'] = $menuid;
            $data['updated_at'] = NULL;
            MenuItem::create($data);
          }
          foreach($ids as $id){
            $array['title'] = category::where('id',$id)->value('name');
            $array['slug'] = category::where('id',$id)->value('slug');
            $array['name'] = NULL;
            $array['type'] = 'category';
            $array['target'] = NULL;
            $array['id'] = MenuItem::where('slug',$array['slug'])->where('name',$array['name'])->where('type',$array['type'])->value('id');
            $array['children'] = [[]];
            array_push($olddata[0],$array);
            $olddata = json_encode($olddata);
            $menu->update(['content'=>$olddata]);
          }
        }
      }

      public function addPostToMenu(Request $request){
        $data = $request->all();
        $menuid = $request->menuid;
        $ids = $request->ids;
        $menu = Menu::findOrFail($menuid);
        if($menu->content == ''){
          foreach($ids as $id){
            $data['title'] = Blog::where('id',$id)->value('title');
            $data['slug'] = Blog::where('id',$id)->value('slug');
            $data['type'] = 'post';
            $data['menu_id'] = $menuid;
            $data['updated_at'] = NULL;
            MenuItem::create($data);
          }
        }else{
          $olddata = json_decode($menu->content,true);
          foreach($ids as $id){
            $data['title'] = Blog::where('id',$id)->value('title');
            $data['slug'] = Blog::where('id',$id)->value('slug');
            $data['type'] = 'post';
            $data['menu_id'] = $menuid;
            $data['updated_at'] = NULL;
            MenuItem::create($data);
          }
          foreach($ids as $id){
            $array['title'] = Blog::where('id',$id)->value('title');
            $array['slug'] = Blog::where('id',$id)->value('slug');
            $array['name'] = NULL;
            $array['type'] = 'post';
            $array['target'] = NULL;
            $array['id'] = MenuItem::where('slug',$array['slug'])->where('name',$array['name'])->where('type',$array['type'])->orderby('id','DESC')->value('id');
            $array['children'] = [[]];
            array_push($olddata[0],$array);
            $olddata = json_encode($olddata);
            $menu->update(['content'=>$olddata]);
          }
        }
      }

      public function addCustomLink(Request $request){
        $data = $request->all();
        $menuid = $request->menuid;
        $menu = Menu::findOrFail($menuid);
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
          array_push($olddata[0],$array);
          $olddata = json_encode($olddata);
          $menu->update(['content'=>$olddata]);
        }
      }

    public function updateMenuItem(Request $request){
        $data = $request->all();
        $item = MenuItem::findOrFail($request->id);
        $item->update($data);
        return redirect()->back();
      }

      public function deleteMenuItem($id,$key,$in=''){
        $menuitem = MenuItem::findOrFail($id);
        $menu = Menu::where('id',$menuitem->menu_id)->first();
        if($menu->content != ''){
          $data = json_decode($menu->content,true);
          $maindata = $data[0];
          if($in == ''){
            unset($data[0][$key]);
            $newdata = json_encode($data);
            $menu->update(['content'=>$newdata]);
          }else{
            unset($data[0][$key]['children'][0][$in]);
            $newdata = json_encode($data);
            $menu->update(['content'=>$newdata]);
          }
        }
        $menuitem->delete();
        return redirect()->back();
      }
}
