<?php

declare(strict_types=1);

namespace Bkfdev\Addressable\Models;

use Bkfdev\World\Models\City;
use Bkfdev\World\Models\Country;
use Bkfdev\World\Models\State;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Address extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $with = ['country', 'state', 'city'];

    protected $fillable = [
        'addressable_id',
        'addressable_type',
        'label',
        'country_id',
        'state_id',
        'city_id',
        'street',
        'postal_code',
        'latitude',
        'longitude',
        'is_primary',
        'is_billing',
        'is_shipping',
    ];


    protected $casts = [
        'addressable_id' => 'integer',
        'addressable_type' => 'string',
        'label' => 'string',
        'street' => 'string',
        'postal_code' => 'string',
        'latitude' => 'float',
        'longitude' => 'float',
        'is_primary' => 'boolean',
        'is_billing' => 'boolean',
        'is_shipping' => 'boolean',
        'deleted_at' => 'datetime',
    ];

    public function __construct(array $attributes = [])
    {
        $this->setTable(config('laravel-address.tables.addresses'));

        parent::__construct($attributes);
    }

    public function addressable(): MorphTo
    {
        return $this->morphTo('addressable', 'addressable_type', 'addressable_id', 'id');
    }

    public function scopeIsPrimary(Builder $builder): Builder
    {
        return $builder->where('is_primary', true);
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
}
