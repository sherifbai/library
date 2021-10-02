<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * App\Models\BookOrder
 *
 * @property int $id
 * @property int $book_id
 * @property int $user_id
 * @property int $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Book[] $books
 * @property-read int|null $books_count
 * @method static \Illuminate\Database\Eloquent\Builder|BookOrder newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BookOrder newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BookOrder query()
 * @method static \Illuminate\Database\Eloquent\Builder|BookOrder whereBookId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BookOrder whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BookOrder whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BookOrder whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BookOrder whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BookOrder whereUserId($value)
 * @mixin \Eloquent
 */
class BookOrder extends Model
{
    use HasFactory;

    public const STATUS_CANCELED = 0;
    public const STATUS_RESERVED = 1;
    public const STATUS_ACTIVE = 2;
    public const STATUS_COMPLETED = 3;

    protected $fillable = ['book_id', 'user_id'];

    public function books(): BelongsToMany
    {
        return $this->belongsToMany(Book::class,'book_orders', 'book_id');
    }
}
