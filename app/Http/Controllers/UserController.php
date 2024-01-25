<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Observation;

class UserController extends Controller
{
    public function getProfile(){
        return response()->json(['profile' => Auth::user()], 200);
    }

    public function getUsers()
    {
        return response()->json(['users' => User::all()], 200);
    }

    public function getAllObservations()
    {
        return response()->json(['Observations' => Observation::all()], 200);
    }

    public function createObservation(Request $request)
    {
        $request->validate([
            'sala' => 'required|string',
            'descricao' => 'required|string',
            'dataHora' => 'required|string'
        ]);

        try {

            $observation = new Observation([
                'sala' => $request->sala,
                'descricao' => $request->descricao,
                'dataHora' => $request->dataHora
            ]);

            $user = Auth::user();

            if ($user->tipoConta == "Professor"){
                $observation->user_id = $user->id;
                $observation->save();
        
                return response()->json([
                    'observation' => $observation
                ], 201);
            }
            else{
                return response()->json(['message' => 'Não é professor'], 409);
            }
    
        } catch (\Exception $e) {
            //return error message
            return response()->json(['message' => 'Erro!' . $e], 409);
        }
    }

    public function getObservationBySala($sala)
    {
        try {

            $observations = Observation::where('sala', $sala)->get();

            return response()->json([
                'observations' => $observations
            ], 201);

            }

         catch (\Exception $e) {
            //return error message
            return response()->json(['message' => 'Erro!'], 409);
        }
    }


}
