<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Like;
use Illuminate\Http\Request;

class AdminLikeController extends Controller
{
    public function index()
    {
        $likes = Like::orderBy('created_at', 'desc')->get();
        return view('admin.likes', compact('likes'));
    }
}
