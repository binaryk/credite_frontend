<?php namespace App\Http\Controllers;

use App\Http\Requests;

use App\Models\Country;
use App\Models\County;
use Illuminate\Database\Eloquent\Collection;

class GeoController extends Base\BaseController  {

    public function cities(County $county) {

        /** @var Collection $cities */
        $cities = $county->cities()
                         ->orderBy('name')
                         ->get(['id', 'name']);

        return $cities->toJson();
    }

    public function counties(Country $country) {

        if ($country->code != 'RO') {
            return (new Collection())->toJson();
        }

        return County::all()->toJson();
    }

}
