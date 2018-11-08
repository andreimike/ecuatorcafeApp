<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Customer;
use App\Models\Option;
use Illuminate\Http\Request;
use App\Models\CustomerUploadFile;
use App\Models\OrderUploadFile;
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
use GuzzleHttp\Middleware;


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
        // Validate the file from upload
        $this->validate($request, [
            'file' => 'required|max:100000'
        ]);
        // Get the file
        $file = $request->file('file');
        $time = time();
        $formattedTime = date('Y-m-d', $time);
        $detailedFormattedTime = date('Y-m-d H:i:s', $time);
        // Hash for uploaded file
        $fileName = $formattedTime . "-" . str_random(8) . "-" . $file->getClientOriginalName();
        // Set name for order file
        // Function from above getClientOriginalName take already file extension
        //$fileName = $fileHash . '.' . $request->file('file')->getClientOriginalExtension();
        // Save order file on server
        $path = Storage::putFileAs('orders', $file, $fileName);
        // Save in DB path and user for order file
        $data = [
            'orders_uploads_path' => $path,
            'id_utilizator' => Auth::user()->id
        ];
        OrderUploadFile::create($data);
        //Get From Option Table last API Token
        $smdDayApiTokenOption = Option::find(1);
        $smdApiTokenExDate = $smdDayApiTokenOption->validity_shipping_api_token;
        if ($smdApiTokenExDate == 0) {
            // Make a POST Request to SameDay API to generate a new auth Token with validity for 30 days
            // Setup the client info
            $client = new \GuzzleHttp\Client([
                'timeout' => 2.0,
                'headers' =>
                    [
                        'Accept' => 'application/json',
                        'Content-Type' => 'application/json',
                        'X-Auth-Username' => 'topstarAPI',
                        'X-Auth-Password' => 'l4djE/Ev9g=='
                    ],
                'auth' =>
                    [
                        'topstarAPI',
                        'l4djE/Ev9g=='
                    ]
            ]);
            try {
                $response = $client->POST('https://sameday-api.demo.zitec.com/api/authenticate', [
                    'query' => ['remember_me' => 'true']
                ]);
            } catch (\Exception $ex) {
                \Log::error($ex);
            }
            //Get Request Response Code -> 200 Succes
            $statusCode = $response->getStatusCode();
            // Convert API Response to String and get body content
            $resData = (string)$response->getBody();
            $resData = json_decode($resData);
            $apiToken = $resData->token;
            $apiValidityDate = $resData->expire_at;
            $smdDayApiTokenOption->shipping_api_token = $apiToken;
            $smdDayApiTokenOption->validity_shipping_api_token = $apiValidityDate;
            $smdDayApiTokenOption->updated_at = $detailedFormattedTime;
            $smdDayApiTokenOption->save();
        } elseif ($smdApiTokenExDate <= $detailedFormattedTime) {
            // Make a POST Request to SameDay API to generate a new auth Token with validity for 30 days
            // Setup the client info
            $client = new \GuzzleHttp\Client([
                'timeout' => 2.0,
                'headers' =>
                    [
                        'Accept' => 'application/json',
                        'Content-Type' => 'application/json',
                        'X-Auth-Username' => 'topstarAPI',
                        'X-Auth-Password' => 'l4djE/Ev9g=='
                    ],
                'auth' =>
                    [
                        'topstarAPI',
                        'l4djE/Ev9g=='
                    ]
            ]);
            try {
                $response = $client->POST('https://sameday-api.demo.zitec.com/api/authenticate', [
                    'query' => ['remember_me' => 'true']
                ]);
            } catch (\Exception $ex) {
                \Log::error($ex);
            }
            //Get Request Response Code -> 200 Succes
            $statusCode = $response->getStatusCode();
            // Convert API Response to String and get body content
            $resData = (string)$response->getBody();
            $resData = json_decode($resData);
            $apiToken = $resData->token;
            $apiValidityDate = $resData->expire_at;
            $smdDayApiTokenOption->shipping_api_token = $apiToken;
            $smdDayApiTokenOption->validity_shipping_api_token = $apiValidityDate;
            $smdDayApiTokenOption->updated_at = $detailedFormattedTime;
            $smdDayApiTokenOption->save();
        }
        $ordersArray = Excel::toArray(new CustomersImport, $file);
        // Order Array Index
        $i = 0;
        // Product Array index
        $j = 0;
        $arraySize = count($ordersArray[0]);
        $orderProducts = array();
        $fryingDateBraz = $request->get('date1');
        $fryingDateCol = $request->get('date2');
        $fryingDateEti = $request->get('date3');
        //Delete all the row and entry of the Orders Table
        DB::table('orders')->truncate();
        while ($i <= $arraySize) {
            // Clear Product Object
            unset($orderProducts);
            // Foreach index of order array
            foreach ($ordersArray as $orderArray) {
                // Get order ID
                $currentOrderId = $orderArray[$i][2];
                // Get Contractor EAN
                $currentContractorEan = $orderArray[$i + 10][2];
                // Initializes Product Object
                $product = (object)[];
                //First Product - get infos
                $product->product_ean = $orderArray[$i + 12][1];
                $product->product_name = $orderArray[$i + 12][2];
                $product->product_qty = (int)$orderArray[$i + 12][5];
                $product->product_price = (int)$orderArray[$i + 12][7];
                // Set frying date for product
                if ($orderArray[$i + 12][1] == 2000005405518) {
                    $product->frying_date = date($fryingDateBraz);

                } elseif ($orderArray[$i + 12][1] == 2000005405525) {
                    $product->frying_date = date($fryingDateCol);
                } else {
                    $product->frying_date = date($fryingDateEti);
                }
                // End Set frying date
                // Get product in array
                $prod1 = (array)$product;
                // Get product in array by index - $j
                $orderProducts[$j] = $prod1;
                // Incrementing Product Array Index
                $j++;
                if ($orderArray[$i + 13][0] == null) {
                    // Convert Order Array in string
                    $orderProductsToString = json_encode($orderProducts);
                    // Escape some character
                    $clearProductString = str_replace('.00 ', '', $orderProductsToString);
                    // Insert order in DB
                    $data = [
                        'order_number' => $currentOrderId,
                        'contractor_ean_id' => $currentContractorEan,
                        'product' => $clearProductString,
                    ];
                    Order::create($data);
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
                    if (!isset($orderArray[$i + 14][0])) {
                        // Convert Order Array in string
                        $orderProductsToString = json_encode($orderProducts);
                        // Escape some character
                        $clearProductString = str_replace('.00 ', '', $orderProductsToString);
                        // Insert order in DB
                        $data = [
                            'order_number' => $currentOrderId,
                            'contractor_ean_id' => $currentContractorEan,
                            'product' => $clearProductString,
                        ];
                        Order::create($data);
                        // End insert Order in DB
                        $i += 15;
                    } elseif ($orderArray[$i + 14][0] == null) {
                        // Convert Order Array in string
                        $orderProductsToString = json_encode($orderProducts);
                        // Escape some character
                        $clearProductString = str_replace('.00 ', '', $orderProductsToString);
                        // Insert order in DB
                        $data = [
                            'order_number' => $currentOrderId,
                            'contractor_ean_id' => $currentContractorEan,
                            'product' => $clearProductString,
                        ];
                        Order::create($data);
                        // End insert Order in DB
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
                        // Convert Order Array in string
                        $orderProductsToString = json_encode($orderProducts);
                        // Escape some character
                        $clearProductString = str_replace('.00 ', '', $orderProductsToString);
                        // Insert order in DB
                        $data = [
                            'order_number' => $currentOrderId,
                            'contractor_ean_id' => $currentContractorEan,
                            'product' => $clearProductString,
                        ];
                        Order::create($data);
                        // End insert Order in DB
                        $i += 16;
                    }
                }
            }
        }
        return redirect()->route('order.view')->with('success', 'Comenzile au fost importate cu succes!  || A fost generat cu succes un nou Token pentru Curier');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public
    function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public
    function edit($id)
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
    public
    function update(Request $request, $id)
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
    public
    function destroy($id)
    {
        //
    }

    public
    function serialNumber()
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

    public
    function generateDeclaration($id)
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

    public
    function generateDeclarations()
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

    public
    function generateNotice($id)
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

    public
    function generateNotices()
    {
        $orders = Order::with('customer')->get();
        // Get Current time
        $time = time();
        // Formatting the current Time
        $formattedTime = date('Y-m-d', $time);
        $pdf = App::make('dompdf.wrapper');
        $pdf = PDF::loadView('pages.order.notices', compact('orders', 'orderCustomer'))->setPaper('a4', 'portrait');
        $totalOrders = DB::table('orders')->count();
        //Set for all conformity_declaration column from 0 to 1 after the PDF
        DB::table('orders')
            ->having('id', '>=', $totalOrders)
            ->update(['notice' => 1]);
        return $pdf->download('Avize-de-insotire-' . $formattedTime . '.pdf');
    }

    public
    function noticeDownload($id)
    {
        //PDF file is stored under project/public/download/info.pdf
        $file = Order::find($id);
        $fileName = $file->notice_pdf_path;
        $filePath = '/app/avize/' . $fileName;
        return response()->download(storage_path() . $filePath);
    }

    public
    function createInvoice($id)
    {
        $order = Order::find($id);
        $productInfosArray = json_decode($order['product'], true);
        $ecuatorCui = "RO31883947";
        $orderId = $order->id;
        // Get Order Number
        $orderNumber = $order->order_number;
        // Get Customer For Each Order by Order Number
        $orderCustomer = Order::with('customer')->where('order_number', '=', $orderNumber)->get();
        $smartBillInvoiceMentions = 'Numar comanda ' . $order->order_number;
        $reqData = [
            'companyVatCode' => $ecuatorCui,
            'client' => [
                'name' => $orderCustomer[0]->customer->nume,
                'vatCode' => $orderCustomer[0]->customer->cui,
                'address' => $orderCustomer[0]->customer->adresa,
                'isTaxPayer' => false,
                'city' => $orderCustomer[0]->customer->localitate,
                'county' => $orderCustomer[0]->customer->judet,
                'country' => 'Romania',
                'saveToDb' => false,
            ],
            'isDraft' => true,
            'issueDate' => date('Y-m-d'),
            'seriesName' => 'TSNP',
            'currency' => 'RON',
            'language' => 'RO',
            'precision' => 1,
            'dueDate' => date('Y-m-d', time() + 14 * 3600),
            'useStock' => false,
            'usePaymentTax' => false,
            'useEstimateDetails' => false,
            'observations' => $smartBillInvoiceMentions,
            'mentions' => $smartBillInvoiceMentions,
            'products' => []
        ];

        $i = 0;
        foreach ($productInfosArray as $orderInfo) {

            $reqData['products'][$i] =
                ['name' => $orderInfo['product_name'],
                    'isDiscount' => false,
                    'measuringUnitName' => 'buc',
                    'currency' => 'RON',
                    'quantity' => $orderInfo['product_qty'],
                    'price' => $orderInfo['product_price'],
                    'isTaxIncluded' => true,
                    'taxName' => 'Redusa',
                    'taxPercentage' => 9,
                    'saveToDb' => false,
                    'isService' => false,
                ];
            $i++;
        }
        $client = new \GuzzleHttp\Client([
            'timeout' => 2.0,
            'headers' =>
                [
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json'
                ],
            'auth' =>
                [
                    'office@ecuatorcafe.ro',
                    '6ecf8b23f08a05eb91bcf5f69d248d2c'
                ]
        ]);
        try {
            $response = $client->POST('https://ws.smartbill.ro:8183/SBORO/api/invoice', [
                \GuzzleHttp\RequestOptions::JSON => $reqData
            ]);
        } catch (\Exception $ex) {
            \Log::error($ex);
        }
        //Get Request Response Code -> 200 Succes
        $statusCode = $response->getStatusCode();
        if ($statusCode == 200) {
            // Set in DB Col SmartBill_Invoice From Null to 1 - after it was created
            $order->smart_bill_invoice = 1;
            // Save in DB
            $order->save();
            return redirect()->route('order.view')->with('success', 'Factura a fost generata cu succes in SmartBill');
        } else {
            return redirect()->route('order.view')->with('error', 'Factura NU a fost generata!');
        }

//        $data = (string)$response->getBody();
//        $data = json_decode($data);
////        dd($data);

    }

    public function getToken()
    {
        $client = new \GuzzleHttp\Client([
            'timeout' => 2.0,
            'headers' =>
                [
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                    'X-Auth-Username' => 'topstarAPI',
                    'X-Auth-Password' => 'l4djE/Ev9g=='
                ],
            'auth' =>
                [
                    'topstarAPI',
                    'l4djE/Ev9g=='
                ]
        ]);
        try {
            $response = $client->POST('https://sameday-api.demo.zitec.com/api/authenticate', [
                'query' => ['remember_me' => 'true']
            ]);
        } catch (\Exception $ex) {
            \Log::error($ex);
        }
        //Get Request Response Code -> 200 Succes
        $statusCode = $response->getStatusCode();
        $data = (string)$response->getBody();
        $data = json_decode($data);
//        $data = json_encode($data);
        var_dump($data->token);
        var_dump($data->expire_at);
        dd($data);
    }
}
