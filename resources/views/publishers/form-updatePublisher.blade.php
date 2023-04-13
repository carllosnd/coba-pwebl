@extends('layout.main')

@section('title', 'Update Publisher')

@section('content')

    <!--menggunakan route harus diikuti dengan nama
                apabila menggunakan urls harus mengguanakan urls -->
    <!--@if ($errors->any())
            <div class="alert alert-danger">
                <h5>Terdapat Error pada aplikasi : </h5>
                <ul>
                    @foreach ($errors->all() as $error)
    <li>{{ $error }}</li>
    @endforeach
                </ul>
            </div>
        @endif--->
    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('publishers.updatePublisher') }}">
                <!--untuk setiap method post harus menggunakan @csrf -->
                <input type="hidden" name="id" value="{{ $publisher->id }}">
                @csrf
                <div class="form-group">
                    <label for="">Nama Publisher</label>
                    <input class="form-control @error('name') is-invalid @enderror" type="text"
                        value="{{ $publisher->name }}" name=name />
                    @error('name')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
                <button class="btn btn-secondary" type="button" onclick="location.href='{{ route('publishers.view') }}'">
                    <i class="fa fa-arrow-circle-left"></i> Kembali
                </button>
                <button class="btn btn-success" type="submit">
                    <i class="fa fa-floppy-o"></i> Ubah
                </button>
            </form>
        </div>
    </div>
@endsection
