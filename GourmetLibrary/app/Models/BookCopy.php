<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BookCopy extends Model
{
    use HasFactory;

    protected $fillable = [
        'book_id',
        'copy_number',
        'condition',
        'damage_notes',
        'missing_pages',
        'is_available'
    ];

    protected $casts = [
        'is_available' => 'boolean',
        'missing_pages' => 'integer'
    ];

    public function book(): BelongsTo
    {
        return $this->belongsTo(Book::class);
    }

    public function isDamaged(): bool
    {
        return in_array($this->condition, ['poor', 'damaged']);
    }

    public function markAsDamaged(string $notes = null): void
    {
        $this->update([
            'condition' => 'damaged',
            'damage_notes' => $notes
        ]);
    }
}
