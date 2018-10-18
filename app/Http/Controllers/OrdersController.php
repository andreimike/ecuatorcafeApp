<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\CustomerFileUpload;
use App\Imports\CustomersImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\File;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\UploadedFile;
use Maatwebsite\Excel\HeadingRowImport;
use Auth;
use Illuminate\Support\Facades\Storage;

class OrdersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $orders = Order::all();
        $raws = DB::table('orders')->select('product')->get()->toArray();
        $productsAsocArray = $raws;
       // $asoc = json_decode($productsAsocArray['product'], true);
//        dd($productsAsocArray);
//        foreach ($raws as $raw){
//            $decodeProductString = $raw->product;
//            $d = json_encode($decodeProductString);
//
//            var_dump($productsAsocArray);
//        }
//        dd($raws);
//        foreach ($raws as $k => $v) {
//            $decodeProductString = json_decode($raws->product);
//            $productsAsocArray = json_decode(json_encode($decodeProductString), true);
//        }


        return view('pages.order.index', compact('orders', 'productsAsocArray'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.order.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'file' => 'required|max:100000'
        ]);
        $file = $request->file('file');
        $time = time();
        $formatedTime = date('Y-m-d', $time);
        $fileHash = $file->getClientOriginalName() . "-" . $formatedTime;
        $fileName = $fileHash . '.' . $request->file('file')->getClientOriginalExtension();
        $path = Storage::putFileAs('orders', $file, $fileName);
        $data = [
            'cale_fisier' => $path,
            'id_utilizator' => Auth::user()->id
        ];
        CustomerFileUpload::create($data);
        $ordersArray = Excel::toArray(new CustomersImport, $file);
        $i = 0;
        $j = 0;
        $arraySize = count($ordersArray[0]);
        $orderProducts = array();
        //Delete all the row and entry of the Orders Table
        DB::table('orders')->truncate();
        while ($i <= $arraySize) {
            unset($orderProducts);
            foreach ($ordersArray as $orderArray) {
                $currentOrderId = $orderArray[$i][2];
                $currentContractorEan = $orderArray[$i + 10][2];
                $product = (object)[];
                $product->product_ean = $orderArray[$i + 12][1];
                $product->product_name = $orderArray[$i + 12][2];
                $product->product_qty = $orderArray[$i + 12][5];
                $product->product_price = $orderArray[$i + 12][7];
                $prod1 = (array)$product;
                $orderProducts[$j] = $prod1;
                $j++;
                if ($orderArray[$i + 13][0] == null) {
                    $i += 14;
                } else {
                    $product = (object)[];
                    $product->product_ean = $orderArray[$i + 13][1];
                    $product->product_name = $orderArray[$i + 13][2];
                    $product->product_qty = $orderArray[$i + 13][5];
                    $product->product_price = $orderArray[$i + 13][7];
                    $prod2 = (array)$product;
                    $orderProducts[$j] = $prod2;
                    $j++;
                    if ($orderArray[+14][0] == null) {
                        $i += 15;
                    } else {
                        $product = (object)[];
                        $product->product_ean = $orderArray[$i + 13][1];
                        $product->product_name = $orderArray[$i + 13][2];
                        $product->product_qty = $orderArray[$i + 13][5];
                        $product->product_price = $orderArray[$i + 13][7];
                        $prod3 = (array)$product;
                        $orderProducts[$j] = $prod3;
                        $j++;
                        $i += 16;
                    }
                }

                $orderProductsToString = json_encode($orderProducts);
                $clearProductString = str_replace('.00 ', '', $orderProductsToString);
                $data = [
                    'order_number' => $currentOrderId,
                    'contractor_ean_id' => $currentContractorEan,
                    'product' => $clearProductString,
                ];
                Order::create($data);
            }
        }
        return redirect()->route('customer.view')->with('success', 'Comenzile au fost importate cu succes!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
