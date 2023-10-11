<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;

use App\Models\Company;
use Illuminate\Http\Request;

class PackageController extends Controller
{
    // Crete index
    public function index() {
        $data = DB::connection('COUPON')->table("TB_COUPONLOG")->orderBy('coupon', 'customer_old')->paginate(5);
        return view('companies.index' ,$data);
    }
   
}
