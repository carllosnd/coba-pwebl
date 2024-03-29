<?php

use App\Http\Controllers\BookController;
use App\Http\Controllers\CobaController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ResetPasswordController;
use App\Mail\TestMail;
use App\Models\Book;
use App\Models\Publisher;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;

Route::get('/test', function () {
    echo "Hello world";
});

Route::get('/test/{nama}/{umur}', function ($nama, $umur) {
    echo "Hello World " . $nama . ' ' . $umur;
});

Route::get('produk/baru', function () {
    echo "Ini adalah halaman produk";
});

#Register Route
Route::get('register', function() {
    return view('login.register');
})->name('register');
Route::post('register',[LoginController::class, 'prosesRegister'])->name('register.proses');
Route::get('register/verify', [LoginController::class, 'registerVerify'])->name('register.verify');

#Login Route
Route::get('login', [LoginController::class, 'index'])->name('login');
Route::post('login/verify', [LoginController::class, 'verify'])->name('login.verify');

#Forget Password Route
Route::group(['prefix'=>'forgot-password'], function () {
    Route::get('/',[ResetPasswordController::class,'index'])->name('fp');
    Route::post('/reset',[ResetPasswordController::class,'reset'])->name('fp.reset');
    Route::get('/new-password',[ResetPasswordController::class,'newPasswordForm'])->name('fp.new.form');
    Route::post('/new-password',[ResetPasswordController::class,'newPasswordProses'])->name('fp.new.proses');
});

#Logout Route
Route::get('logout', [LoginController::class, 'logout'])->name('logout');

#Route yang harus login
Route::group(['middleware' => 'pwl.auth'], function () {
    Route::get('/', function () {
        return view('layout.main');
    });
    #crud books
    #method post digunakan apabila mengirmkan data ke databse
    #method get digunakan apabila hanya mencari atau menambahkan data
    Route::get('/books', [BookController::class, 'index'])->name('books.index');
    Route::get('/books/create', [BookController::class, 'create'])->name('books.create');
    Route::post('/books/store', [BookController::class, 'store'])->name('books.store');
    Route::get('books/{bookId}/delete-confirm', [BookController::class, 'confirmDelete'])->name('books.del.confirm');
    Route::post('books/delete', [BookController::class, 'delete'])->name('books.delete');
    Route::get('books/{bookId}/edit', [BookController::class, 'edit'])->name('books.edit');
    Route::post('books/update', [BookController::class, 'update'])->name('books.update');
    Route::get('/books/print', [BookController::class, 'print'])->name('books.print');
    Route::get('/books/print/{bookId}', [BookController::class, 'printDetail'])->name('books.print.detail');
    Route::get('/books/export/excel', [BookController::class, 'excel'])->name('books.export.excel');

    #crud publisher books
    Route::get('/publishers', [BookController::class, 'view'])->name('publishers.view');
    Route::get('/publishers/addPublisher', [BookController::class, 'addPublisher'])->name('publishers.addPublisher');
    Route::post('/publishers/viewPublisher', [BookController::class, 'viewPublisher'])->name('publishers.viewPublisher');
    Route::get('publishers/{publisherId}/editPublisher', [BookController::class, 'editPublisher'])->name('publishers.editPublisher');
    Route::post('publishers/updatePublisher', [BookController::class, 'updatePublisher'])->name('publishers.updatePublisher');
    Route::get('publishers/{publisherId}/confirm-deletePublisher', [BookController::class, 'confirmDeletePublisher'])->name('publishers.del.confirmPublisher');
    Route::post('publishers/deletePublisher', [BookController::class, 'deletePublisher'])->name('publishers.deletePublisher');

    #crud author books
    Route::get('/authors', [BookController::class, 'viewAuthor'])->name('authors.viewAuthor');
    Route::get('/authors/addAuthor', [BookController::class, 'addAuthor'])->name('authors.addAuthor');
    Route::post('/authors/viewAddingAuthor', [BookController::class, 'viewAddingAuthor'])->name('authors.viewAddingAuthor');
    Route::get('authors/{authorId}/editAuthor', [BookController::class, 'editAuthor'])->name('authors.editAuthor');
    Route::post('authors/updateAuthor', [BookController::class, 'updateAuthor'])->name('authors.updateAuthor');
    Route::get('authors/{authorId}/confirm-deleteAuthor', [BookController::class, 'confirmDeleteAuthor'])->name('authors.del.confirmAuthor');
    Route::post('authors/deleteAuthor', [BookController::class, 'deleteAuthor'])->name('authors.deleteAuthor');
});

Route::get('/coba', [CobaController::class, 'index']);
Route::get('/coba/lagi', [CobaController::class, 'testing']);
Route::get('/coba/view', [CobaController::class, 'cobaview']);
Route::get('/coba/model', [CobaController::class, 'cobaModel']);
Route::get('/coba/mvc', [CobaController::class, 'cobaMVC']);


#email
Route::get('/mail/test', function () {
    Mail::to('xodabi7530@in2reach.com')->send(new TestMail());
});

Route::get('/coba-model', function () {
    $books = Book::with('publisher')->get();
    foreach ($books as $book) {
        echo $book->code . ' - ' . $book->publisher->id . '<br>';
    }
    dd();
});

Route::get('/coba-pub', function () {
    $publishers = Publisher::with('books')->get();
    foreach ($publishers as $p) {
        echo $p->name . ' (';
        foreach ($p->books as $b) {
            echo $b->title . ', ';
        }
        echo ')<br>';
    }
});
