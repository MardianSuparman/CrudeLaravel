<?php

namespace App\Http\Controllers;

use App\Models\Merek;
use Illuminate\Http\Request;
use Storage;
use Validator;

class MerekController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $merek=Merek::latest()->paginate(5);
        return view('merek.index', compact('merek'));
    }

    // akhir controller

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('merek.create');
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
            'nama_merek'=> 'required',
        ]);

        $merek = new merek();
        $merek->nama_merek = $request->nama_merek;

        // upload img
        // $image = $request->file('image');
        // $image->storeAs('public/mereks', $image->hashName());
        // $merek->image=$image->hashName();
        $merek->save();
        return redirect()->route('merek.index');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $merek=merek::findOrFail($id);
        return view('merek.show', compact('merek'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $merek=merek::findOrFail($id);
        return view('merek.edit', compact('merek'));
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
            'nama'=> 'required',
        ]);

        $merek=merek::findOrFail($id);
        $merek->nama_merek=$request->nama_merek;
        // upload merek
        //     $image=$request->file('image');
        //     $image->storeAs('public/mereks', $image->hashName());

        // // delete merek
        // Storage::delete('public/mereks/'. $merek->image);

        // $merek->image=$image->hashName();
        $merek->save();
        return redirect()->route('merek.index');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $merek=merek::findOrFail($id);
        // Storage::delete('public/mereks'. $merek->image);
        $merek->delete();
        return redirect()->route('merek.index');
    }
}
