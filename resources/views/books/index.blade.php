@extends('layout.main')

@section('title', 'Data Buku')

@section('content')
    @if ($message = Session::get('sukses'))
        <div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h5><i class="icon fas fa-check"></i> Sukses!</h5>
            {{ $message }}
        </div>
    @endif
    <a class="btn btn-primary mb-2" href="{{ route('books.create') }}">Tambah Buku</a>
    <table class="table" width=100%>
        <thead>
            <tr>
                <th>No</th>
                <th>Kode</th>
                <th>Judul</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @php
                $no = 1;
            @endphp
            @forelse ($books as $book)
                <tr>
                    <th>{{ $no++ }}</th>
                    <th>{{ $book->code }}</th>
                    <th>{{ $book->title }}</th>
                    <th>
                        <a class="btn btn-dark btn-sm" href="{{ route('books.edit', [$book->id]) }}">
                            <i class="fa fa-pencil-alt"></i>
                        </a>
                        <a class="btn btn-danger btn-sm" href="{{ route('books.del.confirm', [$book->id]) }}">
                            <i class="fa fa-trash"></i>
                        </a>
                    </th>
                </tr>
            @empty
                <tr>
                    <td style="text-align: center;" colspan="4"><b>Data masih kosong</td>
                </tr>
            @endforelse
        </tbody>
    </table>
@endsection
