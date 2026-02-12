<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBookRequest;
use App\Http\Requests\UpdateBookRequest;
use App\Http\Resources\BookResource;
use App\Models\Book;
use Illuminate\Http\Request;

use OpenApi\Attributes as OA;

#[OA\Info(
    title: "Book Library API",
    version: "1.0.0",
    description: "REST API for managing books library"
)]
#[OA\Schema(
    schema: "Book",
    type: "object",
    required: ["title", "author"],
    properties: [
        new OA\Property(property: "id", type: "integer", example: 1),
        new OA\Property(property: "title", type: "string", example: "War and Peace"),
        new OA\Property(property: "author", type: "string", example: "Leo Tolstoy"),
        new OA\Property(property: "genre", type: "string", example: "Novel")
    ]
)]
class BookController extends Controller
{
    #[OA\Get(
        path: "/api/books",
        tags: ["Books"],
        summary: "List books",
        parameters: [
            new OA\Parameter(
                name: "author",
                in: "query",
                description: "Filter by author",
                required: false,
                schema: new OA\Schema(type: "string")
            ),
            new OA\Parameter(
                name: "genre",
                in: "query",
                description: "Filter by genre",
                required: false,
                schema: new OA\Schema(type: "string")
            ),
            new OA\Parameter(
                name: "page",
                in: "query",
                description: "Page number",
                required: false,
                schema: new OA\Schema(type: "integer", default: 1)
            )
        ],
        responses: [
            new OA\Response(response: 200, description: "Books list")
        ]
    )]
    public function index(Request $request)
    {
        $query = Book::query();

        if ($request->filled('author')) {
            $query->where('author', 'like', "%{$request->author}%");
        }

        if ($request->filled('genre')) {
            $query->where('genre', $request->genre);
        }

        $perPage = min((int) $request->input('per_page', 10), 100);
        $books = $query->paginate($perPage);

        return BookResource::collection($books);
    }

    #[OA\Post(
        path: "/api/books",
        tags: ["Books"],
        summary: "Create book",
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(ref: "#/components/schemas/Book")
        ),
        responses: [
            new OA\Response(response: 201, description: "Created")
        ]
    )]
    public function store(StoreBookRequest $request)
    {
        $book = Book::create($request->validated());

        return (new BookResource($book))
            ->response()
            ->setStatusCode(201);
    }

    #[OA\Get(
        path: "/api/books/{id}",
        tags: ["Books"],
        summary: "Get book",
        parameters: [
            new OA\Parameter(
                name: "id",
                in: "path",
                required: true,
                schema: new OA\Schema(type: "integer")
            )
        ],
        responses: [
            new OA\Response(response: 200, description: "Book detail")
        ]
    )]
    public function show(Book $book)
    {
        return new BookResource($book);
    }

    #[OA\Patch(
        path: "/api/books/{id}",
        tags: ["Books"],
        summary: "Update book",
        parameters: [
            new OA\Parameter(
                name: "id",
                in: "path",
                required: true,
                schema: new OA\Schema(type: "integer")
            )
        ],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(ref: "#/components/schemas/Book")
        ),
        responses: [
            new OA\Response(response: 200, description: "Updated")
        ]
    )]
    public function update(UpdateBookRequest $request, Book $book)
    {
        $book->update($request->validated());

        return new BookResource($book);
    }

    #[OA\Delete(
        path: "/api/books/{id}",
        tags: ["Books"],
        summary: "Delete book",
        parameters: [
            new OA\Parameter(
                name: "id",
                in: "path",
                required: true,
                schema: new OA\Schema(type: "integer")
            )
        ],
        responses: [
            new OA\Response(response: 204, description: "Deleted")
        ]
    )]
    public function destroy(Book $book)
    {
        $book->delete();

        return response()->noContent();
    }
}
