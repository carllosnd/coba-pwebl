<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <h1>Tambah data buku</h1>
    <!--menggunakan route harus diikuti dengan nama
        apabila menggunakan urls harus mengguanakan urls -->
    <form method="POST" action="{{route('books.store')}}"> <!--untuk setiap method post harus menggunakan @csrf -->
        @csrf
        <p>
            Kode : <br>
            <input type="text" name=code required />
        </p>
        <p>
            Judul : <br>
            <input type="text" name="title" required />
        </p>
        <button type="submit">Simpan</button>
    </form>
</body>
</html>