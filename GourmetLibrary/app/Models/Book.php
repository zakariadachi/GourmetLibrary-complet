<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'author',
        'description',
        'category_id',
        'total_pages',
        'isbn',
        'views_count',
        'borrows_count'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($book) {
            if (empty($book->slug)) {
                $book->slug = Str::slug($book->title);
            }
        });

        static::updating(function ($book) {
            if ($book->isDirty('title') && empty($book->slug)) {
                $book->slug = Str::slug($book->title);
            }
        });
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function copies(): HasMany
    {
        return $this->hasMany(BookCopy::class);
    }

    public function damagedCopies(): HasMany
    {
        return $this->hasMany(BookCopy::class)->whereIn('condition', ['poor', 'damaged']);
    }

    public function availableCopies(): HasMany
    {
        return $this->hasMany(BookCopy::class)->where('is_available', true);
    }

    public function incrementViews(): void
    {
        $this->increment('views_count');
    }

    public function incrementBorrows(): void
    {
        $this->increment('borrows_count');
    }
}
