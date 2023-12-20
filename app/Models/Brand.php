<?php

namespace App\Models;

use App\Models\Upload;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Brand extends Model
{
    use HasFactory;

    public function image(): BelongsTo
    {
        return $this->belongsTo(Upload::class);
    }

    public function products() {
        return $this->hasMany(Product::class, 'product_id');
    }
}
