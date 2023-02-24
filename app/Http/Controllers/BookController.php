<?php

namespace App\Http\Controllers;
use App\Models\Book;
use Illuminate\Http\Request;

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
}
