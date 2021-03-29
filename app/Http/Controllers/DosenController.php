<?php

namespace App\Http\Controllers;
use App\Models\Dosen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class DosenController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dosen=dosen::all();
        $title="Data Dosen";
        return view('admin.berandadosen',compact('title','dosen'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title="INPUT dosen";
        return view('admin.inputdosen',compact('title'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $message=[
            'required'=> 'Kolom :attribute Harus Lengkap',
            'date'=>'Kolom :attribute Harus Tanggal',
            'numeric'=>'Kolom :attribute Harus Angka'
            ];
                $validasi=$request->validate([
                    'nip'=>'required',
                    'nama'=>'required',
                    'jabatan'=>'required',
                'gambar'=>'required|mimes:jpg,bmp,png|max:512'
            ],$message);
            $path = $request->file('gambar')->store('gambars1');
            $validasi['user_id']=Auth::id();
            $validasi['gambar']=$path;
            Dosen::create($validasi);
            return redirect('dosen')->with('success','Data Berhasil Tersimpan');
        }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $dosen=Dosen::find($id);
        $title="Edit Dosen";
        return view('admin.inputdosen',compact('title','dosen'));
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
        $message=[
            'required'=> 'Kolom :attribute Harus Lengkap',
            'date'=>'Kolom :attribute Harus Tanggal',
            'numeric'=>'Kolom :attribute Harus Angka',
            ];
            $validasi=$request->validate([
                'nip'=>'required',
                'nama'=>'required',
                'jabatan'=>'required',
            'gambar'=>'required|mimes:jpg,bmp,png|max:512'
            ],$message);
            if($request->hasFile('gambar')){
            $fileName=time().$request->file('gambar')->getClientOriginalName();
            $path = $request->file('gambar')->storeAs('gambars1',$fileName);
                $validasi['gambar']=$path;
                $dosen=Dosen::find($id);
                Storage::delete($dosen->gambar);
            }
            $validasi['user_id']=Auth::id();
            Dosen::where('id',$id)->update($validasi);
            return redirect('dosen')->with('success','Data Berhasil Terupdate');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $dosen=Dosen::find($id);
        if($dosen != null){
            Storage::delete($dosen->gambar);
            $dosen=Dosen::find($dosen->id);
            Dosen::where('id',$id)->delete();
    }
    return redirect('dosen')->with('success','Data Berhasil Terupdate');
}
}