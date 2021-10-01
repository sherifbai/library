<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Carbon;

/**
 * App\Models\Book
 *
 * @property int $id
 * @property string $author
 * @property string $genre
 * @property string $publisher
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|Book newModelQuery()
 * @method static Builder|Book newQuery()
 * @method static Builder|Book query()
 * @method static Builder|Book whereAuthor($value)
 * @method static Builder|Book whereCreatedAt($value)
 * @method static Builder|Book whereGenre($value)
 * @method static Builder|Book whereId($value)
 * @method static Builder|Book wherePublisher($value)
 * @method static Builder|Book whereUpdatedAt($value)
 * @mixin Eloquent
 * @property string $name
 * @method static Builder|Book whereName($value)
 * @property-read int|null $genre_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Genre[] $genres
 * @property-read int|null $genres_count
 */
class Book extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'author', 'publisher'];

    public function genres(): BelongsToMany
    {
        return $this->belongsToMany(Genre::class,'book_has_genres');
    }
}
