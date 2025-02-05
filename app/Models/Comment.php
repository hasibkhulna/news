<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Arr;

class Comment extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'commentable_id',
        'commentable_type',
        'comment_id',
        'user_id',
        'description',
        'is_approved',
    ];

    public function commentable(): MorphTo
    {
        return $this->morphTo();
    }

    public function comment(): BelongsTo
    {
        return $this->belongsTo(self::class);
    }

    public function comments(): HasMany
    {
        return $this->hasMany(self::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getCommentableTypeAttribute(String $value): String
    {
        return Arr::last(explode("\\", $value));
    }

    public function excerpt()
    {
        return str_replace(
            "\n",
            "",
            str()->limit(strip_tags($this->description), 100)
        );
    }
}
