<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\HnpatName;
use App\Models\HnpatRef;
use App\Models\HnpatAddress;
use Dflydev\DotAccessData\Data;
use Illuminate\Console\View\Components\Alert;
use Illuminate\Support\Facades\Session;



class CoreController extends Controller
{
    public function index(){
       
       // DB::connection('COUPON')->table("TB_PackageDetail")->insert(['OrderNo'=>'test','PackageCode'=>'test','PackageExpired'=> date('Y-m-d'),'PackageExpiredTO'=> date('Y-m-d')]);
       $data = DB::connection('COUPON')->table("TB_PackagePoint")->orderBy('PackageExpired', 'asc')->get();
       return view('index')->with(compact('data'));

     
    }
    public function create(){
        return view('create');
    }

    public function loginPage()
    {
        return view('login');
    }
    public function login(Request $request)
    {
        $request->validate([
            'userid' => 'required',
            'password' =>'required',
        ]);

        $credentials = $request->only('userid', 'password');
        
        $connection = new \LdapRecord\Connection([
            'hosts' => ['172.20.0.10'],
        ]);

        if ($connection->auth()->attempt($request->userid . '@praram9hq.local', $request->password, $stayAuthenticated = true)) {

            return redirect('/');
        }
        else{
            return 'Error';
        }
    }

    public function couponlist(){
      $data = DB::connection('COUPON')->table('TB_PackageCustomer')
      ->join('TB_PackageOrder', 'TB_PackageCustomer.HN', '=', 'TB_PackageOrder.HN') 
      ->join('TB_PackageDetail', 'TB_PackageOrder.OrderNo', '=', 'TB_PackageDetail.OrderNo')    
      
      ->select('TB_PackageCustomer.HN', 
               'TB_PackageCustomer.CustomeName',
               'TB_PackageCustomer.CustomerMobile',
               'TB_PackageDetail.OrderNo', 
               'TB_PackageDetail.PackageCode',
               'TB_PackageDetail.PackageExpired',
               'TB_PackageDetail.PackageExpiredTo', 
               'TB_PackageOrder.Orderdate',
               'TB_PackageOrder.OrderTotalpoint')
               
       ->get();
        //dd($data);          
      return view('couponlist')->with(compact('data'));
    }
    

    public function coupon(Request $request){
    
        // Validate the incoming data
        $request->validate([
            'PackageCode' => 'required|unique:COUPON.TB_PackagePoint,PackageCode',
            'PackageDetail' => 'required|unique:COUPON.TB_PackagePoint,PackageDetail',
        ]);
      //dd($request);
        $prepareCoupon = [
            'PackageCode' => $request->PackageCode,
            'PackageDetail' => $request->PackageDetail,
            'PackageDiscount' => $request->PackageDiscount,
            'PackagePoint' => $request->PackagePoint,
            'PackageExpired' => $request->PackageExpired,
            'CrateDate' => date('Y-m-d'),
        ];
            
        try {
            DB::connection('COUPON')->table("TB_PackagePoint")->insert($prepareCoupon);
            
            // Set a success message in the session
            Session::flash('message', 'The post has been added successfully!');
            
            // Redirect back to the previous page
            return back();
        } catch (\Exception $e) {
            // An error occurred during database insert, set an error message in the session
            Session::flash('error', 'Failed to add the post: ' . $e->getMessage());
            
            // Redirect back to the previous page
            return back();
        }
         
        
    }
    

   public function search_HN(Request $request){
   
      $id_card = $request->hncard;

      $data = DB::connection('DB_HOSPITAL')
         ->table('hnpat_name')
         ->select([
               'hnpat_name.hn',
               DB::raw('SUBSTRING(hnpat_name.firstname, 2, LEN(hnpat_name.firstname)) as firstname'),
               DB::raw('SUBSTRING(hnpat_name.lastname, 2, LEN(hnpat_name.lastname)) as lastname'),
               'hnpat_address.mobilephone',
               'hnpat_ref.refno',
               'hnpat_ref.idcardtype',
               'hnpat_ref.refnotype',
         ])
         ->leftJoin('hnpat_ref', 'hnpat_name.hn', '=', 'hnpat_ref.hn')
         ->leftJoin('hnpat_address', 'hnpat_name.hn', '=', 'hnpat_address.hn')
         ->where('hnpat_name.suffixsmall', 0)
         ->where('hnpat_address.suffixtiny', 1)
         ->whereIn('hnpat_ref.idcardtype', ['1', '5'])
         ->where(function ($query) use ($id_card) {
               $query->where('hnpat_ref.refno', $id_card)
                     ->orWhere('hnpat_name.hn', $id_card);
         })
         ->orderBy('firstname', 'asc') // Replace 'column_to_order_by' with the actual column name
         ->first();
      
         if($data !== null){
            $data->fullname = $data->firstname." ".$data->lastname;
            
            return response()->json($data,200);
         }
         else{
            
            return response()->json('Error', 400);
         }

   }
   
  
   public function SaveData(Request $request){
       
        // Validate the incoming data
        $request->validate([
            'hncard' => 'required',
            'fullname' => 'required',
            'phone' => 'required',
            'package' => 'required|array',
            'orderno' => 'required',
            'totalPoint' => 'required',
        ]);

        // Check if the same information already exists in TB_PackageCustomer
        $existingCustomer = DB::connection('COUPON')
            ->table("TB_PackageCustomer")
            ->where('HN', $request->hncard)
            ->where('CustomeName', $request->fullname)
            ->where('CustomerMobile', $request->phone)
            ->first();

        if (!$existingCustomer) {
            // Customer doesn't exist, so insert the new customer data
            $TB_PackageCustomer = [
                'HN' => $request->hncard,
                'CustomeName' => $request->fullname,
                'CustomerMobile' => $request->phone,
            ];
            DB::connection('COUPON')->table("TB_PackageCustomer")->insert($TB_PackageCustomer);
        }       

        // Loop through the selected packages
        $isSuccessful = true; // Assume success

        if ($existingCustomer) {
            $isSuccessful = false;          
            Session::flash('error');
            return back();
        }

        // if (!$request->PackageCode->itisEmpty()) {
        //     Session::flash('error');
        //     return back();
        // } 

        foreach ($request->package as $item) {
            $findPackage = DB::connection('COUPON')->table("TB_PackagePoint")->where('PackageCode', $item)->first();
            $expriedDate = date("Y-m-d", strtotime("+" . $findPackage->PackageExpired . " month"));
            $TB_PackageDetail = [
                'OrderNo' => $request->orderno,
                'PackageCode' => $item,
                'PackageExpired' => date('Y-m-d'),
                'PackageExpiredTO' => $expriedDate,
            ];
            
            //Check if the insertion was successful, and set $isSuccessful to false if an error occurred
            $inserted = DB::connection('COUPON')->table("TB_PackageDetail")->insert($TB_PackageDetail);

            // Check if the insertion was successful, and set $isSuccessful to false if an error occurred
            if (!$inserted) {
                $isSuccessful = false;
                // You can set an error flash message here if you want
                // Session::flash('error');
                // Don't return here; continue processing the remaining packages
            }
        }
               
        if (empty($request->package)) {
            Session::flash('warning');
            return back(); // Flash warning if the package array is empty
        }
        
        // Redirect back after the loop has processed all packages
        

        if ($isSuccessful) {
            $TB_PackageOrder = [
                'OrderNO' => $request->orderno,
                'OrderDate' => date('Y-m-d'),
                'OrderTotalpoint' => $request->totalPoint,
                'HN' => $request->hncard,
            ];

            DB::connection('COUPON')->table("TB_PackageOrder")->insert($TB_PackageOrder);

            // Set a success message
            Session::flash('success');
        } else {
            // Set an error message
            Session::flash('error', 'บันทึกข้อมูลไม่สำเร็จ');
        }

        return back();

    }


}
   

 