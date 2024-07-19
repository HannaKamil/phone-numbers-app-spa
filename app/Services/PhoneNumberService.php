<?php

namespace App\Services;

use App\Models\PhoneNumber;

class PhoneNumberService
{
    public function getFilteredPhoneNumbers($country = null, $state = null)
    {
        $query = PhoneNumber::query();

        if ($country) {
            $query->where('country', $country);
        }

        if ($state) {
            $query->where('state', $state);
        }

        return $query->paginate(10);
    }

    public function getDistinctCountries()
    {
        return PhoneNumber::select('country')->distinct()->pluck('country');
    }
}
