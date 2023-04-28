<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Models\Book;
use App\Models\Publisher;
use App\Models\BookAuthor;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Maatwebsite\Excel\Facades\Excel;
use App\Export\ExportBooks;

class BookController extends Controller
{
    #fungsi untuk menampilkan semua data buku
    public function index()
    {

        $books = Book::query()
            ->with('publisher', 'authors')
            ->when(request('search'), function ($query) {
                $searchTerm = '%' . request('search') . '%';
                $query->where('title', 'LIKE', $searchTerm)
                    ->orWhere('code', 'LIKE', $searchTerm)
                    ->orWhereHas('publisher', function ($query) use ($searchTerm) {
                        $query->where('name', 'LIKE', $searchTerm);
                    })
                    ->orWhereHas('authors', function ($query) use ($searchTerm) {
                        $query->where('name', 'LIKE', $searchTerm);
                    });
            })->paginate(10);
        session()->flashInput(request()->input());
        return view('books/index', [
            'books' => $books
        ]);
    }

    #fungsi untuk mengekspor data ke pdf
    public function print()
    {
        $books = Book::query()
            ->with('publisher', 'authors')
            ->when(request('search'), function ($query) {
                $searchTerm = '%' . request('search') . '%';
                $query->where('title', 'LIKE', $searchTerm)
                    ->orWhere('code', 'LIKE', $searchTerm)
                    ->orWhereHas('publisher', function ($query) use ($searchTerm) {
                        $query->where('name', 'LIKE', $searchTerm);
                    })
                    ->orWhereHas('authors', function ($query) use ($searchTerm) {
                        $query->where('name', 'LIKE', $searchTerm);
                    });
            })->get();
        $filename = "books_" . date('Y-m-d-H-i-s') . ".pdf";
        $pdf = Pdf::loadView('books/print', ['books' => $books]);
        $pdf->setPaper('A4', 'portrait');
        return $pdf->stream($filename);
    }

    public function printDetail($bookId)
    {
        $book = Book::findOrFail($bookId);
        $filename = "book_" . $book->code . "_" . date('Y-m-d H:i:s') . ".pdf";
        $pdf = Pdf::loadView('books/printDetail', ['book' => $book]);
        $pdf->setPaper('A4', 'potrait');
        return $pdf->stream($filename);
    }

    public function excel()
    {
        return Excel::download(new ExportBooks, 'books.xlsx');
    }

    #function untuk menampilkan form tambah baru
    public function create()
    {
        $publishers = Publisher::all();
        $authors = Author::all();
        return view('books/form', [
            'publishers' => $publishers,
            'authors' => $authors
        ]);
    }

    #fungsi untuk memproses buku kedalam database
    public function store(Request $request)
    {
        DB::BeginTransaction();
        try {

            $validate = $request->validate([
                'code' => 'required|max:4|unique:books,code',
                'title' => 'required|max:100',
                'id_publisher' => 'required'
            ]);
            $code = $request->code;
            $title = $request->title;
            $idPublisher = $request->id_publisher;
            $book = Book::create([
                'code' => $code,
                'title' => $title,
                'id_publisher' => $idPublisher
            ]);
            foreach ($request->author as $authorId) {
                BookAuthor::create([
                    'id_book' => $book->id,
                    'id_author' => $authorId
                ]);
            }
            DB::commit();
            #untuk mengembalikan ke halaman yang dituju
            return redirect(route('books.index'))->with('sukses', 'buku sukses di tambah');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect(route('books.index'))->with('error', 'Buku Gagal di tambah');
        }
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

    public function view()
    {

        $publishers = Publisher::query()->with('books')->when(request('search'), function ($query) {
            $searchTerm = '%' . request('search') . '%';
            $query->where('name', 'LIKE', $searchTerm);
        })->paginate(10);

        return view('publishers/indexPublisher', [
            'publishers' => $publishers
        ]);
    }

    public function addPublisher()
    {
        $publishers = Publisher::all();
        return view('publishers/form-tambahPublisher', [
            'publishers' => $publishers
        ]);
    }

    public function viewPublisher(Request $request)
    {
        $validate = $request->validate([
            'name' => 'required|max:100'
        ]);
        $name = $request->name;
        Publisher::create([
            'name' => $name,
        ]);
        #untuk mengembalikan ke halaman yang dituju
        return redirect(route('publishers.view'))->with('sukses', 'publisher sukses di tambah');
    }

    public function editPublisher($publisherId)
    {
        #ambil data publisher by Id
        $publisher = Publisher::findOrFail($publisherId);
        return view('publishers/form-updatePublisher', [
            'publisher' => $publisher
        ]);
    }

    public function updatePublisher(Request $request)
    {
        $validate = $request->validate([
            'name' => 'required|max:100',
        ]);
        $publisherId = $request->id;
        $publisher = Publisher::findOrFail($publisherId);
        $publisher->update([
            'name' => $request->name
        ]);
        return redirect(route('publishers.view'))->with('sukses', 'data publisher sukses di update');;
    }

    public function confirmDeletePublisher($publisherId)
    {
        #ambil data publisher by Id
        $publisher = Publisher::findOrFail($publisherId);
        return view('publishers/delete-confirmPublisher', [
            'publisher' => $publisher
        ]);
    }

    public function deletePublisher(Request $request)
    {
        $publisherId = $request->id;
        $publisher = Publisher::findOrFail($publisherId);
        $publisher->delete();
        return redirect(route('publishers.view'))->with('sukses', 'data publisher sukses di hapus');
    }

    public function viewAuthor()
    {

        $authors = Author::query()->when(request('search'), function ($query) {
            $searchTerm = '%' . request('search') . '%';
            $query->where('name', 'LIKE', $searchTerm);
        })->paginate(10);

        return view('authors/indexAuthors', [
            'authors' => $authors
        ]);
    }

    public function addAuthor()
    {
        $authors = Author::all();
        return view('authors/form-tambahAuthor', [
            'authors' => $authors
        ]);
    }

    public function viewAddingAuthor(Request $request)
    {
        $validate = $request->validate([
            'name' => 'required|max:100'
        ]);
        $name = $request->name;
        Author::create([
            'name' => $name,
        ]);
        #untuk mengembalikan ke halaman yang dituju
        return redirect(route('authors.viewAuthor'))->with('sukses', 'author sukses di tambah');
    }

    public function editAuthor($authorId)
    {
        #ambil data author by Id
        $author = Author::findOrFail($authorId);
        return view('authors/form-updateAuthor', [
            'author' => $author
        ]);
    }

    public function updateAuthor(Request $request)
    {
        $validate = $request->validate([
            'name' => 'required|max:100',
        ]);
        $authorId = $request->id;
        $author = Author::findOrFail($authorId);
        $author->update([
            'name' => $request->name
        ]);
        return redirect(route('authors.viewAuthor'))->with('sukses', 'data author sukses di update');
    }

    public function confirmDeleteAuthor($authorId)
    {
        #ambil data author by Id
        $author = Author::findOrFail($authorId);
        return view('authors/delete-confirmAuthor', [
            'author' => $author
        ]);
    }

    public function deleteAuthor(Request $request)
    {
        $authorId = $request->id;
        $author = Author::findOrFail($authorId);
        $author->delete();
        return redirect(route('authors.viewAuthor'))->with('sukses', 'data author berhasil di hapus');
    }
}
