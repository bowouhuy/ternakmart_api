<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaksi;
use Illuminate\Support\Facades\DB;

class TransaksiController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
        // $this->middleware('cors');
    }

    public function index(){
        $data = DB::table('transaksi')
                ->leftJoin('ternak', 'ternak.id', '=', 'transaksi.id_ternak')
                ->leftJoin('users', 'users.id', '=', 'transaksi.id_user')
                ->select('transaksi.*','ternak.ternak_nama','users.name')
                ->get();

        return response()->json(['transaksi' =>  $data], 200);
    }
    public function pengiriman(){
        $data = DB::select("SELECT a.*, b.*, CONCAT(c.city_name,', ',c.province) AS lokasi_pengiriman, d.nama_lengkap AS nama_customer
                FROM transaksi a
                LEFT JOIN (
                SELECT a.*, CONCAT(b.city_name,', ', b.province) AS lokasi_ternak FROM ternak a
                LEFT JOIN lokasi b ON a.city_id = b.city_id
                )b ON a.id_ternak = b.id
                LEFT JOIN lokasi c ON a.city_id = c.city_id
                LEFT JOIN customer d ON a.id_user = d.id_user
                ")
                            ;

        return response()->json(['pengiriman' =>  $data], 200);
    }
    public function show($id){
        try {
            $query = DB::table('transaksi')
                    ->leftJoin('ternak', 'transaksi.id_ternak', '=', 'ternak.id')
                    ->select('transaksi.*','ternak.ternak_nama','ternak.ternak_deskripsi', 
                    'ternak.file_path')
                    ->where('transaksi.id_user','=',$id);
                    // ->where('transaksi.transaksi_st','=', "cart");
            $cart = $query->get();
            $count = $query->count();

            return response()->json(['cart' => $cart, 'counts' => $count], 200);

        } catch (\Exception $e) {

            return response()->json(['message' => $e], 404);
        }
    }

    public function cart($id){
        try {
            $query = DB::table('transaksi')
                    ->leftJoin('ternak', 'transaksi.id_ternak', '=', 'ternak.id')
                    ->leftJoin('lokasi', 'transaksi.city_id', '=', 'lokasi.city_id')
                    ->select('transaksi.*','ternak.ternak_nama','ternak.ternak_deskripsi', 
                    'ternak.file_path', 'lokasi.city_name', 'lokasi.province')
                    ->where('transaksi.id_user','=',$id)
                    ->where('transaksi.transaksi_st','=', "cart");
            $cart = $query->get();
            $count = $query->count();

            return response()->json(['cart' => $cart, 'counts' => $count], 200);

        } catch (\Exception $e) {

            return response()->json(['message' => $e], 404);
        }
    }

    public function detail($id){
        try {
            $transaksi = DB::table('transaksi')
                        ->leftJoin('ternak', 'transaksi.id_ternak', '=', 'ternak.id')
                        ->leftJoin('users', 'transaksi.id_user','=','users.id')
                        ->select('transaksi.*','ternak.ternak_nama','ternak.ternak_deskripsi', 
                        'ternak.file_path', 'users.name')
                        ->where('transaksi.id','=',$id)
                        ->first();

            return response()->json(['transaksi' => $transaksi], 200);

        } catch (\Exception $e) {

            return response()->json(['message' => $e], 404);
        }
    }
    public function store(Request $request){
        $data = new Transaksi;

        $data->id_ternak = $request->input('id_ternak');
        $data->id_user = $request->input('id_user');
        $data->ternak_harga = $request->input('ternak_harga');
        $data->masa_perawatan = $request->input('masa_perawatan');
        $data->total_harga = $request->input('total_harga');
        // $data->total_harga = $request->input('total_harga');
        $data->transaksi_st = $request->input('transaksi_st');
        $data->nama_penerima = $request->input('nama_penerima');
        $data->province_id = $request->input('province_id');
        $data->city_id = $request->input('city_id');
        $data->detail_alamat = $request->input('detail_alamat');
        $data->transaksi_note = $request->input('transaksi_note');
        $data->distance = $request->input('distance');
        $data->harga_ongkir = $request->input('harga_ongkir');
        $data->order_id = $request->input('order_id');
        $data->transaksi_token = $request->input('transaksi_token');

        $data->save();

        return response()->json(['message' => 'Berhasil Tambah Data'], 200);
    }
    public function update(Request $request, $id){
        $data = Transaksi::where('id', $id)->first();
        $data->id_ternak = $request->input('id_ternak');
        $data->id_user = $request->input('id_user');
        $data->ternak_harga = $request->input('ternak_harga');
        $data->masa_perawatan = $request->input('masa_perawatan');
        $data->total_harga = $request->input('total_harga');
        // $data->total_harga = $request->input('total_harga');
        $data->transaksi_st = $request->input('transaksi_st');
        $data->nama_penerima = $request->input('nama_penerima');
        $data->province_id = $request->input('province_id');
        $data->city_id = $request->input('city_id');
        $data->detail_alamat = $request->input('detail_alamat');
        $data->transaksi_note = $request->input('transaksi_note');
        $data->distance = $request->input('distance');
        $data->harga_ongkir = $request->input('harga_ongkir');

        $data->save();

        return response()->json(['message' => 'Berhasil Update Data'], 200);
    }

    public function destroy($id){
        //asd
    }

    public function detail_transaksi($id){
        try {
            $query = DB::table('transaksi')
                    ->leftJoin('ternak', 'transaksi.id_ternak', '=', 'ternak.id')
                    ->select('transaksi.*','ternak.ternak_nama','ternak.ternak_deskripsi', 
                    'ternak.file_path')
                    ->where('transaksi.id','=',$id);
                    // ->where('transaksi.transaksi_st','=', "cart");
            $cart = $query->first();

            return response()->json(['cart' => $cart], 200);

        } catch (\Exception $e) {

            return response()->json(['message' => $e], 404);
        }
    }

    public function addBilling($id){
        $affected = DB::table('transaksi')
                    ->where('id', $id)
                    ->update(['transaksi_st' => "waiting_payment",
                    'transaksi_tanggal' => date("Y-m-d")]);
        if($affected){
            return response()->json(['message' => "Success membuat billing"], 200);
        }
    }

    public function waiting($id){
        try {
            $query = DB::table('transaksi')
                    ->leftJoin('ternak', 'transaksi.id_ternak', '=', 'ternak.id')
                    ->select('transaksi.*','ternak.ternak_nama','ternak.ternak_deskripsi', 
                    'ternak.file_path')
                    ->where('transaksi.id_user','=',$id)
                    ->where('transaksi.transaksi_st','=', "waiting_payment");
            $cart = $query->get();
            $count = $query->count();

            return response()->json(['cart' => $cart, 'counts' => $count], 200);

        } catch (\Exception $e) {

            return response()->json(['message' => $e], 404);
        }
    }
    public function confirmation($id){
        try {
            $query = DB::table('transaksi')
                    ->leftJoin('ternak', 'transaksi.id_ternak', '=', 'ternak.id')
                    ->select('transaksi.*','ternak.ternak_nama','ternak.ternak_deskripsi', 
                    'ternak.file_path')
                    ->where('transaksi.id_user','=',$id)
                    ->where('transaksi.transaksi_st','=', "confirmation");
            $cart = $query->get();
            $count = $query->count();

            return response()->json(['cart' => $cart, 'counts' => $count], 200);

        } catch (\Exception $e) {

            return response()->json(['message' => $e], 404);
        }
    }

    public function getToken(Request $request){
        // Set your Merchant Server Key
        \Midtrans\Config::$serverKey = 'SB-Mid-server-EVovFI-eT7n5eLm6J_VaFKyw';
        // Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
        \Midtrans\Config::$isProduction = false;
        // Set sanitization on (default)
        \Midtrans\Config::$isSanitized = true;
        // Set 3DS transaction for credit card to true
        \Midtrans\Config::$is3ds = true;
        
        $params = array(
            'transaction_details' => array(
                'order_id' => $request->input('order_id'),
                'gross_amount' => $request->input('gross_amount'),
            ),
            'customer_details' => array(
                'first_name' => $request->input('name'),
                'last_name' => $request->input('last_name'),
                'email' => $request->input('email'),
                'phone' => $request->input('phone'),
            ),
        );

        $query = DB::table('transaksi')
                    ->select('transaksi_token')
                    ->where('order_id','=',$request->input('order_id'));
        $isTokenize = $query->first();

        if($isTokenize->transaksi_token == null){
            $snapToken = \Midtrans\Snap::getSnapToken($params);
            $affected = DB::table('transaksi')
              ->where('order_id', $request->input('order_id'))
              ->update(['transaksi_token' => $snapToken]);
            return response()->json(['token' => $snapToken], 200);
        }
        else{
            $query = DB::table('transaksi')
            ->select('transaksi_token')
            ->where('order_id','=',$request->input('order_id'));
            $token = $query->first();

            return response()->json(['token' => $token->transaksi_token ],  200);
        }
            
    }

    public function updateToken(Request $request){
        $affected = DB::table('transaksi')
              ->where('id', $request->input('id'))
              ->update(['transaksi_token' => $request->input('token')]);
        if($affected){
            return response()->json(['message' => 'Berhasil Update Data'], 200);
        }
        
    }

    //
}
