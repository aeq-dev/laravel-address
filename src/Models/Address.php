<?php

declare(strict_types=1);

namespace Bkfdev\Addressable\Models;

use Bkfdev\World\Models\City;
use Bkfdev\World\Models\State;
use Bkfdev\World\Models\Country;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Address extends Model
{
    use HasFactory;
    use SoftDeletes;

    //protected $with = ['country', 'state', 'city'];

    protected $guarded = [];


    protected $casts = [
        'is_primary' => 'boolean',
        'is_billing' => 'boolean',
        'is_shipping' => 'boolean',
    ];

    public function addressable(): MorphTo
    {
        return $this->morphTo('addressable', 'addressable_type', 'addressable_id', 'id');
    }

    public function scopeIsPrimary(Builder $builder): Builder
    {
        return $builder->where('is_primary', true);
    }

    public function scopeIsBilling(Builder $builder): Builder
    {
        return $builder->where('is_billing', true);
    }
    public function scopeIsShipping(Builder $builder): Builder
    {
        return $builder->where('is_shipping', true);
    }
    public function getFullNameAttribute(): string
    {
        return implode(' ', [$this->given_name, $this->family_name]);
    }
    public function scopeInCountry(Builder $builder, string $countryId): Builder
    {
        return $builder->where('country_id', $countryId);
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function state()
    {
        return $this->belongsTo(State::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::saving(function (self $address) {
            $geocoding = config('laravel-address.geocoding.enabled');
            $geocoding_api_key = config('laravel-address.geocoding.api_key');
            if ($geocoding && $geocoding_api_key) {
                $segments[] = $address->street;
                $segments[] = sprintf('%s, %s %s', $address->city?->name, $address->state?->name, $address->postal_code);
                $segments[] = country($address->country?->country_code)->getName();

                $query = str_replace(' ', '+', implode(', ', $segments));
                $geocode = json_decode(
                    file_get_contents(
                        "https://maps.google.com/maps/api/geocode/json?address={$query}&sensor=false&key={$geocoding_api_key}"
                    )
                );

                if (count($geocode->results)) {
                    $address->latitude = $geocode->results[0]->geometry->location->lat;
                    $address->longitude = $geocode->results[0]->geometry->location->lng;
                }
            }
        });
    }
}