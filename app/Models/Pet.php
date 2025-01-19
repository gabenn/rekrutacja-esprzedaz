<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\PetStatus;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $name
 * @property int $category_id
 * @property array $photo_urls
 * @property PetStatus $status
 * @property Category $category
 * @property Tag[] $tags
 */
class Pet extends Model
{
    public $timestamps = true;

    protected $fillable = ['name', 'category_id', 'photo_urls', 'status'];

    protected $casts = [
        'photo_urls' => 'array',
        'status' => PetStatus::class,
    ];

    public function category(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function tags(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Tag::class, 'pet_tag', 'pet_id', 'tag_id');
    }
}
