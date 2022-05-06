<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Brand;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $new_products = Product::orderBy('created_at', 'DESC')->with('images')->take(12)->get();
        $sellest_products = Product::orderBy('sold', 'DESC')->with('images')->take(12)->get();

        $brands = Brand::all();

        return view('home', [
            'new_products' => $new_products,
            'sellest_products' => $sellest_products,
            'brands' => $brands,
        ]);
    }

    public function changeLanguage($language)
    {
        session()->put('locale', $language);

        return redirect()->back();
    }
}
