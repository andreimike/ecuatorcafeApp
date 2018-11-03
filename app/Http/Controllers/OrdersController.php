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
use Illuminate\Support\Facades\DB;
use Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Barryvdh\DomPDF\Facade as PDF;
use App;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;


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

    public function serialNumber()
    {
        $orders = Order::all();
        // Get Initial Serial Number From DB by ID(1)
        $serialNumber = Option::find(1);
        // Get Serial Number From Option Table
        $initialSerialNumber = $serialNumber->serial_number;
        $i = 1;
        foreach ($orders as $order) {
            //For each Order increment serial number by 1($i)
            $incrementSerialNumber = $initialSerialNumber + $i;
            // Increment serial number by 1
            $i++;
            // Save for each order serial number
            $order->serial_number = $incrementSerialNumber;
            $order->save();
        }
        // Store final serial number
        $finalSerialNumber = $incrementSerialNumber;
        // Save final serial number in Option Table
        $serialNumber->serial_number = $finalSerialNumber;
        $serialNumber->save();

        return redirect()->route('order.view')->with('Success', 'Au fost generate cu succes numere de serii pentru toate comenziile');
    }

    public function generateDeclaration($id)
    {


        $order = Order::find($id);
        $productInfosArray = json_decode($order['product'], true);
        $pdf = App::make('dompdf.wrapper');
        $pdf = PDF::loadView('pages.order.declaration', compact('order'))->setPaper('a4', 'portrait');
        $pdfFileName = $order->order_number;
        $order->conformity_declaration = 1;
        $order->save();
        return $pdf->download('Declaratie-de-Conformititate-' . $pdfFileName . '.pdf');

    }

    public function generateDeclarations()
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

    public function generateNotice($id)
    {
        //Get Order infos
        $order = Order::find($id);
        $productInfosArray = json_decode($order['product'], true);
        // Get Order Id
        $orderId = $order->id;
        // Get Order Number
        $orderNumber = $order->order_number;
        // Get Current time
        $time = time();
        // Formatting the current Time
        $formattedTime = date('Y-m-d', $time);
        // Get Customer For Each Order by Order Number
        $orderCustomer = Order::with('customer')->where('order_number', '=', $orderNumber)->get();
        // Generate a Name for each Notice Pdf by Order Number And Current Time
        $pdfFileName = 'AvizNr-' . $order->order_number . '-' . $formattedTime . '.pdf';
        // New Directory for Storage Notice Pdf - OneTimeUsed
        $savePath = '/avize/';
        // Check if Directory exist in Storage Path/App
        if (!File::exists(storage_path($savePath))) {
            // If Directory doesn't exist Create A New One - OneTimeUse
            Storage::makeDirectory($savePath);
        }
        // Pdf Make Functions
        $pdf = App::make('dompdf.wrapper');
        // 1. Get Pdf Content from a View, 2. Send variable to the View, Set paper Format, 3.Save The Notice Pdf to specific Path using Laravel Storage Path, New Folder("avize") and a unique name
        $pdf = PDF::loadView('pages.order.notice', compact('order', 'orderCustomer', 'totalOrders'))->setPaper('a4', 'portrait')->setWarnings(false)->save(storage_path() . '/app' . $savePath . $pdfFileName);
        // Set in DB Col Notice From Null to 1 - after it was created
        $order->notice = 1;
        // Storage in DB Col notice_pdf_path The filename for Notice Pdf
        $order->notice_pdf_path = $pdfFileName;
        // Save in DB
        $order->save();
        return redirect()->route('order.view')->with('success', 'Avizul de insotire a fost generat cu succes! Puteti sa il descarcati');
    }

    public function generateNotices()
    {
        $orders = Order::with('customer')->get();
        // Get Current time
        $time = time();
        // Formatting the current Time
        $formattedTime = date('Y-m-d', $time);
        $pdf = App::make('dompdf.wrapper');
        $pdf = PDF::loadView('pages.order.notices', compact('orders'))->setPaper('a4', 'portrait');
        $totalOrders = DB::table('orders')->count();
        //Set for all conformity_declaration column from 0 to 1 after the PDF
        DB::table('orders')
            ->having('id', '>=', $totalOrders)
            ->update(['notice' => 1]);
        return $pdf->download('Avize-de-insotire-' . $formattedTime . '.pdf');
    }

    public function noticeDownload($id)
    {
        //PDF file is stored under project/public/download/info.pdf
        $file = Order::find($id);
        $fileName = $file->notice_pdf_path;
        $filePath = '/app/avize/' . $fileName;
        return response()->download(storage_path() . $filePath);
    }

    public function smartBillApi()
    {
        $client = new Client([
            // Base URI is used with relative requests
            'base_uri' => 'https://ws.smartbill.ro:8183',
            // You can set any number of default request options.
            'timeout' => 2.0,
            'headers' =>
                [
                    'Accept' => 'application/json',
//                    'Accept' => 'application/octet-stream',
                    'Content-Type' => 'application/json'
                ],
            'auth' =>
                [
                    'office@ecuatorcafe.ro',
                    '6ecf8b23f08a05eb91bcf5f69d248d2c'
                ]
        ]);

        $response = $client->get('/SBORO/api/invoice/paymentstatus',
            ['query' =>
                [
                    'cif' => 'RO31883947',
                    'seriesname' => 'TSNP',
                    'number' => '2858'
                ]]
        );
        $data = (string) $response->getBody();
        $data = json_decode($data);
        dd($data->unpaidAmount);

    }

}
