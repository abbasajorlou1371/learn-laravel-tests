<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Book;

class LibraryManagementTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_a_book_can_be_added_to_the_library()
    {
        $this->withoutExceptionHandling();
        $response = $this->post('/books', [
            'title' => 'test',
            'author' => 'test1'
        ]);

        $response->assertOk();
        $this->assertCount(1, Book::all());
    }

    public function test_a_title_required() {
        $response = $this->post('/books', [
            'title' => '',
            'author' => 'test1'
        ]);

        $response->assertSessionHasErrors('title');

    }
    public function test_a_author_required() {
        $response = $this->post('/books', [
            'title' => 'test',
            'author' => ''
        ]);

        $response->assertSessionHasErrors('author');

    }

    public function test_a_book_can_be_updated() {
        $this->withoutExceptionHandling();
        $this->post('/books', [
            'title' => 'test',
            'author' => 'test1'
        ]);

        $book = Book::first();

        $response = $this->patch('/books/' . $book->id, [
            'title' => 'New Title',
            'author' => 'New Author',
        ]);

        $this->assertEquals('New Title', Book::first()->title);
        $this->assertEquals('New Author', Book::first()->author);
    }

}
