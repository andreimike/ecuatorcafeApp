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
        // Messages Array index
        $k = 0;
        $messages = array();
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
                // Get Customer Name
                $customername = $orderArray[$i + 9][2];
                // Get Contractor EAN
                $currentContractorEan = $orderArray[$i + 10][2];
                // Initializes Product Object
                $product = (object)[];
                //First Product - get infos
                $product->product_ean = $orderArray[$i + 12][1];
                $product->product_name = $orderArray[$i + 12][2];
                $product->product_qty = (int)$orderArray[$i + 12][5];
                $product->product_price = number_format((float)$orderArray[$i + 12][7] * 1.09, 2, '.', '');
                // Set frying date for product
                if ($orderArray[$i + 12][1] == 2000005405518) {
                    $product->frying_date = date($fryingDateBraz);

                } elseif ($orderArray[$i + 12][1] == 2000005405525) {
                    $product->frying_date = date($fryingDateCol);
                } elseif ($orderArray[$i + 12][1] == 2000005405532) {
                    $product->frying_date = date($fryingDateEti);
                } else {
                    $product->frying_date = date($fryingDateBraz);
                }
                // End Set frying date
                // Get product in array
                $prod1 = (array)$product;
                // Get product in array by index - $j
                $orderProducts[$j] = $prod1;
                // Incrementing Product Array Index
                $j++;
                if (!isset($orderArray[$i + 13][0])) {
                    // Convert Order Array in string
                    $orderProductsToString = json_encode($orderProducts);
                    // Escape some character
                    $clearProductString = str_replace('.00 ', '', $orderProductsToString);
                    // Check if contractor EAN exists in Customers Table
                    // IF exists:
                    if (Customer::where('contractor_ean', '=', $currentContractorEan)->exists()) {
                        // Insert order in DB
                        $data = [
                            'order_number' => $currentOrderId,
                            'contractor_ean_id' => $currentContractorEan,
                            'product' => $clearProductString,
                        ];
                        Order::create($data);
                    } else {
                        // Saves the client that does not exist in message array to dispaly
                        $messages[$j] = $customername;
                        $j++;
                    }

                    $i += 14;

                } elseif ($orderArray[$i + 13][0] == null) {
                    // Convert Order Array in string
                    $orderProductsToString = json_encode($orderProducts);
                    // Escape some character
                    $clearProductString = str_replace('.00 ', '', $orderProductsToString);
                    if (Customer::where('contractor_ean', '=', $currentContractorEan)->exists()) {
                        // Insert order in DB
                        $data = [
                            'order_number' => $currentOrderId,
                            'contractor_ean_id' => $currentContractorEan,
                            'product' => $clearProductString,
                        ];
                        Order::create($data);
                    } else {
                        // Saves the client that does not exist in message array to dispaly
                        $messages[$j] = $customername;
                        $j++;
                    }

                    $i += 14;

                } else {
                    $product = (object)[];
                    $product->product_ean = $orderArray[$i + 13][1];
                    $product->product_name = $orderArray[$i + 13][2];
                    $product->product_qty = (int)$orderArray[$i + 13][5];
                    $product->product_price = number_format((float)$orderArray[$i + 13][7] * 1.09, 2, '.', '');
                    if ($orderArray[$i + 13][1] == 2000005405518) {
                        $product->frying_date = date($fryingDateBraz);
                    } elseif ($orderArray[$i + 13][1] == 2000005405525) {
                        $product->frying_date = date($fryingDateCol);
                    } elseif ($orderArray[$i + 13][1] == 2000005405532) {
                        $product->frying_date = date($fryingDateEti);
                    } else {
                        $product->frying_date = date($fryingDateBraz);
                    }
                    $prod2 = (array)$product;
                    $orderProducts[$j] = $prod2;
                    $j++;
                    if (!isset($orderArray[$i + 14][0])) {
                        // Convert Order Array in string
                        $orderProductsToString = json_encode($orderProducts);
                        // Escape some character
                        $clearProductString = str_replace('.00 ', '', $orderProductsToString);
                        if (Customer::where('contractor_ean', '=', $currentContractorEan)->exists()) {
                            // Insert order in DB
                            $data = [
                                'order_number' => $currentOrderId,
                                'contractor_ean_id' => $currentContractorEan,
                                'product' => $clearProductString,
                            ];
                            Order::create($data);
                        } else {
                            // Saves the client that does not exist in message array to dispaly
                            $messages[$j] = $customername;
                            $j++;
                        }

                        // End insert Order in DB
                        $i += 15;

                    } elseif ($orderArray[$i + 14][0] == null) {
                        // Convert Order Array in string
                        $orderProductsToString = json_encode($orderProducts);
                        // Escape some character
                        $clearProductString = str_replace('.00 ', '', $orderProductsToString);
                        if (Customer::where('contractor_ean', '=', $currentContractorEan)->exists()) {
                            // Insert order in DB
                            $data = [
                                'order_number' => $currentOrderId,
                                'contractor_ean_id' => $currentContractorEan,
                                'product' => $clearProductString,
                            ];
                            Order::create($data);
                        } else {

                            // Saves the client that does not exist in message array to dispaly
                            $messages[$j] = $customername;
                            $j++;
                        }
                        // End insert Order in DB
                        $i += 15;

                    } else {
                        $product = (object)[];
                        $product->product_ean = $orderArray[$i + 14][1];
                        $product->product_name = $orderArray[$i + 14][2];
                        $product->product_qty = (int)$orderArray[$i + 14][5];
                        $product->product_price = number_format((float)$orderArray[$i + 14][7] * 1.09, 2, '.', '');
                        if ($orderArray[$i + 14][1] == 2000005405518) {
                            $product->frying_date = date($fryingDateBraz);

                        } elseif ($orderArray[$i + 14][1] == 2000005405525) {
                            $product->frying_date = date($fryingDateCol);
                        } elseif ($orderArray[$i + 14][1] == 2000005405532) {
                            $product->frying_date = date($fryingDateEti);
                        } else {
                            $product->frying_date = date($fryingDateBraz);
                        }
                        $prod3 = (array)$product;
                        $orderProducts[$j] = $prod3;
                        $j++;
                        if (!isset($orderArray[$i + 15][0])) {
                            // Convert Order Array in string
                            $orderProductsToString = json_encode($orderProducts);
                            // Escape some character
                            $clearProductString = str_replace('.00 ', '', $orderProductsToString);
                            if (Customer::where('contractor_ean', '=', $currentContractorEan)->exists()) {
                                // Insert order in DB
                                $data = [
                                    'order_number' => $currentOrderId,
                                    'contractor_ean_id' => $currentContractorEan,
                                    'product' => $clearProductString,
                                ];
                                Order::create($data);
                            } else {
                                // Saves the client that does not exist in message array to dispaly
                                $messages[$j] = $customername;
                                $j++;
                            }

                            $i += 16;

                        } elseif ($orderArray[$i + 15][0] == null) {
                            // Convert Order Array in string
                            $orderProductsToString = json_encode($orderProducts);
                            // Escape some character
                            $clearProductString = str_replace('.00 ', '', $orderProductsToString);
                            if (Customer::where('contractor_ean', '=', $currentContractorEan)->exists()) {
                                // Insert order in DB
                                $data = [
                                    'order_number' => $currentOrderId,
                                    'contractor_ean_id' => $currentContractorEan,
                                    'product' => $clearProductString,
                                ];
                                Order::create($data);
                            } else {
                                // Saves the client that does not exist in message array to dispaly
                                $messages[$j] = $customername;
                                $j++;
                            }

                            $i += 16;

                        } else {
                            $product = (object)[];
                            $product->product_ean = $orderArray[$i + 15][1];
                            $product->product_name = $orderArray[$i + 15][2];
                            $product->product_qty = (int)$orderArray[$i + 15][5];
                            $product->product_price = number_format((float)$orderArray[$i + 15][7] * 1.09, 2, '.', '');
                            if ($orderArray[$i + 15][1] == 2000005405518) {
                                $product->frying_date = date($fryingDateBraz);

                            } elseif ($orderArray[$i + 15][1] == 2000005405525) {
                                $product->frying_date = date($fryingDateCol);
                            } elseif ($orderArray[$i + 15][1] == 2000005405532) {
                                $product->frying_date = date($fryingDateEti);
                            } else {
                                $product->frying_date = date($fryingDateBraz);
                            }
                            $prod4 = (array)$product;
                            $orderProducts[$j] = $prod4;
                            $j++;
                            // Convert Order Array in string
                            $orderProductsToString = json_encode($orderProducts);
                            // Escape some character
                            $clearProductString = str_replace('.00 ', '', $orderProductsToString);
                            if (Customer::where('contractor_ean', '=', $currentContractorEan)->exists()) {
                                // Insert order in DB
                                $data = [
                                    'order_number' => $currentOrderId,
                                    'contractor_ean_id' => $currentContractorEan,
                                    'product' => $clearProductString,
                                ];
                                Order::create($data);
                            } else {
                                // Saves the client that does not exist in message array to dispaly
                                $messages[$j] = $customername;
                                $j++;
                            }

                            $i += 17;

                        }
                    }
                }
            }
        }
        $distinctNotFoundCustomers = array_unique($messages);

        $getAllOrders = Order::all();

        if (count($getAllOrders)) {
            if (count($distinctNotFoundCustomers)) {
                return redirect()->route('order.view')->with('error', 'Comenzile au fost importate PARTIAL! Unul sau mai multi Clienti Lipsesc.')->with('distinctNotFoundCustomers', $distinctNotFoundCustomers);
            } else {
                return redirect()->route('order.view')->with('success', 'Comenzile au fost importate cu succes!');
            }
        } else {
            return redirect()->route('order.view')->with('error', 'Comenzile nu au fost importate! Unul sau mai multi Clienti Lipsesc.')->with('distinctNotFoundCustomers', $distinctNotFoundCustomers);
        }
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

    public function generateStickers()
    {

        $i = 0;
        $j = 0;
        $time = time();
        $detailedFormattedTime = date('Y-m-d H:i:s', $time);
        $completeStickersArray = array();
        $stickersArray = array();
        $productInfosObj = (object)[];
        $orders = Order::all();
        foreach ($orders as $order) {
            unset($stickersArray);
            $productInfosArray = json_decode($order['product'], true);
            foreach ($productInfosArray as $productInfo) {
                $productInfosObj->product_name = $productInfo['product_name'];
                $productInfosObj->frying_date = $productInfo['frying_date'];
                if ($productInfo['product_qty'] / 10 > floor($productInfo['product_qty'] / 10)) {
                    $productInfosObj->number_of_pages = floor($productInfo['product_qty'] / 10) + 1;
                } else {
                    $productInfosObj->number_of_pages = floor($productInfo['product_qty'] / 10);
                    $productInfosObj->duplicate_page = null;
                }
                $orderItems = (array)$productInfosObj;
                $stickersArray[$i] = $orderItems;
                $i++;
            }
            $completeStickersArray[$j] = $stickersArray;
            $j++;

        }

        $pdf = App::make('dompdf.wrapper');
        $pdf = PDF::loadView('pages.order.stickers', compact('completeStickersArray'))->setPaper('a4', 'portrait');

        return $pdf->download('Etichete_Comenzi_' . $detailedFormattedTime . '.pdf');

    }

    public
    function generateNotice($id)
    {
        //Get Order infos
        $order = Order::find($id);
        $productInfosArray = json_decode($order['product'], true);
        // Get Order Id
        $orderId = $order->id;
        $totalOrders = DB::table('orders')->count();
        // Get Order Number
        $orderNumber = $order->order_number;
        // Get Current time
        $time = time();
        // Formatting the current Time
        $formattedTime = date('Y-m-d', $time);
        // Get Customer For Each Order by Order Number
        $orderCustomer = Order::with('customer')->where('order_number', '=', $orderNumber)->get();
        // Generate a Name for each Notice Pdf by Order Number And Current Time
//        $pdfFileName = 'AvizNr-' . $order->order_number . '-' . $formattedTime . '.pdf';
//        // New Directory for Storage Notice Pdf - OneTimeUsed
//        $savePath = '/avize/';
//        // Check if Directory exist in Storage Path/App
//        if (!File::exists(storage_path($savePath))) {
//            // If Directory doesn't exist Create A New One - OneTimeUse
//            Storage::makeDirectory($savePath);
//        }
        // Pdf Make Functions
        $pdf = App::make('dompdf.wrapper');
        // 1. Get Pdf Content from a View, 2. Send variable to the View, Set paper Format, 3.Save The Notice Pdf to specific Path using Laravel Storage Path, New Folder("avize") and a unique name
//        $pdf = PDF::loadView('pages.order.notice', compact('order', 'orderCustomer', 'totalOrders'))->setPaper('a4', 'portrait')->setWarnings(false)->save(storage_path() . '/app' . $savePath . $pdfFileName);
        $pdf = PDF::loadView('pages.order.notice', compact('order', 'orderCustomer', 'totalOrders'))->setPaper('a4', 'portrait');
        // Set in DB Col Notice From Null to 1 - after it was created
        $order->notice = 1;
        // Storage in DB Col notice_pdf_path The filename for Notice Pdf
//        $order->notice_pdf_path = $pdfFileName;
        // Save in DB
        $order->save();
        return $pdf->download('Aviz-de-insotire-' . $orderId . "-" . $formattedTime . '.pdf');
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

//    public
//    function noticeDownload($id)
//    {
//        //PDF file is stored under project/public/download/info.pdf
//        $file = Order::find($id);
//        $fileName = $file->notice_pdf_path;
//        $filePath = '/app/avize/' . $fileName;
//        return response()->download(storage_path() . $filePath);
//    }

    public
    function createInvoice($id)
    {
        $order = Order::find($id);
        $productInfosArray = json_decode($order['product'], true);
        $ecuatorCui = "RO31883947";
        $customerCompanyName = 'AUCHAN ROMANIA SA';
        $dueDate = date('Y-m-d', time() + 720 * 3600);
        $orderId = $order->id;
        // Get Order Number
        $orderNumber = $order->order_number;
        // Get Customer For Each Order by Order Number
        $orderCustomer = Order::with('customer')->where('order_number', '=', $orderNumber)->get();
        $smartBillInvoiceMentions = 'Numar comanda ' . $order->order_number;
        $reqData = [
            'companyVatCode' => $ecuatorCui,
            'client' => [
                'name' => $customerCompanyName,
                'vatCode' => $orderCustomer[0]->customer->cui,
                'address' => $orderCustomer[0]->customer->adresa,
                'isTaxPayer' => false,
                'city' => $orderCustomer[0]->customer->localitate,
                'county' => $orderCustomer[0]->customer->judet,
                'country' => 'Romania',
                'saveToDb' => false,
            ],
            'isDraft' => false,
            'issueDate' => date('Y-m-d'),
            'seriesName' => 'TSNP',
            'currency' => 'RON',
            'language' => 'RO',
            'precision' => 2,
            'dueDate' => date('Y-m-d', time() + 720 * 3600),
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
                    'quantity' => (int)$orderInfo['product_qty'],
                    'price' => number_format((float)$orderInfo['product_price'], 2, '.', ''),
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
            dd($ex);
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

    public
    function getToken()
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
            dd($ex);
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

    /**
     * //    public
     * //    function devGetSDAPIToken($id)
     * //    {
     * //        $order = Order::find($id);
     * //        $productInfosArray = json_decode($order['product'], true);
     * //        $ecuatorCui = "RO31883947";
     * //        $customerCompanyName = 'AUCHAN ROMANIA SA';
     * //        $orderId = $order->id;
     * //        // Get Order Number
     * //        $orderNumber = $order->order_number;
     * //        // Get Customer For Each Order by Order Number
     * //        $orderCustomer = Order::with('customer')->where('order_number', '=', $orderNumber)->get();
     * //        $smartBillInvoiceMentions = 'Numar comanda ' . $order->order_number;
     * //        $reqData = [
     * //            'companyVatCode' => $ecuatorCui,
     * //            'client' => [
     * //                'name' => $customerCompanyName,
     * //                'vatCode' => $orderCustomer[0]->customer->cui,
     * //                'address' => $orderCustomer[0]->customer->adresa,
     * //                'isTaxPayer' => false,
     * //                'city' => $orderCustomer[0]->customer->localitate,
     * //                'county' => $orderCustomer[0]->customer->judet,
     * //                'country' => $orderCustomer[0]->customer->tara,
     * //                'saveToDb' => false,
     * //            ],
     * //            'isDraft' => true,
     * //            'issueDate' => date('Y-m-d'),
     * //            'seriesName' => 'TSNP',
     * //            'currency' => 'RON',
     * //            'language' => 'RO',
     * //            'precision' => 1,
     * //            'dueDate' => date('Y-m-d', time() + 14 * 3600),
     * //            'useStock' => false,
     * //            'usePaymentTax' => false,
     * //            'useEstimateDetails' => false,
     * //            'observations' => $smartBillInvoiceMentions,
     * //            'mentions' => $smartBillInvoiceMentions,
     * //            'products' => []
     * //        ];
     * //
     * //        $i = 0;
     * //        foreach ($productInfosArray as $orderInfo) {
     * //
     * //            $reqData['products'][$i] =
     * //                ['name' => $orderInfo['product_name'],
     * //                    'isDiscount' => false,
     * //                    'measuringUnitName' => 'buc',
     * //                    'currency' => 'RON',
     * //                    'quantity' => $orderInfo['product_qty'],
     * //                    'price' => $orderInfo['product_price'],
     * //                    'isTaxIncluded' => true,
     * //                    'taxName' => 'Redusa',
     * //                    'taxPercentage' => 9,
     * //                    'saveToDb' => false,
     * //                    'isService' => false,
     * //                ];
     * //            $i++;
     * //        }
     * //        $client = new \GuzzleHttp\Client([
     * //            'timeout' => 2.0,
     * //            'headers' =>
     * //                [
     * //                    'Accept' => 'application/json',
     * //                    'Content-Type' => 'application/json'
     * //                ],
     * //            'auth' =>
     * //                [
     * //                    'office@ecuatorcafe.ro',
     * //                    '6ecf8b23f08a05eb91bcf5f69d248d2c'
     * //                ]
     * //        ]);
     * //        try {
     * //            $response = $client->POST('https://ws.smartbill.ro:8183/SBORO/api/invoice', [
     * //                \GuzzleHttp\RequestOptions::JSON => $reqData
     * //            ]);
     * //        } catch (\Exception $ex) {
     * //            \Log::error($ex);
     * //        }
     * //        //Get Request Response Code -> 200 Succes
     * //        $statusCode = $response->getStatusCode();
     * //        if ($statusCode == 200) {
     * //            // Set in DB Col SmartBill_Invoice From Null to 1 - after it was created
     * //            $order->smart_bill_invoice = 1;
     * //            // Save in DB
     * //            $order->save();
     * //            return redirect()->route('order.view')->with('success', 'Comanda a fost creata cu succes la Same Day');
     * //        } else {
     * //            return redirect()->route('order.view')->with('error', 'A aparut o eroare!');
     * //        }
     * ////        $data = (string)$response->getBody();
     * ////        $data = json_decode($data);
     * //////        dd($data);
     * //
     * //    }
     *
     **/

    public
    function smdApiGetPickupPoint()
    {
        $getSmdOoption = Option::find(1);
        $smdApiToken = $getSmdOoption->shipping_api_token;
        $client = new \GuzzleHttp\Client([
            'timeout' => 2.0,
            'headers' =>
                [
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                    'X-AUTH-TOKEN' => $smdApiToken
                ]
        ]);
        try {
            $response = $client->GET('https://sameday-api.demo.zitec.com/api/client/pickup-points');
        } catch (\Exception $ex) {
            \Log::error($ex);
            dd($ex);
        }
        //Get Request Response Code -> 200 Succes
        $statusCode = $response->getStatusCode();
        $data = (string)$response->getBody();
        $data = json_decode($data);
        // $data = json_encode($data);
//        var_dump($data->token);
//        var_dump($data->expire_at);
        dd($data);
    }

    public
    function smdApiGetActiveServices()
    {
        $getSmdOoption = Option::find(1);
        $smdApiToken = $getSmdOoption->shipping_api_token;
        $client = new \GuzzleHttp\Client([
            'timeout' => 2.0,
            'headers' =>
                [
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                    'X-AUTH-TOKEN' => $smdApiToken
                ]
        ]);
        try {
            $response = $client->GET('https://sameday-api.demo.zitec.com/api/client/services');
        } catch (\Exception $ex) {
            \Log::error($ex);
        }
        //Get Request Response Code -> 200 Succes
        $statusCode = $response->getStatusCode();
        $data = (string)$response->getBody();
        $data = json_decode($data);
        // $data = json_encode($data);
//        var_dump($data->token);
//        var_dump($data->expire_at);
        dd($data);
    }

    public
    function smdApiGetCountyList()
    {
        $getSmdOoption = Option::find(1);
        $smdApiToken = $getSmdOoption->shipping_api_token;

        $client = new \GuzzleHttp\Client([
            'timeout' => 2.0,
            'headers' =>
                [
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                    'X-AUTH-TOKEN' => $smdApiToken
                ]
        ]);
        try {
            $response = $client->GET('https://sameday-api.demo.zitec.com/api/geolocation/county');
        } catch (\Exception $ex) {
            \Log::error($ex);
        }
        //Get Request Response Code -> 200 Succes
        $statusCode = $response->getStatusCode();
        $data = (string)$response->getBody();
        $data = json_decode($data);
        // $data = json_encode($data);
//        var_dump($data->token);
//        var_dump($data->expire_at);
        dd($data);
    }

    public
    function smdApiGetCityList($clientCounty, $clientCity)
    {

        $getSmdOoption = Option::find(1);
        $smdApiToken = $getSmdOoption->shipping_api_token;
        $client = new \GuzzleHttp\Client([
            'timeout' => 2.0,
            'headers' =>
                [
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                    'X-AUTH-TOKEN' => $smdApiToken
                ]
        ]);
        try {
            $response = $client->GET('https://sameday-api.demo.zitec.com/api/geolocation/city',
                ['query' =>
                    ['name' => $clientCity],
                    ['county' => $clientCounty]
                ]);
        } catch (\Exception $ex) {
            \Log::error($ex);
            dd($ex);
        }
        //Get Request Response Code -> 200 Succes
        $statusCode = $response->getStatusCode();
        $cityAndCountyDetails = (string)$response->getBody();

        return $cityAndCountyDetails;

    }

    public
    function smdApiCreatePickupPoint()
    {
        $getSmdOoption = Option::find(1);
        $smdApiToken = $getSmdOoption->shipping_api_token;
        $client = new \GuzzleHttp\Client([
            'timeout' => 2.0,
            'headers' =>
                [
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                    'X-AUTH-TOKEN' => $smdApiToken
                ]
        ]);

        // Pickup info
        $goodPickupPointPitesti = '3452';
        $ecuatorContactPersonId = '3709';
        $ecuatorCounty = '4'; // SameDay ID for Arges AG county;
        $ecuatorCity = '6912'; // SameDay ID for Pitesti city - postalCode = 110001;
        $ecuatorAddress = 'Strada George Cosbuc, nr. 70';
        $ecuatorContactPerson = 'Mitran Alexandru';
        $ecuatorPhoneNumber = '0766310778';
        $ecuatorEmailAddress = 'office@ecuatorcafe.ro';
        $ecuatorPickupPointAlias = 'Adresa de ridicare colete';
        // Create new PickupPoint Request Data
        $reqData = [
            'county' => $ecuatorCounty,
            'city' => $ecuatorCity,
            'address' => $ecuatorAddress,
            'alias' => $ecuatorPickupPointAlias,
            'defaultPickupPoint	' => 0,
            'pickupPointContactPerson' =>
                [
                    [
                        'name' => $ecuatorContactPerson,
                        'phoneNumber' => $ecuatorPhoneNumber,
                        'email' => $ecuatorEmailAddress,
                        'defaultContactPerson' => 1
                    ]
                ]
        ];
        try {
            $response = $client->POST('https://sameday-api.demo.zitec.com/api/client/pickup-points', [
                'form_params' => $reqData
            ]);
        } catch (\Exception $ex) {
            \Log::error($ex);
            dd($ex);
        }
        //Get Request Response Code -> 200 Succes
        $statusCode = $response->getStatusCode();
        var_dump($statusCode);
        $data = (string)$response->getBody();
        $data = json_decode($data);
        // $data = json_encode($data);
//        var_dump($data->token);
//        var_dump($data->expire_at);
        dd($data);
    }

    private function generate_headers_for_same_day_API()
    {
        $getSmdOoption = Option::find(1);
        $smdApiToken = $getSmdOoption->shipping_api_token;
        $client = new \GuzzleHttp\Client([
            'timeout' => 2.0,
            'headers' =>
                [
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                    'X-AUTH-TOKEN' => $smdApiToken
                ]
        ]);

        return $client;
    }

    public function downloadShippingAWBPdf($shippingAwb)
    {

        $data = [
            'format' => "A4",
            'awbNumber' => $shippingAwb
        ];

        $pdfToDownload = "";

        try {
            $response = $this->generate_headers_for_same_day_API()->GET('https://sameday-api.demo.zitec.com/api/awb/download/' . $shippingAwb . '/A4?_format=json/',
                ['form_params' => [$data]
                ],
                ['stream' => true]
            );
//            $response = $client->POST('https://sameday-api.demo.zitec.com/api/awb', [
//                'form_params' => [$reqData]
//            ]);

        } catch (\Exception $ex) {
            \Log::error($ex);
            dd($ex);
        }


        $data = (string)$response->getBody();
        $data = json_decode($data);
        $response->header('Content-Type', 'application/octet-stream'); // change this to the download content type.
        return $response;

    }


    public
    function smdApiCreateAwb($id)
    {
        $order = Order::find($id);
        $productInfosArray = json_decode($order['product'], true);
        $orderId = $order->id;
        // Get Order Number
        $orderNumber = $order->order_number;
        // Get Customer For Each Order by Order Number
        $orderCustomer = Order::with('customer')->where('order_number', '=', $orderNumber)->get();

        $clientCity = $orderCustomer[0]->customer->localitate;
        $clientCounty = $orderCustomer[0]->customer->judet;

        // Interrogate SMD API TO GET EXACT CITY NAME AND ID

        $cityAndCountyDetails = $this->smdApiGetCityList($clientCity, $clientCounty);


        $cityAndCountyDetails = json_decode($cityAndCountyDetails);


        $smdClientCity = $cityAndCountyDetails->data[0]->village;
        $smdClientCounty = $cityAndCountyDetails->data[0]->county->name;
        $smdClientCityId = $cityAndCountyDetails->data[0]->id;
        $smdClientCountyId = $cityAndCountyDetails->data[0]->county->id;

        // Pickup info
        $pickupPointPitestiID = 3452;
        $ecuatorContactPersonID = 3709;
        // Active service 1 - Name: 24H - Next day
        $ecuatorSmdActiveService1Id = 7;
        // Active service 2 - Name: Retur Standard - Next day
        $ecuatorSmdActiveService2Id = 10;
        $ecuatorCounty = 4; // SameDay ID for Arges AG county;
        $ecuatorCity = 6912; // SameDay ID for Pitesti city - postalCode = 110001;
        // Parcel Height
        $parcelHeight = 150.00;
        // Parcel Width
        $parcelWidth = 320.00;
        // Parcel length
        $parcelLength = 220.00;
        // Parcel Weight
        $parceWeight = 2.3;

        // Initial Order Product QTY
        $orderProductTotalQty = 0.00;
        foreach ($productInfosArray as $orderProduct) {

            // Increment $orderProductTotalQty Variable with every product QTY
            $orderProductTotalQty = (float)$orderProductTotalQty + $orderProduct['product_qty'];

        }

        // Sum of order Products QTY
        $finalOrdersQty = $orderProductTotalQty;
        // Package Total Weight
        $packageWeight = (float)($finalOrdersQty / 10) * 2.3; // One Box of 10 BUC  = 2,3 kg

        $boxNumber = floor($finalOrdersQty / 10); // One Box of 10 BUC

        // Build Object for create a new AWB
        $reqData = [
            "_format" => "json",
            'pickupPoint' => $pickupPointPitestiID, //PickupPoint for Dev - 3452
            'contactPerson' => $ecuatorContactPersonID, //ContactPerson ID - 3709
            'packageType' => 0, //Package Type: 0 - package, 1 - envelope and 2 - large package
            'packageWeight' => $packageWeight,
            'service' => $ecuatorSmdActiveService1Id, // 7
            'awbPayment' => 1, // AWB payment (Who pays) 1 - client, 2 - recipient, 3 - third Party
            'cashOnDelivery' => 0, // Cash on delivery (can be 0)
            'insuredValue' => 0.00, // Insured value for awb (all packages)
            'thirdPartyPickup' => 0, // Pickup from a third party, not one of the client's pickup points. 1 - third party pickup, 0 - otherwise
            'awbRecipient' =>
                [
                    'name' => $orderCustomer[0]->customer->pers_contact,
                    'phoneNumber' => $orderCustomer[0]->customer->telefon,
                    'email' => $orderCustomer[0]->customer->email,
                    'personType' => 1,
                    'companyName' => $orderCustomer[0]->customer->nume,
                    'county' => $smdClientCountyId,
                    'city' => $smdClientCityId,
                    'cityString' => $smdClientCity,
                    'countyString' => $smdClientCounty,
                    'address' => $orderCustomer[0]->customer->adresa,
                ],
            'clientObservation' => $orderCustomer[0]->customer->observatii,
            'parcels' => []
        ];

        $parcelObj = (object)[];

        if ($boxNumber == 1) {

            $parcelNumber = 1;
            $parcelWeight = 2.3;

            $reqData['parcels'][0] =
                [
                    'weight' => $parcelWeight,
                    'width' => $parcelWidth,
                    'length' => $parcelLength,
                    'height' => $parcelHeight
                ];

        } elseif ($boxNumber == 2) {

            $parcelNumber = 2;
            $parcelWeight = ($boxNumber * 2.3) / 2;

            $reqData['parcels'][0] =
                [
                    'weight' => $parcelWeight,
                    'width' => $parcelWidth,
                    'length' => $parcelLength,
                    'height' => $parcelHeight
                ];
            $reqData['parcels'][1] =
                [
                    'weight' => $parcelWeight,
                    'width' => $parcelWidth,
                    'length' => $parcelLength,
                    'height' => $parcelHeight
                ];

        } elseif ($boxNumber == 3) {

            $parcelNumber = 1;
            $parcelWeight = $boxNumber * 2.3;

            $reqData['parcels'][0] =
                [
                    'weight' => $parcelWeight,
                    'width' => $parcelWidth,
                    'length' => $parcelLength,
                    'height' => $parcelHeight
                ];

        } elseif ($boxNumber == 4) {

            $parcelNumber = 1;
            $parcelWeight = ($boxNumber * 2.3) / 2;
            $reqData['parcels'][0] =
                [
                    'weight' => $parcelWeight,
                    'width' => $parcelWidth,
                    'length' => $parcelLength,
                    'height' => $parcelHeight
                ];

        } elseif ($boxNumber == 5) {

            $parcelNumber = 1;
            $parcelWeight = $boxNumber * 2.3;

            $reqData['parcels'][0] =
                [
                    'weight' => $parcelWeight,
                    'width' => $parcelWidth,
                    'length' => $parcelLength,
                    'height' => $parcelHeight
                ];

        } elseif ($boxNumber == 6) {

            $parcelNumber = 2;
            $parcelWeight = ($boxNumber * 2.3) / 2;

            $reqData['parcels'][0] =
                [
                    'weight' => $parcelWeight,
                    'width' => $parcelWidth,
                    'length' => $parcelLength,
                    'height' => $parcelHeight
                ];
            $reqData['parcels'][1] =
                [
                    'weight' => $parcelWeight,
                    'width' => $parcelWidth,
                    'length' => $parcelLength,
                    'height' => $parcelHeight
                ];

        } elseif ($boxNumber == 7) {

            $parcelNumber = 2;
            $parcelWeight1 = 4 * 2.3;
            $parcelWeight2 = 3 * 2.3;

            $reqData['parcels'][0] =
                [
                    'weight' => $parcelWeight1,
                    'width' => $parcelWidth,
                    'length' => $parcelLength,
                    'height' => $parcelHeight
                ];
            $reqData['parcels'][1] =
                [
                    'weight' => $parcelWeight2,
                    'width' => $parcelWidth,
                    'length' => $parcelLength,
                    'height' => $parcelHeight
                ];

        } elseif ($boxNumber == 8) {

            $parcelNumber = 2;
            $parcelWeight = ($boxNumber * 2.3) / 2;

            $reqData['parcels'][0] =
                [
                    'weight' => $parcelWeight,
                    'width' => $parcelWidth,
                    'length' => $parcelLength,
                    'height' => $parcelHeight
                ];
            $reqData['parcels'][1] =
                [
                    'weight' => $parcelWeight,
                    'width' => $parcelWidth,
                    'length' => $parcelLength,
                    'height' => $parcelHeight
                ];

        } elseif ($boxNumber == 9) {

            $parcelNumber = 2;
            $parcelWeight1 = 5 * 2.3;
            $parcelWeight2 = 4 * 2.3;

            $reqData['parcels'][0] =
                [
                    'weight' => $parcelWeight1,
                    'width' => $parcelWidth,
                    'length' => $parcelLength,
                    'height' => $parcelHeight
                ];
            $reqData['parcels'][1] =
                [
                    'weight' => $parcelWeight2,
                    'width' => $parcelWidth,
                    'length' => $parcelLength,
                    'height' => $parcelHeight
                ];

        } elseif ($boxNumber == 10) {

            $parcelNumber = 2;
            $parcelWeight = ($boxNumber * 2.3) / 2;

            $reqData['parcels'][0] =
                [
                    'weight' => $parcelWeight,
                    'width' => $parcelWidth,
                    'length' => $parcelLength,
                    'height' => $parcelHeight
                ];
            $reqData['parcels'][1] =
                [
                    'weight' => $parcelWeight,
                    'width' => $parcelWidth,
                    'length' => $parcelLength,
                    'height' => $parcelHeight
                ];

        }


        try {
            $response = $this->generate_headers_for_same_day_API()->POST('https://sameday-api.demo.zitec.com/api/awb', [
                \GuzzleHttp\RequestOptions::JSON => $reqData
            ]);
//            $response = $client->POST('https://sameday-api.demo.zitec.com/api/awb', [
//                'form_params' => [$reqData]
//            ]);

        } catch (\Exception $ex) {
            \Log::error($ex);
            dd($ex);
        }
        //Get Request Response Code -> 200 Succes
        $statusCode = $response->getStatusCode();
        var_dump($statusCode);
        $data = (string)$response->getBody();
        $data = json_decode($data);
        $shippingAwb = $data->awbNumber;

        return $this->downloadShippingAWBPdf($shippingAwb);

    }
}