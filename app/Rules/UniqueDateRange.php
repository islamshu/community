<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Models\DiscountPackage;

class UniqueDateRange implements Rule
{
    private $packageId;
    private $startAt;
    private $endAt;

    public function __construct($packageId, $startAt, $endAt)
    {
        $this->packageId = $packageId;
        $this->startAt = $startAt;
        $this->endAt = $endAt;
    }

    public function passes($attribute, $value)
    {
        $startAt = $this->startAt ;
      $endAt =   $this->endAt ;
        $hasDiscountWithinDateRange = DiscountPackage::where('package_id',$this->packageId)->where(function ($query) use ($startAt, $endAt) {
            $query->where('start_at', '>=', $startAt)
                ->where('end_at', '<=', $endAt);
        })->orWhere(function ($query) use ($startAt, $endAt) {
            $query->where('start_at', '<=', $startAt)
                ->where('end_at', '>=', $startAt)
                ->where('end_at', '<=', $endAt);
        })->orWhere(function ($query) use ($startAt, $endAt) {
            $query->where('start_at', '>=', $startAt)
                ->where('start_at', '<=', $endAt)
                ->where('end_at', '>=', $endAt);
        })->exists();
     

        // If there are overlapping discounts, the validation fails
        return !$hasDiscountWithinDateRange;
    }

    public function message()
    {
        return 'The date range overlaps with an existing discount for the given package.';
    }
}
