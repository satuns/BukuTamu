<?php

namespace App\Http\Controllers;

use App\Exports\GuestsExport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Guest;
use App\Models\CategoryDescription;
use Maatwebsite\Excel\Facades\Excel;

class GuestsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function index()
    {
        $guests = Guest::all();
        $guests = Guest::orderBy('id', 'DESC')->get();
        $categories = CategoryDescription::all();
        return view('index', [
            'guests' => $guests,
            'categories' => $categories
        ]);
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'unit' => 'required',
            'description_id' => 'required',
            'description' => 'required',
            'nip' => 'required',
            'phone' => 'required'
        ]);

        Guest::create($request->all());
        return redirect('/')->with('tambah', 'Data tamu berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Guest $guest)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Guest $guest)
    {
        // 
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Guest $guest)
    {
        $request->validate([
            'enama' => 'required',
            'eunit' => 'required',
            'edescription' => 'required',
            'edescription_id' => 'required',
            'enip' => 'required',
            'ephone' => 'required'
        ]);

        Guest::where('id', $guest->id)
            ->update([
                'nama' => $request->enama,
                'unit' => $request->eunit,
                'description' => $request->edescription,
                'description_id' => $request->edescription_id,
                'nip' => $request->enip,
                'phone' => $request->ephone
            ]);

        return redirect('/')->with('update', 'Data tamu berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Guest $guest)
    {
        Guest::destroy($guest->id);
        return redirect('/')->with('hapus', 'Data tamu berhasil dihapus');
    }

    public function exportData()
    {
        return Excel::download(new GuestsExport, 'data-tamu-' . date('d-m-Y') . '.xlsx');
    }

    public function exportRangeData(Request $request)
    {
        $start_date = date('Y-m-d 00:00:00', strtotime($request->start_date));
        $end_date = date('Y-m-d 23:59:59', strtotime($request->end_date));

        return Excel::download(new GuestsExport, "data-tamu-{$start_date}-{$end_date}");
    }
}
