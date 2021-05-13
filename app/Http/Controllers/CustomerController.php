<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Exports\CustomerExport;
use Maatwebsite\Excel\Facades\Excel;



class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $customers = Customer::all();
        $status = DB::table('status')->where('flag', 1)->get();
        $source = DB::table('source')->where('flag', 1)->get();

        return view('customers.home', [
            'customers' => $customers,
            'status' => $status,
            'source' => $source,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function addCustomer(Request $request) {

        $imageName = '';
        if(!empty($request->file('profile_pic'))) {
            $image = $request->file('profile_pic');
            $imageName = time().'.'.$image->extension();
            $image->move(public_path('images'), $imageName);
        }

        $customer = new Customer();
        $customer->first_name = $request->first_name;
        $customer->last_name = $request->last_name;
        $customer->mobile = $request->mobile;
        $customer->email_address = $request->email_address;
        $customer->profile_pic = $imageName;
        $customer->status = $request->status;
        $customer->source = $request->source;
        $customer->save();

        $customers = DB::table('customers')
            ->join('source', 'customers.source', '=', 'source.id')
            ->join('status', 'customers.status', '=', 'status.id')
            ->where('customers.id', '=', $customer->id)
            ->select('customers.*', 'source.name as srcname', 'status.name as stsname')->get();

        return response()->json($customers);
    }

    public function updateCustomer(Request $request) {
        $imageName = '';

        if(!empty($request->file('profile_pic'))) {
            $image = $request->file('profile_pic');
            $imageName = time().'.'.$image->extension();
            $image->move(public_path('images'), $imageName);
        }

        $customer = Customer::find($request->id);
        $customer->first_name = $request->first_name;
        $customer->last_name = $request->last_name;
        $customer->mobile = $request->mobile;
        $customer->email_address = $request->email_address;
        $customer->profile_pic = $imageName;
        $customer->status = $request->status;
        $customer->source = $request->source;
        $customer->save();

        $customers = DB::table('customers')
            ->join('source', 'customers.source', '=', 'source.id')
            ->join('status', 'customers.status', '=', 'status.id')
            ->where('customers.id', '=', $customer->id)
            ->select('customers.*', 'source.name as srcname', 'status.name as stsname')->get();

        return response()->json($customers);
    }

    public function deleteCustomer($id) {
        $customer = Customer::find($id);
        $customer->delete();

        $customers = DB::table('customers')
            ->join('source', 'customers.source', '=', 'source.id')
            ->join('status', 'customers.status', '=', 'status.id')
            ->where('customers.id', '=', $customer->id)
            ->select('customers.*', 'source.name as srcname', 'status.name as stsname')->get();
        return response()->json(['success'=>'Record has been removed successfully']);
    }


    public function getCustomerById($id) {
        $customer = Customer::find($id);
        return response()->json($customer);
    }

    public function exportToExcel() {
        return Excel::download(new CustomerExport, 'customerlist.xlsx');
    }

    public function exportToCSV() {
        return Excel::download(new CustomerExport, 'customerlist.csv');
    }
}
