<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class KxpoController extends Controller
{
    public function calcolaKxpo(Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            $request->validate([
                'lunghezza' => 'required|numeric|min:0|regex:/^\d+(\.\d{1,2})?$/',
                't_sc' => 'required|numeric|min:0|regex:/^\d+(\.\d{1,2})?$/',
                'vertical_shift' => 'required|numeric|regex:/^\d+(\.\d{1,4})?$/',
            ], [
                'required' => 'Il campo :attribute è obbligatorio.',
                'numeric' => 'Il campo :attribute deve essere un valore numerico.',
                'min' => 'Il valore di :attribute deve essere almeno :min.',
                'regex' => 'Il campo :attribute deve avere un formato valido.',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'errori' => $e->errors(),
            ], 422);
        }

        $g = 9.81;
        $pitchAngleGradi = 7.5;
        $pitchAngleRadianti = deg2rad($pitchAngleGradi);
        $angularAccelerationPitch = 0.105;

        $lunghezza = $request->input('lunghezza');
        $t_sc = $request->input('t_sc');
        $verticalShift = $request->input('vertical_shift');

        $cg_h = $lunghezza > 200 ? 15 : 10;

        $kxpo = sqrt(pow(0.5, 2) + $pitchAngleRadianti * $g + $angularAccelerationPitch * ($verticalShift + $cg_h - $t_sc)) / $g;

        return response()->json([
            'kxpo' => $kxpo,
            'cg_h' => $cg_h,
        ]);
    }
}
