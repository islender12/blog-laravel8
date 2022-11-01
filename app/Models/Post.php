<?php

namespace App\Models;

use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;
    use HasSlug;

    protected $fillable = [
        'user_id',
        'title',
        'image',
        'body',
        'iframe',
    ];

    /**
     * Get the options for generating the slug.
     */
    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug');
    }

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }


    // Creamos un extracto de 150 letras para mostrar
    public function getGetExcerptAttribute()
    {
        return substr($this->body,0,150);
    }

    public function getGetImagenAttribute()
    {
        if($this->image){
            return url("storage/$this->image");
        }
    }
}
