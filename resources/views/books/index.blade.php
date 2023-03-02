<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Daftar Buku</title>
</head>

<body>
    <h1>Daftar Buku</h1>
    @if ($message = Session::get('sukses'))
    {{$message}}
    @endif
    <a href="{{route('books.create')}}">Tambah Buku</a>
    <table border="1" width=100%>
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
                        <a href="{{route('books.edit',[$book->id])}}">Edit</a>
                        <a href="{{route('books.del.confirm',[$book->id])}}">Hapus</a>
                    </th>
                </tr>
            @empty
                <tr>
                    <td style="text-align: center;" colspan="4"><b>Data masih kosong</td>
                </tr>
            @endforelse
        </tbody>
        </table>
</body>

</html>
