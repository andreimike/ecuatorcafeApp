<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\CustomerUploadFile;
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
            'nume' => 'required',
            'contractor_ean' => 'required',
            'adresa' => 'required',
            'localitate' => 'required',
            'codPostal' => 'required',
            'judet' => 'required',
            'cui' => 'required'
        ]);

        //Create Customer
        $data = [
            'contractor_ean' => $request->contractor_ean,
            'nume' => $request->nume,
            'adresa' => $request->adresa,
            'localitate' => $request->localitate,
            'cod_postal' => $request->codPostal,
            'judet' => $request->judet,
            'tara' => $request->tara,
            'iln' => $request->iln,
            'cui' => $request->cui,
            'reg_com' => $request->reg_com,
            'banca' => $request->banca,
            'iban' => $request->iban,
            'pers_contact' => $request->pers_contact,
            'telefon' => $request->telefon,
            'email' => $request->email,
            'observatii' => $request->observatii,
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
            'nume' => 'required',
            'contractor_ean' => 'required',
            'adresa' => 'required',
            'localitate' => 'required',
            'judet' => 'required',
            'cui' => 'required'
        ]);

        $customer = Customer::find($contractor_ean);
        $customer->nume = $request->input('nume');
        $customer->contractor_ean = $request->input('contractor_ean');
        $customer->adresa = $request->input('adresa');
        $customer->localitate = $request->input('localitate');
        $customer->cod_postal = $request->input('codPostal');
        $customer->judet = $request->input('judet');
        $customer->tara = $request->input('tara');
        $customer->iln = $request->input('iln');
        $customer->cui = $request->input('cui');
        $customer->reg_com = $request->input('reg_com');
        $customer->banca = $request->input('banca');
        $customer->iban = $request->input('iban');
        $customer->email = $request->input('email');
        $customer->pers_contact = $request->input('pers_contact');
        $customer->telefon = $request->input('telefon');
        $customer->observatii = $request->input('observatii');
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

