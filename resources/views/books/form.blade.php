@extends('layout.main')

@section('title', 'Tambah Buku')

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
        @endif-->
    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('books.store') }}">
                <!--untuk setiap method POST harus menggunakan @csrf -->
                @csrf
                <div class="form-group">
                    <label for="">Kode</label>
                    <input class="form-control @error('code') is-invalid @enderror" value="{{ old('code') }}" type="text"
                        name=code />
                    @error('code')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="">Judul</label>
                    <input class="form-control @error('title') is-invalid @enderror" value="{{ old('title') }}"
                        type="text" name="title" />
                    @error('title')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="">Publisher</label>
                    <select class="form-control @error('id_publisher') is-invalid @enderror" name="id_publisher">
                        <option value="" disabled selected>Pilih Publisher</option>
                        @foreach ($publishers as $p)
                            <option value="{{ $p->id }}">{{ $p->name }}</option>
                        @endforeach
                    </select>
                    @error('id_publisher')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <button class="btn btn-success" type="submit">
                    <i class="fa fa-save"></i> Simpan
                </button>
            </form>
        </div>
    </div>
@endsection
