<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PhoneNumber;

class PhoneNumberController extends Controller
{
    /**
     * Get paginated phone numbers based on filters.
     */
    public function index(Request $request)
    {
        $query = PhoneNumber::query();

        // Filter by country if specified
        if ($request->filled('country')) {
            $query->where('country', $request->input('country'));
        }

        // Filter by state if specified
        if ($request->filled('state')) {
            $query->where('state', $request->input('state'));
        }

        // Fetch paginated records
        $phoneNumbers = $query->paginate(10); // Adjust the number of items per page as needed

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
        $countries = PhoneNumber::select('country')->distinct()->pluck('country');
        return response()->json($countries);
    }
}
