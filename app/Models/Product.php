<?php

namespace App\Models;

use App\Models\Upload;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory,SoftDeletes;

    public function category() {

        return $this->belongsTo(Category::class, 'category_id');
    }

    public function brand() {

        return $this->belongsTo(brand::class, 'brand_id');
    }

    public function created_by () {

        return $this->belongsTo(User::class, 'created_by');
    }

    public function image(): BelongsTo
    {
        return $this->belongsTo(Upload::class);
    }
}
