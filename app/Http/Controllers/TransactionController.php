<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Transaction;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {


        if ($request->range_date) {
            $range_date = explode(' - ', $request->range_date);
            $transactions = Transaction::with('category')->whereBetween('date', [date('Y-m-d H:i:s', strtotime($range_date[0])), date('Y-m-d H:i:s', strtotime($range_date[1]))])->get();
        }else{
            $transactions = Transaction::with('category')->get();
        }


        $categories = Category::all();

        $total_pemasukan = 0;
        $total_pengeluaran = 0;
        foreach ($transactions as $transaction) {
            if ($transaction->category->type === 'Pemasukan') {
                $total_pemasukan += $transaction->nominal;
            } elseif ($transaction->category->type === 'Pengeluaran') {
                $total_pengeluaran += $transaction->nominal;
            }
        }

        $sisa_saldo = $total_pemasukan - $total_pengeluaran;

        return view('transaction.index', compact('transactions', 'categories', 'sisa_saldo'));
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


        $rules = [
            'category_id'   => 'required',
            'nominal'       => 'required|integer',
            'date'          => 'required',
            'description'   => 'max:255|regex:/[a-zA-Z0-9\s]+/',
        ];

        $customMessages = [
             'required' => 'Please fill attribute :attribute'
        ];
        $this->validate($request, $rules, $customMessages);

        // return date('Y-m-d H:i:s', strtotime($request->date));

        Transaction::create([
            'nominal'       => $request->nominal,
            'description'   => $request->description,
            'date'          => date('Y-m-d H:i:s', strtotime($request->date)),
            'category_id'   => $request->category_id
        ]);

        return redirect('transaction')->with('msg', 'Success');
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
        
        $rules = [
            'category_id'   => 'required',
            'nominal'       => 'required|integer',
            'date'          => 'required',
            'description'   => 'max:255|regex:/[a-zA-Z0-9\s]+/',
        ];

        $customMessages = [
             'required' => 'Please fill attribute :attribute'
        ];
        $this->validate($request, $rules, $customMessages);

        $transaction = Transaction::findOrFail($id);
        $transaction->update([
            'nominal'       => $request->nominal,
            'description'   => $request->description,
            'date'          => date('Y-m-d H:i:s', strtotime($request->date)),
            'category_id'   => $request->category_id
        ]);

        return redirect('transaction')->with('msg', 'Edit Success');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $transaction = Transaction::find($id);
        $transaction->delete();
        return redirect('transaction')->with('msg', 'Delete success');
    }
}
