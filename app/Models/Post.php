<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'posts';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'author_id',
        'title',
        'slug',
        'short_description',
        'description',
        'feature_image',
        'alt_text',
        'status',
        'visibility',
        'published_date',
        'meta_title',
        'meta_description',
        'created_by',
        'updated_by',
    ];

    public function setSlugAttribute($value)
    {
        $this->attributes['slug'] = str()->slug($value,'-');
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

}
