<?php

namespace App\Http\Controllers;

use App\Exports\ProductsExport;
use App\Helpers\Woo;
use App\Site;
use App\SiteExport;
use Carbon\Carbon;
use DonatelloZa\RakePlus\RakePlus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;


class HomeController extends Controller
{
    use Woo;
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
    public function index(Request $request)
    {


        $sites = auth()->user()->sites;
        $site = $request->has('site' ) ? $sites->find($request->site) : $sites->first();
        $exports = $site->exports()->orderBy('id', 'desc')->paginate(5);

        if (auth()->user()->sites->first()) {
            $woocommerce = $this->woocommerceClient($site);
            $categories = collect($woocommerce->get('products/categories', ['per_page' => 100]))->sortBy('name');
        }

        return view('index', compact(['categories', 'sites', 'exports', 'site']));
    }


    /**
     * Exports from WooCommerce REST API endpoin to document
     * Store exported document to filesistem and database
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
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

                ? $products = $woocommerce->get('products', [
                                                                 'per_page'     => 100,
                                                                 'page'         => $page,
                                                                 'status'       => $request->status,
                                                                 'stock_status' => $request->stock_status ])

                : $products = $woocommerce->get('products', [
                                                                 'per_page'     => 100,
                                                                 'page'         => $page,
                                                                 'stock_status' => $request->stock_status,
                                                                 'status'       => $request->status,
                                                                 'category'     => $request->category ]);

            $all_products = array_merge($all_products, $products);

            $page++;

        } while (count($products) > 0);


        // SET HEADER //
        $finished_array[0] = $this->getHeader();

        foreach ($all_products as $product) {
            $finished_array[$counter][] = $product["sku"]; // ID2
            $finished_array[$counter][] = $product["id"]; // ID2
            $finished_array[$counter][] = $product["name"]; // Item title
            $finished_array[$counter][] = $product["permalink"]; // Final URL
            $finished_array[$counter][] = collect($product["images"])->first()["src"]; // Image URL
           // $finished_array[$counter][] = Str::limit(strip_tags($product["name"]), 25);  // Item subtitle
           // $finished_array[$counter][] = $product["description"] != ''
           //                                     ?  Str::limit(strip_tags($product["description"]), 25)
           //                                     :  Str::limit(strip_tags($product["short_description"]), 25);// Item description
            $finished_array[$counter][] = '';
            $finished_array[$counter][] = '';
            $finished_array[$counter][] = collect($product["categories"])->first()["name"]; // Item category
            $finished_array[$counter][] = $product["price"] . ' HRK'; // Price
            $finished_array[$counter][] = $product["sale_price"] ? $product["sale_price"] . ' HRK' : ''; // 'Sale price',
         //   $finished_array[$counter][] = $this->getContextualKeywords($product["name"]) . ', ' .
          //      $this->getContextualKeywords(collect($product["categories"])->first()["name"]); // 'Contextual keywords',


            // //$finished_array[$counter][] = $this->getContextualKeywords(collect($product["categories"])->first()["name"]); // 'Contextual keywords',

            $counter = $counter + 1;
        }

      //s return $finished_array;
        $reponse = $this->store($site, $finished_array, $request->type);

        alert()->success('Export <b>' . $reponse . '</b> successfully created!');

        return redirect()->back()->withInput();
    }


    /**
     * @param $site
     * @param $finished_array
     * @param $type
     * @return string
     */
    public function store($site, $finished_array, $type)
    {
        $fileName = $site->name . ' - ' . Carbon::now()->format('dmyHis') . '.' . strtolower($type);

        (new ProductsExport([$finished_array]))->store($fileName, 'public', constant('\Maatwebsite\Excel\Excel::' . strtoupper($type)));

        $site->exports()->save(SiteExport::create(['name' => $fileName, 'type' => $type, 'user_id' => auth()->user()->id]));

        return $fileName;
    }


    /**
     * @param $filename
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function download($filename)
    {
        return response()->download(storage_path("app/public/{$filename}"));
    }

    /**
     * @param SiteExport $siteExport
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function delete(SiteExport $siteExport)
    {
        Storage::disk('public')->delete($siteExport->name);
        $siteExport->delete();
        flash('Export <b>' . $siteExport->name . '</b> successfully deleted!')->success();
        return redirect()->back();
    }

    /**
     * @return array
     */
    public function getHeader()
    {
       return [
           'ID',
           'ID2',
           'Item title',
           'Final URL',
           'Image URL',
           'Item subtitle',
           'Item description',
           'Item category',
           'Price',
           'Sale price',
           'Contextual keywords',
           'Item address',
           'Tracking template',
           'Custom parameter',
           'Final mobile URL'

        /**'ID',
           'ID2',
           'Item Title',
           'Final URL',
           'Image URL from subtitle',
           'Item Description',
           'Item Category',
           'Price',
           'Sale Price',
           'Item address',
           'Tracking template',
           'Custom parameter',
           'Final mobile URL'
           **/

       ];
    }


    /**
     * @param $text
     * @return array
     */
    public function getContextualKeywords($text) : string {
        $text = preg_split("/[^\w]*([\s]+[^\w]*|$)/", $text, -1, PREG_SPLIT_NO_EMPTY);
        $text = array_unique($text);
        return implode($text, ', ');
    }

}
