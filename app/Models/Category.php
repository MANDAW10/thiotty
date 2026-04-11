<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    protected $fillable = ['name', 'slug', 'icon', 'image'];
    protected $appends = ['image_url', 'display_name'];

    /**
     * Get the translated name.
     */
    protected function displayName(): \Illuminate\Database\Eloquent\Casts\Attribute
    {
        return \Illuminate\Database\Eloquent\Casts\Attribute::make(
            get: function () {
                $key = 'messages.' . strtolower($this->slug);
                return \Illuminate\Support\Facades\Lang::has($key) ? __($key) : $this->name;
            }
        );
    }

    /**
     * Get the category's image URL with professional fallbacks.
     */
    protected function imageUrl(): \Illuminate\Database\Eloquent\Casts\Attribute
    {
        return \Illuminate\Database\Eloquent\Casts\Attribute::make(
            get: function () {
                // 1. Check storage (new uploads)
                if ($this->image && \Illuminate\Support\Facades\Storage::disk('public')->exists($this->image)) {
                    return \Illuminate\Support\Facades\Storage::disk('public')->url($this->image);
                }

                // 2. Local check (public/img/categories/)
                if ($this->image) {
                    $localPath = 'img/categories/' . $this->image;
                    if (file_exists(public_path($localPath))) {
                        return asset($localPath);
                    }
                    if (str_starts_with($this->image, 'http')) {
                        return $this->image;
                    }
                }

                // 3. Final Fallback
                return 'https://images.unsplash.com/photo-1500382017468-9049fed747ef?auto=format&fit=crop&q=80&w=800';
            }
        );
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }
}
