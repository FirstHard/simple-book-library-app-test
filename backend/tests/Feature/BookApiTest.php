<?php

namespace Tests\Feature;

use App\Models\Book;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_list_books(): void
    {
        Book::factory()->count(3)->create();

        $response = $this->getJson('/api/books');

        $response->assertOk()
            ->assertJsonStructure([
                'data' => [
                    '*' => ['id', 'title', 'publisher', 'author', 'genre', 'publication_date', 'words_count', 'price'],
                ],
                'links',
                'meta',
            ]);
    }

    public function test_can_create_book(): void
    {
        $payload = Book::factory()->make()->toArray();

        $response = $this->postJson('/api/books', $payload);

        $response->assertCreated()
            ->assertJsonPath('data.title', $payload['title']);

        $this->assertDatabaseHas('books', ['title' => $payload['title']]);
    }

    public function test_validation_fails_on_create(): void
    {
        $response = $this->postJson('/api/books', []);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['title', 'publisher', 'author']);
    }

    public function test_can_show_book(): void
    {
        $book = Book::factory()->create();

        $response = $this->getJson("/api/books/{$book->id}");

        $response->assertOk()
            ->assertJsonPath('data.id', $book->id);
    }

    public function test_can_update_book(): void
    {
        $book = Book::factory()->create();

        $response = $this->patchJson("/api/books/{$book->id}", [
            'title' => 'Updated Title',
        ]);

        $response->assertOk()
            ->assertJsonPath('data.title', 'Updated Title');

        $this->assertDatabaseHas('books', ['id' => $book->id, 'title' => 'Updated Title']);
    }

    public function test_can_delete_book(): void
    {
        $book = Book::factory()->create();

        $response = $this->deleteJson("/api/books/{$book->id}");

        $response->assertNoContent();

        $this->assertDatabaseMissing('books', ['id' => $book->id]);
    }
}
