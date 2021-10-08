<?php

namespace App\Http\Controllers;

use App\Models\SrtRent;
use App\Models\SrtUser;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    private static function formatDate($date){
        $explodedate = explode('-',$date);
        return $explodedate[2].'-'.self::getMonth($explodedate[1]).'-'.$explodedate[0];
    }

    private static function getMonth($month){
        switch ($month){
            case 1: return "Januari";break;
            case 2: return "Februari";break;
            case 3: return "Maret";break;
            case 4: return "April";break;
            case 5: return "Mei";break;
            case 6: return "Juni";break;
            case 7: return "Juli";break;
            case 8: return "Agustus";break;
            case 9: return "September";break;
            case 10: return "Oktober";break;
            case 11: return "November";break;
            case 12: return "Desember";break;
        }
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $User = SrtUser::all();
        return response()->json($User);
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
            // 'title' => 'required|unique:posts|max:255',
            // 'body' => 'required',
            'name' => ['required',Rule::unique('srt_users','name')],
            'dob' => 'required|date',
            'gender' => 'required|in:man,woman',
        ]);
        
        DB::beginTransaction();
        try {
            $User = SrtUser::create($validated);
            if($User){
                DB::commit();
                return response()->json(SrtUser::find($User->id));
            }else {
                DB::rollback();
                return response()->json(['message' => 'Something is wrong please contact your administrator']);
            }

        } catch (\Throwable $th) {
            DB::rollback();
            return response()->json(['message' => $th->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SrtUser  $srtUser
     * @return \Illuminate\Http\Response
     */
    public function show(SrtUser $srtUser)
    {
        return response()->json([
            "id" => $srtUser->id,
            "name" => $srtUser->name,
            "dob" => self::formatDate($srtUser->dob),
            "gender" => $srtUser->gender,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SrtUser  $srtUser
     * @return \Illuminate\Http\Response
     */
    public function show_rents(SrtUser $srtUser)
    {
        // $rents = SrtRent::find($srtUser->id);
        // dd($rents);
        return response()->json([
            "id" => $srtUser->id,
            "name" => $srtUser->name,
            "books" => $srtUser->books,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SrtUser  $srtUser
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SrtUser $srtUser)
    {
        //do validation here
        $validated = $request->validate([
            'name' => ['required',Rule::unique('srt_users','name')->ignore($srtUser->id)],
            'dob' => 'required|date',
            'gender' => 'required|in:man,woman',
        ]);
        DB::beginTransaction();
        try {
            $User = SrtUser::where('id', $srtUser->id)->update($validated);
            if($User){
                DB::commit();
                return response()->json(SrtUser::find($srtUser->id));
            }else {
                DB::rollback();
                return response()->json(['message' => 'Something is wrong please contact your administrator']);
            }

        } catch (\Throwable $th) {
            DB::rollback();
            return response()->json(['message' => $th->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SrtUser  $srtUser
     * @return \Illuminate\Http\Response
     */
    public function destroy(SrtUser $srtUser)
    {
        //
        DB::beginTransaction();
        try {
            $User = $srtUser->delete();
            if($User){
                DB::commit();
                return response()->json([
                    'message' => 'data '.$srtUser->name.' berhasil di delete'
                ]);
                
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
