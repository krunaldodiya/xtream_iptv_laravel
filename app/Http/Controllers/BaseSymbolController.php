<?php

namespace App\Http\Controllers;

use App\Models\BaseSymbol;
use Illuminate\Http\Request;

class BaseSymbolController extends Controller
{
    public function get_base_symbols(Request $request)
    {
        $base_symbols = BaseSymbol::all();

        return response()->json(['base_symbols' => $base_symbols]);
    }
}
