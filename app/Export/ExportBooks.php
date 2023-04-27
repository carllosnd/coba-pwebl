<?php

namespace App\Export;

use App\Models\Book;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\withHeadings;

class ExportBooks implements FromCollection, WithHeadings
{
    public function collection()
    {
        $books = Book::with('publisher')->get()
            ->map(function ($item) {
                return [
                    'Kode' => $item->code,
                    'Judul' => $item->title,
                    'Penerbit' => $item->publisher->name
                ];
            });
        return $books;
    }

    public function headings(): array
    {
        return [
            'Kode',
            'Judul',
            'Penerbit'
        ];
    }
}
