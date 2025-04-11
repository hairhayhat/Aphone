<?php
namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;

class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('user.categories.index');
    }
}
