<?php

namespace App\Http\Controllers;

use App\Exports\ProductsExport;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Woocommerce;
use App\Exports\UsersExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $categories = collect(Woocommerce::get('products/categories', ['per_page' => 100]))->sortBy('name');
        return view('index', ['categories' => $categories]);
    }

    public function arrayCreate(Request $request)
    {
        $category = 'Sirupi';
        $page = 1;
        $products = [];
        $all_products = [];
        $finished_array = [];
        $counter = 1;
        do{
        try {
        $request->category == 0
            ? $products = Woocommerce::get('products', ['per_page' => 100, 'page' => $page])
            : $products = Woocommerce::get('products', ['per_page' => 100, 'page' => $page, 'category' => $request->category]);


        }catch(HttpClientException $e){
            die("Can't get products: $e");
        }

        $all_products = array_merge($all_products,$products);

        $page++;
        } while (count($products) > 0);

        $header = array('ID','ID2','Item Title','Final URL','Image URL from subtitle','Item Description','Item Category','Price','Sale Price','Item address','Sale Price','Tracking template','Custom parameter','Final mobile URL'); //header
        $finished_array[0] = $header;

        foreach($all_products as $product)
        {
            $finished_array[$counter][] = $product["id"];
            $finished_array[$counter][] = null;
            $finished_array[$counter][] = $product["name"];
            $finished_array[$counter][] = $product["permalink"];
            $finished_array[$counter][] = collect($product["images"])->first()["src"];
            $finished_array[$counter][] = strip_tags($product["description"]);
            $finished_array[$counter][] = collect($product["categories"])->first()["name"];
            $finished_array[$counter][] = number_format($product["price"], 2) . ' HRK';
            $finished_array[$counter][] = number_format((float) $product["sale_price"], 2) . ' HRK';
            $counter = $counter + 1;
        }

        $format = $request->format;

        return $this->export($finished_array, $format);
    }

    public function export($finished_array, $format)
    {

        $export = new ProductsExport([$finished_array]);

        return Excel::download($export,
            'WooCommerce Export ' . Carbon::now()->format('d-m-Y') . '.' . strtolower($format),
                constant('\Maatwebsite\Excel\Excel::' . strtoupper($format)));
    }
}
