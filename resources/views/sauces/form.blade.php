@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="my-4">{{ isset($sauce) ? 'Modifier la Sauce' : 'Ajouter une Sauce' }}</h1>

    <form action="{{ isset($sauce) ? route('sauces.update', $sauce->sauceId) : route('sauces.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @if(isset($sauce))
            @method('PUT')
        @endif

        <div class="mb-3">
            <label for="name" class="form-label">Nom</label>
            <input type="text" name="name" class="form-control" value="{{ old('name', $sauce->name ?? '') }}" required>
        </div>

        <div class="mb-3">
            <label for="manufacturer" class="form-label">Fabricant</label>
            <input type="text" name="manufacturer" class="form-control" value="{{ old('manufacturer', $sauce->manufacturer ?? '') }}" required>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea name="description" class="form-control" rows="3" required>{{ old('description', $sauce->description ?? '') }}</textarea>
        </div>

        <div class="mb-3">
            <label for="image" class="form-label">Image</label>
            <input type="file" name="imageUrl" class="form-control">
            @if(isset($sauce) && $sauce->imageUrl)
                <div class="mt-2">
                    <img src="{{ asset($sauce->imageUrl) }}" alt="Sauce Image" style="height: 100px; width: auto; object-fit: contain;">
                </div>
            @endif
        </div>

        <div class="mb-3">
            <label for="mainPepper" class="form-label">Ingrédient principal</label>
            <input type="text" name="mainPepper" class="form-control" value="{{ old('mainPepper', $sauce->mainPepper ?? '') }}" required>
        </div>

        <div class="mb-3">
            <label for="heat" class="form-label">Chaleur</label>
            <input type="range" name="heat" class="form-range" min="1" max="10" value="{{ old('heat', $sauce->heat ?? 5) }}" oninput="this.nextElementSibling.value = this.value">
            <output>{{ old('heat', $sauce->heat ?? 5) }}</output>
        </div>

        <button type="submit" class="btn btn-success">{{ isset($sauce) ? 'Modifier' : 'Ajouter' }}</button>
    </form>
</div>
@if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

@endsection
