<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     schema="Book",
 *     required={"title","publisher","author","genre","publication_date","words_count","price"},
 *     @OA\Property(property="title", type="string", example="Clean Code"),
 *     @OA\Property(property="publisher", type="string", example="Prentice Hall"),
 *     @OA\Property(property="author", type="string", example="Robert C. Martin"),
 *     @OA\Property(property="genre", type="string", example="Programming"),
 *     @OA\Property(property="publication_date", type="string", format="date", example="2008-01-01"),
 *     @OA\Property(property="words_count", type="integer", example=120000),
 *     @OA\Property(property="price", type="number", format="float", example=39.99)
 * )
 */
class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'publisher',
        'author',
        'genre',
        'publication_date',
        'words_count',
        'price',
    ];

    protected $casts = [
        'publication_date' => 'date',
        'price' => 'decimal:2',
    ];
}
