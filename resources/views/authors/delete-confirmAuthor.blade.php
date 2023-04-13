@extends('layout.main')

@section('title', 'Hapus Data Author')

@section('content')
    <!--menggunakan route harus diikuti dengan nama
        apabila menggunakan urls harus mengguanakan urls -->

        <div class="card">
            <div class="card-body">
                <form method="POST" action="{{ route('authors.deleteAuthor') }}">
                    <!--untuk setiap method post harus menggunakan @csrf -->
                    @csrf
                    <input type="hidden" name="id" value="{{ $author->id }}" />
                    <div class="form-group">
                        <label for="">Nama Author</label>
                        <input class="form-control" type="text" value="{{ $author->name }}" name=name readonly disabled />
                    </div>
                    <button class="btn btn-secondary" type="button" onclick="location.href='{{ route('authors.viewAuthor') }}'">
                        <i class="fa fa-arrow-circle-left"></i> Kembali
                    </button>
                    <button class="btn btn-success" type="submit">
                        <i class="fa fa-trash"></i> Hapus
                    </button>
                </form>
            </div>
        </div>
@endsection
