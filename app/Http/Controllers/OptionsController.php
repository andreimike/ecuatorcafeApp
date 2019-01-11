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
use PhpParser\Node\Stmt\Foreach_;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use GuzzleHttp\Middleware;

class OptionsController extends Controller
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
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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

    public function editSerialNumber()
    {
        $serialNumber = Option::find(1);
        return view('pages.options.serial-number-edit')->with('serialNumber', $serialNumber);
    }

    public function editApiToken()
    {
        $smdDayApiTokenOption = Option::find(1);
        $time = time();
        $detailedFormattedTime = date('Y-m-d H:i:s', $time);
        $smdApiTokenExDate = $smdDayApiTokenOption->validity_shipping_api_token;
        return view('pages.options.shipping-api-token', compact('detailedFormattedTime', 'smdApiTokenExDate', 'smdDayApiTokenOption'));
    }

    public function updateSerialNumber(Request $request, $id)
    {
        $this->validate($request, [
            'serialNumber' => 'required'
        ]);

        $customer = Option::find(1);
        $editedSerialNumber = $request->input('serialNumber');
        $serialNumberDecremented = $editedSerialNumber - 1;
        $customer->serial_number = $serialNumberDecremented;
        $customer->save();

        return redirect()->route('serial.number.edit')->with('success', 'Numarul de Serie a fost salvat cu succes!');
    }

    public function updateApiToken()
    {
        $time = time();
        $detailedFormattedTime = date('Y-m-d H:i:s', $time);
        $smdDayApiTokenOption = Option::find(1);
        $smdApiTokenExDate = $smdDayApiTokenOption->validity_shipping_api_token;
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

        return redirect()->route('api.token.edit')->with('success', 'Tokenul a fost regenerat cu succes!');
    }

    public function getStoredFiles()
    {
        $customersFiles = CustomerUploadFile::orderBy('created_at', 'desc')->get();
        $ordersFiles = OrderUploadFile::orderBy('created_at', 'desc')->get();
        Return view('pages.options.uploads', compact('customersFiles', 'ordersFiles'));

    }

    public function downloadOrderFile($id)
    {
        //PDF file is stored under project/public/download/info.pdf
        $files = OrderUploadFile::find($id);
        $filePath = $files->orders_uploads_path;
        return response()->download(storage_path('app/') . $filePath);
    }

    public function destroyOrderFile($id)
    {
        $file = OrderUploadFile::find($id);
        if ($file) {
            $filePath = $file->orders_uploads_path;
            $file->delete();
            Storage::delete($filePath);
        }
        Return redirect()->route('view.stored.files')->with('success', 'Fisierul a fost sters!');
    }

    public function destroyAllOrdersFiles()
    {
        $ordersFiles = OrderUploadFile::all();
        $i = 0;
        $orderFilePath[$i] = [];
        foreach ($ordersFiles as $file) {
            $orderFilePath[$i] = $file->orders_uploads_path;
            $i++;
        }
        Storage::delete($orderFilePath);
        foreach ($ordersFiles as $orderFile) {
            $orderFile->delete();
        }
        Return redirect()->route('view.stored.files')->with('success', 'Toate fisierele pentru Comenzi au fost sterse!');

    }

    public function destroyAllCustomersFiles()
    {
        $customersFiles = CustomerUploadFile::all();
        $i = 0;
        $orderFilePath[$i] = [];
        foreach ($customersFiles as $file) {
            $orderFilePath[$i] = $file->orders_uploads_path;
            $i++;
        }
        Storage::delete($orderFilePath);
        foreach ($customersFiles as $orderFile) {
            $orderFile->delete();
        }
        Return redirect()->route('view.stored.files')->with('success', 'Toate fisierele pentru Clienti au fost sterse!');

    }

    public function searchCustomerLocation(Request $request)
    {

        $input = $request->all();
        $jsonEncode = json_encode($input);
        $jsonDecoded = json_decode($jsonEncode, true);
        $customerCity = $jsonDecoded['city'];
        $customerCounty = $jsonDecoded['county'];

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

        if ($customerCity == "Bucuresti") {

            // Switch to County For Search In Same Day DataBase
            $customerCity = $customerCounty;

        }


        try {
            $response = $client->GET('https://sameday-api.demo.zitec.com/api/geolocation/city',
                ['query' =>
                    ['name' => $customerCity]
                ]);
        } catch (\Exception $ex) {
            \Log::error($ex);
            dd($ex);
        }
        //Get Request Response Code -> 200 Succes
        $statusCode = $response->getStatusCode();
        $cityAndCountyDetails = (string)$response->getBody();
        $locationData = json_decode($cityAndCountyDetails);
        $successMessage = 'Am cautat boss';


        return response()->json(
            [
                'success' => $successMessage,
                'locationData' => $locationData
            ]);


    }
}
