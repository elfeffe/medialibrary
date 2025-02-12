<?php
namespace Elfeffe\Medialibrary\Models;

use Elfeffe\ImageResizer\Traits\HasImageResizer;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class MediaLibrary extends Model implements HasMedia
{
    use InteractsWithMedia;
    use HasImageResizer;

    protected $table = 'media_library';
    protected $guarded = [];

    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->uploaded_by_user_id = auth()->id();
        });
    }

    public function getItem(string $collection = 'default'): Media
    {
        ray($this->getMedia());
        return $this->getFirstMedia($collection);
    }
}
