<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\Category;
use Illuminate\Database\Seeder;

class BookSeeder extends Seeder
{
    public function run(): void
    {
        $books = [
            ['category' => 'Romans', 'title' => 'Le Petit Prince', 'author' => 'Antoine de Saint-Exupéry', 'isbn' => '978-2-07-040850-4', 'pages' => 96],
            ['category' => 'Romans', 'title' => 'Les Misérables', 'author' => 'Victor Hugo', 'isbn' => '978-2-07-040834-4', 'pages' => 1900],
            ['category' => 'Science-Fiction', 'title' => 'Dune', 'author' => 'Frank Herbert', 'isbn' => '978-2-07-036822-8', 'pages' => 896],
            ['category' => 'Science-Fiction', 'title' => '1984', 'author' => 'George Orwell', 'isbn' => '978-2-07-036822-9', 'pages' => 328],
            ['category' => 'Histoire', 'title' => 'Sapiens', 'author' => 'Yuval Noah Harari', 'isbn' => '978-2-226-25701-7', 'pages' => 512],
            ['category' => 'Cuisine', 'title' => 'La Cuisine de Référence', 'author' => 'Michel Maincent', 'isbn' => '978-2-84-147001-2', 'pages' => 1056],
            ['category' => 'Philosophie', 'title' => 'Le Monde de Sophie', 'author' => 'Jostein Gaarder', 'isbn' => '978-2-07-054172-0', 'pages' => 624],
        ];

        foreach ($books as $i => $data) {
            $category = Category::where('name', $data['category'])->first();

            $book = Book::create([
                'title'       => $data['title'],
                'author'      => $data['author'],
                'category_id' => $category->id,
                'isbn'        => $data['isbn'],
                'total_pages' => $data['pages'],
            ]);

            foreach (range(1, 3) as $j) {
                $book->copies()->create([
                    'copy_number'  => strtoupper('COPY-' . str_pad($i + 1, 3, '0', STR_PAD_LEFT) . '-' . $j),
                    'condition'    => ['excellent', 'good', 'fair'][array_rand(['excellent', 'good', 'fair'])],
                    'is_available' => true,
                ]);
            }
        }
    }
}
