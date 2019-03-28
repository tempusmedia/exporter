<?php

namespace App\Http\Controllers;

use App\Exports\ProductsExport;
use App\Site;
use App\SiteExport;
use Automattic\WooCommerce\Client;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Pixelpeter\Woocommerce\WoocommerceClient;
use Woocommerce;
use Maatwebsite\Excel\Facades\Excel;


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
        $sites = auth()->user()->sites->load('exports');
        $exports = auth()->user()->exports;
        $site = $sites->first();
        $woocommerce = $this->woocommerceClient($site);
        $categories = collect($woocommerce->get('products/categories', ['per_page' => 100]))->sortBy('name');
        return view('index', compact(['categories', 'sites', 'exports', 'site']));
    }

    public function export(Request $request)
    {
        $site = Site::findOrFail($request->site);

        $woocommerce = $this->woocommerceClient($site);

        $page = 1;
        $all_products = [];
        $finished_array = [];
        $counter = 1;
        do {

        $request->category == 0

            ? $products = $woocommerce->get('products', ['per_page' => 100,
                                                        'page' => $page,
                                                        'status' => $request->status,
                                                        'stock_status' => $request->stock_status])

            : $products = $woocommerce->get('products', ['per_page' => 100,
                                                        'page' => $page,
                                                        'stock_status' => $request->stock_status,
                                                        'status' => $request->status,
                                                        'category' => $request->category]);

        $all_products = array_merge($all_products,$products);

        $page++;

        } while (count($products) > 0);

        // HEADER
        $finished_array[0] = [
            'ID',
            'ID2',
            'Item Title',
            'Final URL',
            'Image URL from subtitle',
            'Item Description',
            'Item Category',
            'Price',
            'Sale Price',
            'Item address',
            'Sale Price',
            'Tracking template',
            'Custom parameter',
            'Final mobile URL'
        ];
        
        foreach($all_products as $product)
        {
            $finished_array[$counter][] = $product["id"];
            $finished_array[$counter][] = null;
            $finished_array[$counter][] = $product["name"];
            $finished_array[$counter][] = $product["permalink"];
            $finished_array[$counter][] = collect($product["images"])->first()["src"];
            $finished_array[$counter][] = strip_tags($product["description"]);
            $finished_array[$counter][] = collect($product["categories"])->first()["name"];
            $finished_array[$counter][] = number_format((float) $product["price"], 2) . ' HRK';
            $finished_array[$counter][] = number_format((float) $product["sale_price"], 2) . ' HRK';
            $counter = $counter + 1;
        }

    //    return $this->download($finished_array, $request->type);

         $this->store($site, $finished_array, $request->type);

        return redirect()->back();
    }

    public function download($filename)
    {
        return response()->download(storage_path("app/public/{$filename}"));
    }


 public function store($site, $finished_array, $type)
    {

        $export = new ProductsExport([$finished_array]);

        $fileName = $site->name . ' - ' . Carbon::now()->format('dmyHis') . '.' . strtolower($type);


        Excel::store($export, $fileName,
            'public',  constant('\Maatwebsite\Excel\Excel::' . strtoupper($type)));

        $site->exports()->save(
            SiteExport::create(['name' => $fileName, 'type' => $type, 'user_id' => auth()->user()->id])
        );

    }

    public function woocommerceClient($site)
    {
        $client = new Client(
            $site->store_url,
            decrypt($site->consumer_key),
            decrypt($site->consumer_secret),
            [
                'version' => 'wc/'.config('woocommerce.api_version'),
                'verify_ssl' => config('woocommerce.verify_ssl'),
                'wp_api' => config('woocommerce.wp_api'),
                'query_string_auth' => config('woocommerce.query_string_auth'),
                'timeout' => config('woocommerce.timeout')
            ]);

        return new WoocommerceClient($client);
    }
}
