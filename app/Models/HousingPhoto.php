<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class HousingPhoto extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'housing_post_id',
        'file_path',
        'file_name',
        'caption',
        'is_primary',
        'sort_order',
        'mime_type',
        'file_size',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_primary' => 'boolean',
        'sort_order' => 'integer',
        'file_size' => 'integer',
    ];

    /**
     * Get the housing post that this photo belongs to.
     */
    public function housingPost(): BelongsTo
    {
        return $this->belongsTo(HousingPost::class);
    }

    /**
     * Get the full URL to the image.
     *
     * @return string
     */
    public function getUrlAttribute()
    {
        return Storage::url($this->file_path);
    }

    /**
     * Delete the file from storage when the model is deleted.
     */
    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($photo) {
            if (Storage::exists($photo->file_path)) {
                Storage::delete($photo->file_path);
            }
        });
    }
    
    /**
     * Set all other photos as non-primary when this one is set as primary.
     */
    public function setPrimary()
    {
        if (!$this->is_primary) {
            // First unset any existing primary photos
            static::where('housing_post_id', $this->housing_post_id)
                ->where('id', '!=', $this->id)
                ->update(['is_primary' => false]);
                
            // Then set this one as primary
            $this->is_primary = true;
            $this->save();
            
            return true;
        }
        
        return false;
    }
}
