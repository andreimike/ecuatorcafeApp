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
}
