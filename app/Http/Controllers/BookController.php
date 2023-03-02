<?php

namespace App\Http\Controllers;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class BookController extends Controller
{
    #fungsi untuk menampilkan semua data buku
    public function index(){
        return view('books/index', [
            'books' => Book::all(),
        ]);
    }

    #function untuk menampilkan form tambah baru
    public function create(){
        return view('books/form');
    }

    #fungsi untuk memproses buku kedalam database
    public function store(Request $request){
        $code = $request->code;
        $title = $request->title;
        Book::create([
            'code'=>$code,
            'title'=>$title
        ]);
        #untuk mengembalikan ke halaman yang dituju
        return redirect(route('books.index'))->with('sukses','buku sukses di tambah');
    }

    public function confirmDelete($bookId){
        #ambil data buku by Id
        $book = Book::findOrFail($bookId);
        return view('books/delete-confirm', [
            'book' => $book
        ]);

    }

    public function delete(Request $request)
    {
        $bookId = $request->id;
        $book = Book::findOrFail($bookId);
        $book->delete();
        return redirect(route('books.index'));
    }

    public function edit($bookId){
        #ambil data buku by Id
        $book = Book::findOrFail($bookId);
        return view('books/form-update', [
            'book' => $book
        ]);
    }

    public function update(Request $request)
    {
        $bookId = $request->id;
        $book = Book::findOrFail($bookId);
        $book->update([
            'title' => $request->title
        ]);
        return redirect(route('books.index'))->with('sukses','data buku sukses di update');;
    }

}
