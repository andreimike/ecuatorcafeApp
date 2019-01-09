<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\CustomerUploadFile;
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


class CustomersUploadsFiles extends Controller
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
        $files = CustomerUploadFile::orderBy('created_at', 'desc')->get();

        Return view('pages.customers.uploadedfiles', compact('files'));
    }

    public function viewFile($id)
    {
        //PDF file is stored under project/public/download/info.pdf
        $files = CustomerUploadFile::find($id);
        $filePath = $files->customers_uploads_path;
        return response()->download(storage_path('app/') . $filePath);
    }


    /**
     * Show the form for creating a new resource.s
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.customers.import');
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
            'fisierclienti' => 'required|max:100000'
        ]);
        $file = $request->file('fisierclienti');
        $time = time();
        $formattedTime = date('Y-m-d', $time);
        $fileName = $formattedTime . "-" . str_random(8) . "-" . $file->getClientOriginalName();
        //        $fileName = $fileHash . '.' . $request->file('fisierclienti')->getClientOriginalExtension();
        $path = Storage::putFileAs('files', $file, $fileName);
        $data = [
            'customers_uploads_path' => $path,
            'id_utilizator' => Auth::user()->id
        ];

        CustomerUploadFile::create($data);
        $customersArray = Excel::toArray(new CustomersImport, $file);
        foreach ($customersArray as $stageOneKey => $stageOneVal) {
            foreach ($stageOneVal as $k => $v) {
                if ($v[0] != null) {
                    $data1 = [
                        'nume' => $v[0],
                        'contractor_ean' => $v[1],
                        'adresa' => $v[2],
                        'localitate' => $v[3],
                        'judet' => $v[4],
                        'tara' => $v[5],
                        'iln' => $v[6],
                        'cui' => $v[7],
                        'reg_com' => $v[8]
                    ];
                    Customer::create($data1);
                } else {
                    echo "Succes! Clientii au fost importati, dar exista campuri necompletate care se pot actualiza ulterior.";
                }
            }
        }
        return redirect()->route('customer.view')->with('success', 'Clientii au fost importati, dar exista campuri necompletate care se pot actualiza ulterior.');
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
        $file = CustomerUploadFile::find($id);
        if ($file) {
            $filePath = $file->customers_uploads_path;
            $file->delete();
            Storage::delete($filePath);
        }
        Return redirect()->route('view.stored.files')->with('success', 'Fisierul a fost sters!');
    }
}
