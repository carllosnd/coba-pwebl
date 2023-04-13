@extends('layout.main')

@section('title', 'Data Author')

@section('content')
    @if ($message = Session::get('sukses'))
        <div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h5><i class="icon fas fa-check"></i> Sukses!</h5>
            {{ $message }}
        </div>
    @endif
    <a class="btn btn-primary mb-2" href="{{ route('authors.addAuthor') }}">Tambah Author</a>

    <div class="card">
        <div class="card-header">
            <div class="card-tools">
                <form action="">
                    <input type="text" placeholder="Cari Author" name="search" class="form-control" id="" />
                </form>
            </div>
        </div>

        <div class="card-body">
            <table class="table" width=100%>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Author</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $no = 1;
                    @endphp
                    @forelse ($authors as $author)
                        <tr>
                            <th>{{ $no++ }}</th>
                            <th>{{ $author->name }}</th>
                            <th>
                                <a class="btn btn-dark btn-sm" href="{{ route('authors.editAuthor', [$author->id]) }}">
                                    <i class="fa fa-pencil-alt"></i>
                                </a>
                                <a class="btn btn-danger btn-sm" href="{{ route('authors.del.confirmAuthor', [$author->id]) }}">
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
        </div>
        <div class="card-footer">
            {{ $authors->withQueryString()->links('pagination::bootstrap-5') }}
        </div>
    </div>


@endsection
