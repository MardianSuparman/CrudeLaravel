<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use Illuminate\Http\Request;
use Storage;
use PDF;
use Validator;

class ProdukController extends Controller
{

    public function viewPDF(){
        $produk= Produk::latest()->get();

        $data= [
            'title'=>'Data Produk',
            'date'=>date('m/d/y'),
            'produk'=>$produk,
        ];

        $pdf = PDF::loadView('produk.export-pdf', $data)->setPaper('a4', 'portrait');
        return $pdf->stream();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $produk=Produk::latest()->paginate(5);
        return view('produk.index', compact('produk'));
    }

    // akhir controller

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('produk.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // vallidate form
        $this->validate($request, [
            'nama'=> 'required|string|max:255',
            'harga'=> 'required',
            'image'=> 'required|image|mimes:jpeg,png,jpg|max:2048',
            'deskripsi'=> 'required ',
        ]);

        $produk = new produk();
        $produk->nama = $request->nama;
        $produk->harga = $request->harga;
        $produk->deskripsi = $request->deskripsi;

        // upload img
        $image = $request->file('image');
        $image->storeAs('public/produks', $image->hashName());
        $produk->image=$image->hashName();
        $produk->save();
        return redirect()->route('produk.index');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $produk=Produk::findOrFail($id);
        return view('produk.show', compact('produk'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $produk=Produk::findOrFail($id);
        return view('produk.edit', compact('produk'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'nama'=> 'required|min:5',
            'harga'=> 'required|min:5',
            'deskripsi'=> 'required',
        ]);

        $produk=Produk::findOrFail($id);
        $produk->nama=$request->nama;
        $produk->harga=$request->harga;
        $produk->deskripsi=$request->deskripsi;

        // upload produk
            $image=$request->file('image');
            $image->storeAs('public/produks', $image->hashName());

        // delete produk
        Storage::delete('public/produks/'. $produk->image);

        $produk->image=$image->hashName();
        $produk->save();
        return redirect()->route('produk.index');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $produk=Produk::findOrFail($id);
        Storage::delete('public/produks'. $produk->image);
        $produk->delete();
        return redirect()->route('produk.index');
    }
}
