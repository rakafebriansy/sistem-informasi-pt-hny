@extends('layouts.authorized')

@section('title')
PT HNY - Dashboard
@endsection

@section('content')
    <h1 class="text-2xl font-semibold mb-4">Dasbor Visualisasi</h1>
    <div class="rounded overflow-hidden shadow bg-white p-4">
        <iframe width="100%" height="600" src="https://app.powerbi.com/view?r=YOUR_EMBED_LINK" frameborder="0" allowfullscreen></iframe>
    </div>
@endsection
