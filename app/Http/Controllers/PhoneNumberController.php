<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\PhoneNumberService;

class PhoneNumberController extends Controller
{
    protected $phoneNumberService;

    public function __construct()
    {
        $this->phoneNumberService = app(PhoneNumberService::class);
    }

    /**
     * Get paginated phone numbers based on filters.
     */
    public function index(Request $request)
    {
        $country = $request->input('country');
        $state = $request->input('state');

        $phoneNumbers = $this->phoneNumberService->getFilteredPhoneNumbers($country, $state);

        return response()->json([
            'data' => $phoneNumbers->items(),
            'prev_page_url' => $phoneNumbers->previousPageUrl(),
            'next_page_url' => $phoneNumbers->nextPageUrl()
        ]);
    }

    /**
     * Get a list of unique countries from phone numbers.
     */
    public function getCountries()
    {
        $countries = $this->phoneNumberService->getDistinctCountries();
        return response()->json($countries);
    }
}
