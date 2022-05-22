<?php

declare(strict_types=1);

namespace Bkfdev\Addressable\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Bkfdev\Addressable\Models\Address.
 *
 * @property int                 $id
 * @property int                 $addressable_id
 * @property string              $addressable_type
 * @property string              $label
 * @property string              $country_code
 * @property string              $street
 * @property string              $state
 * @property string              $city
 * @property string              $postal_code
 * @property float               $latitude
 * @property float               $longitude
 * @property bool                $is_primary
 * @property bool                $is_billing
 * @property bool                $is_shipping
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $addressable
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\Bkfdev\Addressable\Models\Address inCountry($countryCode)
 * @method static \Illuminate\Database\Eloquent\Builder|\Bkfdev\Addressable\Models\Address isBilling()
 * @method static \Illuminate\Database\Eloquent\Builder|\Bkfdev\Addressable\Models\Address isPrimary()
 * @method static \Illuminate\Database\Eloquent\Builder|\Bkfdev\Addressable\Models\Address isShipping()
 * @method static \Illuminate\Database\Eloquent\Builder|\Bkfdev\Addressable\Models\Address whereAddressableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Bkfdev\Addressable\Models\Address whereAddressableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Bkfdev\Addressable\Models\Address whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Bkfdev\Addressable\Models\Address whereCountryCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Bkfdev\Addressable\Models\Address whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Bkfdev\Addressable\Models\Address whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Bkfdev\Addressable\Models\Address whereIsBilling($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Bkfdev\Addressable\Models\Address whereIsPrimary($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Bkfdev\Addressable\Models\Address whereIsShipping($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Bkfdev\Addressable\Models\Address whereLabel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Bkfdev\Addressable\Models\Address whereLatitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Bkfdev\Addressable\Models\Address whereLongitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Bkfdev\Addressable\Models\Address wherePostalCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Bkfdev\Addressable\Models\Address whereState($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Bkfdev\Addressable\Models\Address whereStreet($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Bkfdev\Addressable\Models\Address whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Address extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $latColumn = 'latitude';

    protected $lngColumn = 'longitude';

    /**
     * {@inheritdoc}
     */
    protected $fillable = [
        'addressable_id',
        'addressable_type',
        'label',
        'country_code',
        'street',
        'state',
        'city',
        'postal_code',
        'latitude',
        'longitude',
        'is_primary',
    ];

    /**
     * {@inheritdoc}
     */
    protected $casts = [
        'addressable_id' => 'integer',
        'addressable_type' => 'string',
        'label' => 'string',
        'country_code' => 'string',
        'street' => 'string',
        'state' => 'string',
        'city' => 'string',
        'postal_code' => 'string',
        'latitude' => 'float',
        'longitude' => 'float',
        'is_primary' => 'boolean',
        'deleted_at' => 'datetime',
    ];

    /**
     * Create a new Eloquent model instance.
     *
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        $this->setTable(config('laravel-address.tables.addresses'));

        parent::__construct($attributes);
    }

    /**
     * Get the owner model of the address.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function addressable(): MorphTo
    {
        return $this->morphTo('addressable', 'addressable_type', 'addressable_id', 'id');
    }

    /**
     * Scope primary addresses.
     *
     * @param \Illuminate\Database\Eloquent\Builder $builder
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeIsPrimary(Builder $builder): Builder
    {
        return $builder->where('is_primary', true);
    }

    /**
     * Scope addresses by the given country.
     *
     * @param \Illuminate\Database\Eloquent\Builder $builder
     * @param string                                $countryCode
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeInCountry(Builder $builder, string $countryCode): Builder
    {
        return $builder->where('country_code', $countryCode);
    }
}
