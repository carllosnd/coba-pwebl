<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Publisher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class BookController extends Controller
{
    #fungsi untuk menampilkan semua data buku
    public function index()
    {

        $books = Book::query()->with('publisher','authors')->when(request('search'), function ($query) {
            $searchTerm = '%' . request('search') . '%';
            $query->where('title', 'LIKE', $searchTerm)->orWhere('code', 'LIKE', $searchTerm);
        })->paginate(10);

        return view('books/index', [
            'books' => $books
        ]);
    }

    #function untuk menampilkan form tambah baru
    public function create()
    {
        $publishers = Publisher::all();
        return view('books/form', [
            'publishers' => $publishers
        ]);
    }

    #fungsi untuk memproses buku kedalam database
    public function store(Request $request)
    {
        $validate = $request->validate([
            'code' => 'required|max:4|unique:books,code',
            'title' => 'required|max:100',
            'id_publisher' => 'required'
        ]);
        $code = $request->code;
        $title = $request->title;
        $idPublisher = $request->id_publisher;
        Book::create([
            'code' => $code,
            'title' => $title,
            'id_publisher' => $idPublisher
        ]);
        #untuk mengembalikan ke halaman yang dituju
        return redirect(route('books.index'))->with('sukses', 'buku sukses di tambah');
    }

    public function confirmDelete($bookId)
    {
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

    public function edit($bookId)
    {
        #ambil data buku by Id
        $book = Book::findOrFail($bookId);
        $publishers = Publisher::all();
        return view('books/form-update', [
            'book' => $book,
            'publishers' => $publishers
        ]);
    }

    public function update(Request $request)
    {
        $validate = $request->validate([
            'code' => 'required|max:4',
            'title' => 'required|max:100'
        ]);
        $bookId = $request->id;
        $book = Book::findOrFail($bookId);
        $book->update([
            'title' => $request->title
        ]);
        return redirect(route('books.index'))->with('sukses', 'data buku sukses di update');;
    }
}
