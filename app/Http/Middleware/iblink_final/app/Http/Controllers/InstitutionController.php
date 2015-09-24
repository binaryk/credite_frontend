<?php namespace App\Http\Controllers;

use App\Models\City;
use App\Models\County;
use App\Models\Institution;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Input;

class InstitutionController extends Base\BaseController  {

    use ValidatesRequests;

    /** @var Request */
    protected $request;

    public function __construct(Request $request) {
        $this->request = $request;
    }

    public function edit() {

        /** @var Institution $institution */
        $institution = Institution::current();

        $city = false;

        if (($county_id = Input::old('county'))) {

            $county = County::find($county_id);

            if (($city_id = Input::old('city'))) {
                $city = City::find($city_id);
            }

        } else {
            $city   = $institution->city;
            $county = $city->county;
        }

        return view('institution.edit', [
            'institution' => $institution,
            'counties'    => County::orderBy('name')->get(),
            'city'        => $city,
            'county'      => $county,
        ]);
    }

    public function editPost(Institution $institution) {

        /** @var Institution $institution */
        $institution = Institution::current();

        if (Input::get('institution_id') != $institution->id) {
            // institution switched - prevents data loss
            return redirect()->route('institution');
        }

        $this->validate($this->request, [
            'name'        => 'required|min:4',
            'email'       => 'email',
            'description' => 'min:10',
            'county'      => 'required|exists:counties,id',
            'city'        => 'required|exists:cities,id',
            //'sirues' => '',
            //'cycle'       => '',
            //'phone' => '',
            //'address' => '',
            //'image' => '',
        ], [
            'email.required'  => 'Introduceți o adresă de email',
            'description.min' => 'Descrierea trebuie să conțină minim 10 caractere',
            'name.required'   => 'Câmpul nume este obligatoriu',
            'name.min'        => 'Câmpul nume trebuie să conțină minim 4 caractere',
            'county.required' => 'Câmpul județ este obligatoriu',
            'city.required'   => 'Câmpul localitate este obligatoriu',
        ]);

        $institution->city_id = City::find(Input::get('city'))->id;
        $institution->fill(Input::all())
                    ->save();

        return redirect()
            ->route('institution');
    }

}
