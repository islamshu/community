<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Models\DiscountPackage;

class UniqueDateRange implements Rule
{
    private $packageId;
    private $startAt;
    private $endAt;
    private $exceptId; // The ID of the current discount to be excluded


    public function __construct($packageId, $startAt, $endAt, $exceptId)
    {
        $this->packageId = $packageId;
        $this->startAt = $startAt;
        $this->endAt = $endAt;
        $this->exceptId = $exceptId;
    }

    public function passes($attribute, $value)
    {
        $startAt = $this->startAt;
        $endAt =   $this->endAt;
        $exceptId = $this->exceptId;
        $hasDiscountWithinDateRange = DiscountPackage::where('id', '!=', $exceptId)
            ->where('package_id', $this->packageId)->where(function ($query)
            use ($startAt, $endAt) {
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
            });

        // if (!is_null($this->exceptId) && is_numeric($this->exceptId)) {
        //     $hasDiscountWithinDateRange->where('id', '!=', $this->exceptId);
        // }
        // If there are overlapping discounts, the validation fails
        if (!is_null($this->exceptId) && is_numeric($this->exceptId)) {
            $hasDiscountWithinDateRange->where('id', '!=', $this->exceptId);
        }
        // dd($hasDiscountWithinDateRange->first());
        return !$hasDiscountWithinDateRange->exists();
    }

    public function message()
    {
        return 'The date range overlaps with an existing discount for the given package.';
    }
}
