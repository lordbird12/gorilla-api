<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductItem extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'product_items';
    protected $softDelete = true;

    protected $hidden = ['password', 'deleted_at'];

    //////////////////////////////////////// relation //////////////////////////////////////

    public function product_timelines()
    {
        return $this->belongsTo(ProductTimeline::class);
    }
}