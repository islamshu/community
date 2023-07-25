<?php

namespace App\Models;

use App\Rules\DateNotOverlappingExistingDiscounts;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DiscountPackage extends Model
{
    use HasFactory;
    public function package()
    {
        return $this->belongsTo(Package::class);
    }
    protected $guarded=[];
   
}
