<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;

class CustomersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function  __construct()
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
            'adresa' => 'required',
            'iln' => 'required',
            'cui' => 'required'
        ]);

        //Create Customer
        $data = [
            'nume' => $request->nume,
            'adresa' => $request->adresa,
            'iln' => $request->iln,
            'cui' => $request->cui
        ];

        //dd($data);

        Customer::create($data);

        return redirect()->route('customer.create')->with('success', 'Clientul a fost adaugat cu succes!');
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
        $customer = Customer::find($id);
        return view('pages.customers.edit')->with('customer', $customer);
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
        $this->validate($request, [
            'nume' => 'required',
            'adresa' => 'required',
            'iln' => 'required',
            'cui' => 'required'
        ]);

        $customer = Customer::find($id);
        $customer->nume = $request->input('nume');
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
    public function destroy($id)
    {
        $customer =  Customer::find($id);
        $customer->delete();

        return redirect()->route('customer.view')->with('success', 'Clientul a fost sters!');
    }
}
