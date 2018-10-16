<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CustomerFileUpload;
use App\Imports\CustomersImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Concerns\WithMappedCells;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\File;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\UploadedFile;
use Auth;
use Illuminate\Support\Facades\Storage;


class UploadCustomersFiles extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $files = CustomerFileUpload::orderBy('created_at', 'desc')->get();

        Return view('pages.customers.uploadedfiles', compact('files'));
    }

    public function viewFile($id)
    {
        //PDF file is stored under project/public/download/info.pdf
        $files = CustomerFileUpload::find($id);
        $filePath = $files->cale_fisier;
        return response()->download(storage_path('app/') . $filePath);
    }


    /**
     * Show the form for creating a new resource.
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
        $formatedTime = date('Y-m-d', $time);
        $fileHash = $file->getClientOriginalName() . "-" . $formatedTime;
        $fileName = $fileHash . '.' . $request->file('fisierclienti')->getClientOriginalExtension();
        $path = Storage::putFileAs('files', $file, $fileName);
        $data = [
            'cale_fisier' => $path,
            'id_utilizator' => Auth::user()->id
        ];
        $collection = (new CustomersImport)->toArray($file);
        CustomerFileUpload::create($data);

        return redirect()->route('customer.view')->with('success', 'Clientul a fost adaugat cu succes!');
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
        $file = CustomerFileUpload::find($id);
        if($file){
            $filePath = $file->cale_fisier;
            $file->delete();
            Storage::delete($filePath);
        }
        Return redirect()->route('upload.viewfiles')->with('success', 'Fisierul a fost sters!');
    }
}
