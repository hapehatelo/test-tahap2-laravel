<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Transaction;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $transactions = Transaction::all();

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

        return view('home', compact('sisa_saldo', 'total_pemasukan', 'total_pengeluaran'));
    }
}
