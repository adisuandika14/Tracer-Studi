<?php

namespace App\Http\Livewire;

use App\Models\regency;
use App\Models\province;
use App\Models\district;
use Livewire\Component;

class CountryStateCity extends Component
{
    public $countries;
    public $states;
    public $cities;

    public $selectedCountry = null;
    public $selectedState = null;
    public $selectedCity = null;

    public function mount($selectedCity = null)
    {
        $this->countries = province::all();
        $this->states = collect();
        $this->cities = collect();
        $this->selectedCity = $selectedCity;

        if (!is_null($selectedCity)) {
            $city = regency::with('state.country')->find($selectedCity);
            if ($city) {
                $this->cities = regency::where('regencies_id', $city->regencies_id)->get();
                $this->states = district::where('province_id', $city->state->province_id)->get();
                $this->selectedCountry = $city->state->province_id;  
                $this->selectedState = $city->regencies_id;
            }
        }
    }

    public function render()
    {
        return view('livewire.country-state-city');
    }

    public function updatedSelectedCountry($country)
    {
        $this->states = district::where('id', $country)->get();
        $this->selectedState = NULL;
    }

    public function updatedSelectedState($state)
    {
        if (!is_null($state)) {
            $this->cities = regency::where('province_id', $state)->get();
        }
    }
}
