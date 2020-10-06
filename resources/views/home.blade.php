@extends('adminlte::page')

@section('title', 'AdminLTE')

@section('content_header')
    <h1 class="m-0 text-dark">Home</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h1>Saldo saat ini: Rp {{ number_format(($sisa_saldo), 0, '', '.') }}</h1>
                    <h1>Total Pemasukan (all time): Rp {{ number_format(($total_pemasukan), 0, '', '.') }}</h1>
                    <h1>Total Pengeluaran (all time): Rp {{ number_format(($total_pengeluaran), 0, '', '.') }}</h1>
                </div>
            </div>
        </div>
    </div>
@stop
