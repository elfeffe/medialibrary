<?php

namespace Elfeffe\Medialibrary\Models;

use Elfeffe\ImageResizer\Traits\HasImageResizer;
use Illuminate\Database\Eloquent\Model;
use Spatie\Image\Enums\Fit;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class MediaLibrary extends Model implements HasMedia
{
    use HasImageResizer;
    use InteractsWithMedia;

    protected $table = 'media_library';

    protected $guarded = [];

    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->uploaded_by_user_id = auth()->id();
        });
    }

    /**
     * The first media in a collection, or null when the row has none.
     *
     * A MediaLibrary row legitimately exists without a file — created directly,
     * or mid-upload — so this mirrors getFirstMedia()'s own nullability rather
     * than promising a Media that isn't there.
     */
    /**
     * Small square tiles are drawn all over the apps — a picker row's example, a
     * grid cell — and the library holds full-size originals, so it ships the tile
     * itself rather than letting every page pull a megabyte to paint 40 pixels.
     */
    public function registerMediaConversions(?Media $media = null): void
    {
        $this->addMediaConversion('card')
            ->fit(Fit::Crop, 96, 96)
            ->format('webp');
    }

    public function getItem(string $collection = 'default'): ?Media
    {
        return $this->getFirstMedia($collection);
    }

    public function tenant(): ?\Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        $tenantModel = config('medialibrary.tenant_model');

        if (! $tenantModel) {
            return null;
        }

        return $this->belongsTo($tenantModel, 'tenant_id');
    }
}
