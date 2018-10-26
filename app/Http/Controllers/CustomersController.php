<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\CustomerFileUpload;
use App\Imports\CustomersImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Concerns\WithMappedCells;
use Illuminate\Http\File;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class CustomersController extends Controller
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
        //Get All Customers
        $customers = Customer::all();

        return view('pages.customers.index', compact('customers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.customers.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //Validate Inputs
        $this->validate($request, [
            'nume'              => 'required',
            'contractor_ean'    => 'required',
            'adresa'            => 'required',
            'iln'               => 'required',
            'cui'               => 'required'
        ]);

        //Create Customer
        $data = [
            'contractor_ean' => $request->contractor_ean,
            'nume' => $request->nume,
            'adresa' => $request->adresa,
            'iln' => $request->iln,
            'cui' => $request->cui
        ];

        Customer::create($data);

        return redirect()->route('customer.create')->with('success', 'Clientul a fost adaugat cu succes!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($contractor_ean)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($contractor_ean)
    {
        $customer = Customer::find($contractor_ean);
        return view('pages.customers.edit')->with('customer', $customer);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $contractor_ean)
    {
        $this->validate($request, [
            'nume'              => 'required',
            'contractor_ean'    => 'required',
            'adresa'            => 'required',
            'iln'               => 'required',
            'cui'               => 'required'
        ]);

        $customer = Customer::find($contractor_ean);
        $customer->nume = $request->input('nume');
        $customer->contractor_ean = $request->input('contractor_ean');
        $customer->adresa = $request->input('adresa');
        $customer->iln = $request->input('iln');
        $customer->cui = $request->input('cui');
        $customer->save();

        return redirect()->route('customer.view')->with('success', 'Clientul a fost actualizat!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($contractor_ean)
    {
        $customer = Customer::find($contractor_ean);
        $customer->delete();

        return redirect()->route('customer.view')->with('success', 'Clientul a fost sters!');
    }

}

