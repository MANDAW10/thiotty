<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Facades\Storage;

class Slide extends Model
{
    protected $fillable = [
        'image',
        'title',
        'subtitle',
        'button_text',
        'button_url',
        'order_priority',
        'is_active',
    ];

    protected $appends = ['image_url'];

    /**
     * Get the slide image URL.
     */
    protected function imageUrl(): Attribute
    {
        return Attribute::make(
            get: function () {
                if ($this->image && str_starts_with($this->image, 'slides/')) {
                    return asset('storage/' . $this->image);
                }

                if ($this->image && str_starts_with($this->image, 'slides/')) {
                    return asset('storage/' . $this->image);
                }

                if ($this->image && Storage::disk('public')->exists($this->image)) {
                    return Storage::disk('public')->url($this->image);
                }

                // Fallback to absolute URL if stored as one, or local public path
                if (str_starts_with($this->image, 'http')) {
                    return $this->image;
                }

                if (file_exists(public_path($this->image))) {
                    return asset($this->image);
                }

                return 'https://images.unsplash.com/photo-1547496502-affa22d38842?q=80&w=2600&auto=format&fit=crop';
            }
        );
    }
}
