<?php

namespace App\Http\Controllers;

use App\Models\SrtBook;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $Book = SrtBook::all();
        return response()->json($Book);
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
            'title' => ['required',Rule::unique('srt_books','title')],
        ]);
        
        DB::beginTransaction();
        try {
            $Book = SrtBook::create($validated);
            if($Book){
                DB::commit();
                return response()->json(SrtBook::find($Book->id));
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
