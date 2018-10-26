<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Customer;
use App\Models\Option;
use Illuminate\Http\Request;
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
use Barryvdh\DomPDF\Facade as PDF;
use App;

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
        $orders = Order::with('customer')->get();

        return view('pages.order.index', compact('orders', 'customers'));
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
            'cale_fisier' => $path,
            'id_utilizator' => Auth::user()->id
        ];
        CustomerFileUpload::create($data);
        $ordersArray = Excel::toArray(new CustomersImport, $file);
        $i = 0;
        $j = 0;
        $arraySize = count($ordersArray[0]);
        $orderProducts = array();
        $fryingDateBraz = $request->get('date1');
        $fryingDateCol = $request->get('date2');
        $fryingDateEti = $request->get('date3');
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
                $product->product_qty = (int)$orderArray[$i + 12][5];
                $product->product_price = (int)$orderArray[$i + 12][7];
                if ($orderArray[$i + 12][1] == 2000005405518) {
                    $product->frying_date = date($fryingDateBraz);

                } elseif ($orderArray[$i + 12][1] == 2000005405525) {
                    $product->frying_date = date($fryingDateCol);
                } else {
                    $product->frying_date = date($fryingDateEti);
                }
                $prod1 = (array)$product;
                $orderProducts[$j] = $prod1;
                $j++;
                if ($orderArray[$i + 13][0] == null) {
                    $i += 14;
                } else {
                    $product = (object)[];
                    $product->product_ean = $orderArray[$i + 13][1];
                    $product->product_name = $orderArray[$i + 13][2];
                    $product->product_qty = (int)$orderArray[$i + 13][5];
                    $product->product_price = (int)$orderArray[$i + 13][7];
                    if ($orderArray[$i + 13][1] == 2000005405518) {
                        $product->frying_date = date($fryingDateBraz);

                    } elseif ($orderArray[$i + 13][1] == 2000005405525) {
                        $product->frying_date = date($fryingDateCol);
                    } else {
                        $product->frying_date = date($fryingDateEti);
                    }
                    $prod2 = (array)$product;
                    $orderProducts[$j] = $prod2;
                    $j++;
                    if ($orderArray[+14][0] == null) {
                        $i += 15;
                    } else {
                        $product = (object)[];
                        $product->product_ean = $orderArray[$i + 14][1];
                        $product->product_name = $orderArray[$i + 14][2];
                        $product->product_qty = (int)$orderArray[$i + 14][5];
                        $product->product_price = (int)$orderArray[$i + 14][7];
                        if ($orderArray[$i + 14][1] == 2000005405518) {
                            $product->frying_date = date($fryingDateBraz);

                        } elseif ($orderArray[$i + 14][1] == 2000005405525) {
                            $product->frying_date = date($fryingDateCol);
                        } else {
                            $product->frying_date = date($fryingDateEti);
                        }
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
        return redirect()->route('order.view')->with('success', 'Comenzile au fost importate cu succes!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
//        $order = Order::find($id);
//        return view('pages.order.edit')->with('order', $order);
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
//        $order = Order::find($id);
//        $productFryingDate = json_decode($order['product'], true);
//        $orderProductsToString = json_encode($productFryingDate[0]['frying_date']);
//        $order->$orderProductsToString[0]['frying_date'] = $request->input('date');
//        dd($order);

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

    public function conformity($id)
    {


        $order = Order::find($id);
            $productInfosArray = json_decode($order['product'], true);
            $pdf = App::make('dompdf.wrapper');
            $pdf = PDF::loadView('pages.order.conformity', compact('order'))->setPaper('a4', 'portrait');
            $pdfFileName = $order->order_number;
            $order->conformity_declaration = 1;
            $order->save();
            return $pdf->download('Declaratie-de-Conformititate-' . $pdfFileName . '.pdf');

    }

    public function declarations()
    {
        $orders = Order::all();
        $pdf = App::make('dompdf.wrapper');
        $pdf = PDF::loadView('pages.order.declarations', compact('orders'))->setPaper('a4', 'portrait');
        //Count total number of orders
        $totalOrders = DB::table('orders')->count();
        //Set for all conformity_declaration column from 0 to 1 after the PDF
        DB::table('orders')
            ->having('id', '>=', $totalOrders)
            ->update(['conformity_declaration' => 1]);
        return $pdf->download('Declaratii-de-Conformititate' . '.pdf');

    }

    public function notice($id)
    {
        $order = Order::find($id);
        $productInfosArray = json_decode($order['product'], true);
        $orderId = $order->id;
        $option = Option::all();
        $data = [
            'order_id' => $orderId
        ];
        Option::create($data);
        $increment = DB::table('options')->increment('serial_number', 1);
        $data1 = [

            'serial_number' => $increment,
        ];
        Option::create($data1);
        // $serialNumber = $option->serial_number;
//        $orderSerialNumber = new Option;
//        $orderSerialNumber->order_id = $order->id;


    }
}
