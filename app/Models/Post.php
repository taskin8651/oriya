<?php

namespace App\Models;

use App\Traits\Auditable;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Post extends Model implements HasMedia
{
    use SoftDeletes, InteractsWithMedia, Auditable, HasFactory;

    public $table = 'posts';

    protected $appends = [
        'image',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public const STATUS_SELECT = [
        'draft'     => 'Draft',
        'published' => 'Published',
    ];

    protected $fillable = [
        'title',
        'slug',
        'short_description',
        'content',
        'category_id',
        'author_id',
        'status',
        'view',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected static function booted(): void
    {
        static::saving(function (Post $post): void {
            if (filled($post->slug)) {
                return;
            }

            // Keep combining marks used in Odia and other scripts.
            $titleSlug = preg_replace('/[^\pL\pM\pN]+/u', '-', Str::lower($post->title ?? ''));
            $baseSlug = trim(Str::substr(trim($titleSlug ?? '', '-'), 0, 255), '-') ?: 'post';
            $slug = $baseSlug;
            $existingPosts = $post->newQuery()->withTrashed();

            if ($post->exists) {
                $existingPosts->whereKeyNot($post->getKey());
            }

            for ($number = 2; (clone $existingPosts)->where('slug', $slug)->exists(); $number++) {
                $suffix = '-' . $number;
                $slug = rtrim(Str::substr($baseSlug, 0, 255 - strlen($suffix)), '-') . $suffix;
            }

            $post->slug = $slug;
        });
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')->fit('crop', 50, 50);
        $this->addMediaConversion('preview')->fit('crop', 120, 120);
    }

    public function getImageAttribute()
    {
        $file = $this->getMedia('image')->last();
        if ($file) {
            $file->url       = $file->getUrl();
            $file->thumbnail = $file->getUrl('thumb');
            $file->preview   = $file->getUrl('preview');
        }

        return $file;
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }
}
