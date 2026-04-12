<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Storage;

class Product extends Model
{
    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'description',
        'price',
        'sale_price',
        'stock',
        'image',
        'is_featured',
    ];

    protected $appends = ['image_url', 'display_name', 'average_rating', 'selling_price', 'has_sale'];

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'sale_price' => 'decimal:2',
            'is_featured' => 'boolean',
        ];
    }

    /**
     * Prix affiché / panier (promo si défini et inférieur au prix barré).
     */
    protected function sellingPrice(): Attribute
    {
        return Attribute::make(
            get: function () {
                $regular = (float) $this->price;
                $sale = $this->sale_price !== null ? (float) $this->sale_price : null;

                if ($sale !== null && $sale > 0 && $sale < $regular) {
                    return $sale;
                }

                return $regular;
            }
        );
    }

    protected function hasSale(): Attribute
    {
        return Attribute::make(
            get: function () {
                $regular = (float) $this->price;
                $sale = $this->sale_price !== null ? (float) $this->sale_price : null;

                return $sale !== null && $sale > 0 && $sale < $regular;
            }
        );
    }

    /**
     * Get the translated name.
     */
    protected function displayName(): Attribute
    {
        return Attribute::make(
            get: function () {
                $key = 'messages.'.str_replace('-', '_', $this->slug);

                return Lang::has($key) ? __($key) : $this->name;
            }
        );
    }

    /**
     * Average rating from approved reviews only.
     */
    protected function averageRating(): Attribute
    {
        return Attribute::make(
            get: function () {
                $avg = $this->reviews()
                    ->where('is_approved', true)
                    ->avg('rating');

                return $avg !== null ? round((float) $avg, 2) : null;
            }
        );
    }

    /**
     * Get the product's image URL with professional fallbacks.
     */
    protected function imageUrl(): Attribute
    {
        return Attribute::make(
            get: function () {
                // Define professional fallbacks based on slug keywords
                $fallbacks = [
                    'vache-gobra' => 'https://images.unsplash.com/photo-1546445317-29f4545e9d53?auto=format&fit=crop&q=80&w=800',
                    'vache-metisse' => 'https://images.unsplash.com/photo-1596733430284-f7437764b1a9?auto=format&fit=crop&q=80&w=800',
                    'vache-laitiere' => 'https://images.unsplash.com/photo-1570042225831-d98fa7577f1e?auto=format&fit=crop&q=80&w=800',
                    'montbeliarde' => 'https://images.unsplash.com/photo-1547496502-affa22d38842?auto=format&fit=crop&q=80&w=800',
                    'holstein' => 'https://images.unsplash.com/photo-1560493676-04071c5f467b?auto=format&fit=crop&q=80&w=800',
                    'jersey' => 'https://images.unsplash.com/photo-1563911305907-b759d2b86604?auto=format&fit=crop&q=80&w=800',
                    'cheval' => 'https://images.unsplash.com/photo-1553284965-83fd3e82fa5a?auto=format&fit=crop&q=80&w=800',
                    'poussins' => 'https://images.unsplash.com/photo-1548550023-2bdb3c5beed7?auto=format&fit=crop&q=80&w=800',
                    'poulet' => 'https://images.unsplash.com/photo-1587593810167-a84920ea0831?auto=format&fit=crop&q=80&w=800',
                    'pintade' => 'https://images.unsplash.com/photo-1612170153139-6f881ff067e0?auto=format&fit=crop&q=80&w=800',
                    'pigeon' => 'https://images.unsplash.com/photo-1552728089-57bdde30beb3?auto=format&fit=crop&q=80&w=800',
                    'mouton' => 'https://images.unsplash.com/photo-1484557985045-edf745e49ea4?auto=format&fit=crop&q=80&w=800',
                    'ensilage' => 'https://images.unsplash.com/photo-1500595046743-cd271d694d30?auto=format&fit=crop&q=80&w=800',
                    'viande' => 'https://images.unsplash.com/photo-1607623814075-e41dfee430ef?auto=format&fit=crop&q=80&w=800',
                    'aliment' => 'https://images.unsplash.com/photo-1534067783941-51c9c2396414?auto=format&fit=crop&q=80&w=800',
                    'lait' => 'https://images.unsplash.com/photo-1550583724-1d2ee29ad7a2?auto=format&fit=crop&q=80&w=800',
                    'miel' => 'https://images.unsplash.com/photo-1587049352846-4a222e784d38?auto=format&fit=crop&q=80&w=800',
                ];

                // 1. Check if the image is stored in the public disk (new authenticated uploads)
                if ($this->image && Storage::disk('public')->exists($this->image)) {
                    return Storage::disk('public')->url($this->image);
                }

                // 2. Check for legacy local image in public/img/products/
                if ($this->image) {
                    $localPath = 'img/products/'.$this->image;

                    // Try exact match in the public directory
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

                // 3. Match slug to find best fallback
                foreach ($fallbacks as $key => $url) {
                    if (str_contains($this->slug, $key)) {
                        return $url;
                    }
                }

                // Final fallback
                return 'https://images.unsplash.com/photo-1596733430284-f7437764b1a9?auto=format&fit=crop&q=80&w=800';
            }
        );
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function wishlists()
    {
        return $this->hasMany(Wishlist::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    public function isFavoritedBy(?User $user): bool
    {
        if (! $user) {
            return false;
        }

        return $this->wishlists()->where('user_id', $user->id)->exists();
    }
}
