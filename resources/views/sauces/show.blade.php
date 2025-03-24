@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="my-4">{{ $sauce->name }}</h1>
    <div class="row">
        <div class="col-md-6">
            <img src="{{ asset($sauce->imageUrl) }}" class="img-fluid" alt="{{ $sauce->imageUrl }}">
        </div>
        <div class="col-md-6">
            <p><strong>Fabricant :</strong> {{ $sauce->manufacturer }}</p>
            <p><strong>Description :</strong> {{ $sauce->description }}</p>
            <p><strong>Note de chaleur :</strong> {{ $sauce->heat }}/10</p>
            <p><strong>Likes :</strong> {{ $sauce->likes }} | <strong>Dislikes :</strong> {{ $sauce->dislikes }}</p>
            <a href="{{ route('sauces.edit', $sauce->sauceId) }}" class="btn btn-warning">Modifier</a>

            <form action="{{ route('sauces.destroy', $sauce->sauceId) }}" method="POST" class="d-inline">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger" onclick="return confirm('Voulez-vous vraiment supprimer cette sauce ?')">Supprimer</button>
            </form>
            <a href="{{ route('sauces.index') }}" class="btn btn-secondary">Retour à la liste</a>
        </div>
    </div>
</div>
@endsection
