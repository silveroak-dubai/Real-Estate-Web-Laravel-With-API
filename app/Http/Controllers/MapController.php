<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class MapController extends Controller
{
    public function generateSlug(Request $request)
    {
        // Generate the initial slug
        $slug = Str::slug($request->title, '-');
        $originalSlug = $slug;
        $count = 1;

        while (DB::table($request->model)->where('slug', $slug)->exists()) {
            $slug = Str::limit($originalSlug . '-' . $count, 255, '');
            $count++;

            if ($count > 20) {
                return response()->json(['error' => 'Failed to generate unique slug'], 500);
            }
        }

        // Return the generated slug as a JSON response
        return response()->json(['slug' => $slug]);
    }
}
