@extends('layout.main')

@section('title', 'Tambah Buku')

@section('content')
    <!--menggunakan route harus diikuti dengan nama
    apabila menggunakan urls harus mengguanakan urls -->

    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('books.store') }}">
                <!--untuk setiap method post harus menggunakan @csrf -->
                @csrf
                <div class="form-group">
                    <label for="">Kode</label>
                    <input class="form-control" type="text" name=code required />
                </div>
                <div class="form-group">
                    <label for="">Judul</label>
                    <input class="form-control" type="text" name="title" required />
                </div>
                <button class="btn btn-success" type="submit">
                    <i class="fa fa-save"></i> Simpan
                </button>
            </form>
        </div>
    </div>
@endsection
