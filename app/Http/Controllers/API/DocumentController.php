<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DocumentController extends Controller
{

    public function apiDocs()
    {
        $apiDocs = file_get_contents(storage_path('api_docs.json'));
        $apiDocs = json_decode($apiDocs,true);

        return view('api-docs', compact('apiDocs'));
    }
}
