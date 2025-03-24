@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="my-4">Liste des Sauces</h1>
    <div class="row">
        @foreach($sauces as $sauce)
            <div class="col-md-4 mb-4">
                <a href="{{ route('sauces.show', $sauce->sauceId) }}" class="card-link">
                    <div class="card">
                        <img src="{{ asset($sauce->imageUrl) }}" class="card-img-top" alt="{{ $sauce->imageUrl }}" style="height: 250px; width: auto; object-fit: contain;">
                        <div class="card-body">
                            <h5 class="card-title" style="text-align: center;">{{ $sauce->name }}</h5>
                        </div>
                    </div>
                </a>
            </div>
        @endforeach
    </div>
</div>
@endsection
