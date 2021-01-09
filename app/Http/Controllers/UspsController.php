<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Helpers\Address;
use App\Helpers\AddressVerify;

class UspsController extends Controller
{
    public function validateInlineAddress()
    {
        $validated = $this->validateAddr([ 
            'Address' => request()->input('address1') ?? null,
            'Zip' => request()->input('zip') ?? null,
            'Apartment' => request()->input('address2') ?? null,
            'City' => request()->input('city') ?? null,
            'State' => request()->input('state') ?? 'FL',
        ]);

        return response()->json($validated);
    }

    public function validateAddr($request) 
    {
        $verify = new AddressVerify(config('app.usps_username'));
        $address = new Address;
        $address->setFirmName(null);
        $address->setApt( (array_key_exists('Apartment', $request) ? $request['Apartment'] : null ) );
        $address->setAddress( (array_key_exists('Address', $request) ? $request['Address'] : null ) );
        $address->setCity( (array_key_exists('City', $request) ? $request['City'] : null ) );
        $address->setState( (array_key_exists('State', $request) ? $request['State'] : null ) );
        $address->setZip5( (array_key_exists('Zip', $request) ? $request['Zip'] : null ) );
        $address->setZip4('');
        
        // Add the address object to the address verify class
        $verify->addAddress($address);
        
        // Perform the request and return result
        $val1 = $verify->verify();
        $val2 = $verify->getArrayResponse();
        
        // var_dump($verify->isError());
        
        // See if it was successful
        if ($verify->isSuccess()) {
            return ['address' => $val2['AddressValidateResponse']['Address']];
        } else {
            return ['error' => $verify->getErrorMessage()];
        }    
    }
}
