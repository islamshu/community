<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Models\DiscountPackage;

class UpdateUniqeDate implements Rule
{
    private $packageId;
    private $startAt;
    private $endAt;
    private $exceptId; // The ID of the current discount to be excluded


    public function __construct($packageId, $startAt, $endAt, $exceptId = null)
    {
        $this->packageId = $packageId;
        $this->startAt = $startAt;
        $this->endAt = $endAt;
        $this->exceptId = $exceptId;
    }

    public function passes($attribute, $value)
    {
        // Check if there are any existing discounts for the given package with overlapping or duplicate date ranges
        $overlapDiscounts = DiscountPackage::where('id', '!=', $this->exceptId)->where('package_id', $this->packageId)
            ->where(function ($query) {
                $query->where('start_at', '<=', $this->startAt)
                    ->where('end_at', '>=', $this->startAt);
            })->orWhere(function ($query) {
                $query->where('start_at', '<=', $this->endAt)
                    ->where('end_at', '>=', $this->endAt);
            })->orWhere(function ($query) {
                $query->where('start_at', '>=', $this->startAt)
                    ->where('start_at', '<=', $this->endAt);
            });

        // If updating an existing discount, exclude the current discount from the query
       
        dd($overlapDiscounts->first());

        // If there are overlapping discounts, the validation fails
        return !$overlapDiscounts->exists();
    }

    public function message()
    {
        return 'The date range overlaps with an existing discount for the given package.';
    }
}
