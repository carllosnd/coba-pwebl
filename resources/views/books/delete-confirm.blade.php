<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <h1>Anda Yakin Hapus Data Ini?</h1>
    <!--menggunakan route harus diikuti dengan nama
        apabila menggunakan urls harus mengguanakan urls -->
    <form method="POST" action="{{route('books.delete')}}"> <!--untuk setiap method post harus menggunakan @csrf -->
        @csrf
        <input type="hidden" name="id" value="{{ $book->id }}" />
        <p>
            Kode : <br>
            <input type="text" value="{{$book->code}}" name=code readonly disabled />
        </p>
        <p>
            Judul : <br>
            <input type="text" value="{{$book->title}}" name="title" readonly disabled />
        </p>
        <button type="button" onclick="location.href='{{route('books.index')}}'">
            Kembali
        </button>
        <button type="submit">Ya Hapus</button>
    </form>
</body>
</html>