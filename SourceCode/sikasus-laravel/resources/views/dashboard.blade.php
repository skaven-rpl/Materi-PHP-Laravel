@extends('layouts.app')

@section('content')
    <h1 class="mt-4">Dashboard</h1>
    <div class="row">
        <h1>Selamat Datang, {{ ucfirst(session('role')) }}!</h1>
        <br>
        <div>Di dashboard ini, Anda dapat mengelola data kasus yang terkait melalui menu
            yang tersedia di sidebar.</div>
        <p>Pastikan Anda menggunakan fitur-fitur dengan bijak. Jika membutuhkan bantuan, silakan hubungi
            administrator melalui menu <em>Bantuan</em>.</p>
    </div>
@endsection
