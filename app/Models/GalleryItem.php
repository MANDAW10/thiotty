<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Facades\Storage;

class GalleryItem extends Model
{
    protected $fillable = ['image', 'title', 'description', 'category'];

    /**
     * Get the item's image URL with professional fallbacks.
     */
    protected function imageUrl(): Attribute
    {
        return Attribute::make(
            get: function () {
                if ($this->image) {
                    $localPath = 'img/gallery/' . $this->image;
                    
                    // Try exact match in public directory
                    if (file_exists(public_path($localPath))) {
                        return asset($localPath);
                    }
                    
                    // Try .png version if .jpg was specified (for our AI generated ones)
                    $pngPath = str_replace('.jpg', '.png', $localPath);
                    if (file_exists(public_path($pngPath))) {
                        return asset($pngPath);
                    }
                    
                    // If it's a full URL, return it
                    if (str_starts_with($this->image, 'http')) {
                        return $this->image;
                    }
                }

                return 'https://images.unsplash.com/photo-1500382017468-9049fed747ef?auto=format&fit=crop&q=80&w=800';
            }
        );
    }
}
