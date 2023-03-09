@extends('layout.main')

@section('title', 'Update Buku')

@section('content')

    <!--menggunakan route harus diikuti dengan nama
        apabila menggunakan urls harus mengguanakan urls -->
    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('books.update') }}">
                <!--untuk setiap method post harus menggunakan @csrf -->
                <input type="hidden" name="id" value="{{ $book->id }}">
                @csrf
                <div class="form-group">
                    <label for="">Kode</label>
                    <input class="form-control" type="text" value="{{ $book->code }}" name=code readonly disabled />
                </div>
                <div class="form-group">
                    <label for="">Judul</label>
                    <input class="form-control" type="text" value="{{ $book->title }}" name="title" required />
                </div>
                <button class="btn btn-secondary" type="button" onclick="location.href='{{ route('books.index') }}'">
                    <i class="fa fa-arrow-circle-left"></i> Kembali
                </button>
                <button class="btn btn-success" type="submit">
                    <i class="fa fa-refresh"></i> Ubah
                </button>
            </form>
        </div>
    </div>
@endsection
