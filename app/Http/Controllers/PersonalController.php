<?php

namespace App\Http\Controllers;

use App\Models\Personal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PersonalController extends Controller
{
    public function index()
    {
        $data = Personal::get();

        return view('welcome', compact('data'));
    }

    public function store(Request $request)
    {
        $data = explode(" ", $request->personal_data);

        $name = '';
        $age = null;
        $city = '';

        foreach ($data as $key => $value) {

            if ((int)$data[0] != 0) {
                return response()->json([
                    'status' => false,
                    'message'     => "You must input your name first"
                ], 400);
            }

            switch ($value) {
                case (int)$value == 0 && $age == null:
                    if ($name) {
                        $name .= ' '.$value;
                    }else{
                        $name .= $value;
                    }
                    break;

                case (int)$value == 0 && $age != null:
                    if(strtoupper($value) != 'TH' && strtoupper($value) != 'THN' && strtoupper($value) != 'TAHUN'){
                        if ($city) {
                            $city .= ' '.$value;
                        }else{
                            $city .= $value;
                        }
                    }
                    break;

                case (int)$value != 0:
                    $age = (int)$value;
                    break;

                default:
                    # code...
                    break;
            }

        }

        if (!$age) {
            return response()->json([
                'status' => false,
                'message'     => "Please insert your age"
            ], 400);
        }

        if (!$city) {
            return response()->json([
                'status' => false,
                'message'     => "Please insert your city"
            ], 400);
        }

        $personals = [
            'name' => strtoupper($name),
            'age' => $age,
            'city' => strtoupper($city)
        ];

        DB::beginTransaction();
        $insert = Personal::create($personals);

        if (!$insert) {
            DB::rollback();
            return response()->json([
                'status' => false,
                'message'     => $insert
            ], 400);
        }

        DB::commit();
        return response()->json([
            'status' => true,
            'message'     => "Personal insert success",
            'data'  => $personals
        ], 200);
    }
}
