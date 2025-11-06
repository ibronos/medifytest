<?php

namespace App\Http\Controllers;

use App\Models\Obat;
use Illuminate\Http\Request;

class ObatController extends Controller
{

    public function index()
    {
        return view('obat.index.index');
    }


    public function search(Request $request)
    {
        $nama = $request->nama;
        $jenis = $request->jenis;

        $data_search = Obat::query();

        if (!empty($nama)) $data_search = $data_search->where('nama', 'LIKE', '%' . $nama . '%');

        $data_search = $data_search->select('id', 'nama', 'jenis')->orderBy('id')->get();

        return json_encode([
            'status' => 200,
            'data' => $data_search
        ]);
    }



    public function formView($method, $id = 0)
    {
   
        if ($method == 'new') {
            $item = [];
        } else {
            $item = Obat::find($id);
        }
        $data['item'] = $item;
        $data['method'] = $method;
        return view('obat.form.index', $data);

    }


    public function formSubmit(Request $request, $method, $id = 0)
    {

        if ($method == 'new') {
            $data_item = new Obat;
        } else {
            $data_item = Obat::find($id);
            $id = $data_item->id;
        }

        $data_item->nama = $request->nama;
        $data_item->jenis = $request->jenis;

        $data_item->save();

        return redirect('obat');
    }

    public function singleView($kode)
    {
        $data['data'] = Obat::where('id', $kode)->first();
        return view('obat.single.index', $data);
    }

    public function delete($id)
    {
        Obat::find($id)->delete();
        return redirect('obat');
    }

}
