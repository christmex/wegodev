<?php

namespace App\Http\Controllers;

use App\Models\SrtRent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
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
        // do validation here
        $validated = $request->validate([
            'user_id' => [
                'required',
                'integer',
                'exists:srt_users,id'
            ],
            'book_id' => [
                'required',
                'integer',
                'exists:srt_books,id'
            ],

        ]);
        
        DB::beginTransaction();
        try {
            $Rent = SrtRent::create($validated);
            if($Rent){
                DB::commit();
                return response()->json(SrtRent::find($Rent->id));
            }else {
                DB::rollback();
                return response()->json(['message' => 'Something is wrong please contact your administrator']);
            }

        } catch (\Throwable $th) {
            DB::rollback();
            return response()->json(['message' => $th->getMessage()]);
        }
    }

}
