# LaravelAddress

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Total Downloads][ico-downloads]][link-downloads]
[![Build Status][ico-travis]][link-travis]
[![StyleCI][ico-styleci]][link-styleci]

Laravel Address is a package to manage addresses that belong to your models. You can add addresses to any eloquent model with ease.

## Installation

1. Install the package via composer:

    ```shell
    composer require bkfdev/laravel-address
    ```

2. Publish resources (migrations and config files):

    ```shell
    php artisan vendor:publish --provider="Bkfdev\Addressable\AddressesServiceProvider"
    ```

3. Run migrations:

    ```shell
    php artisan migrate
    ```

4. Done!

## Usage

To add addresses support to your eloquent models simply use `\Bkfdev\Addressable\Traits\Addressable` trait.

### Manage your addresses

```php
// Get instance of your model
$user = new \App\Models\User::find(1);

// Create a new address
$user->addresses()->create([
    'label' => 'Default Address',
    'country_code' => 'dz',
    'street' => '56 john doe st.',
    'state' => 'Canterbury',
    'city' => 'Christchurch',
    'postal_code' => '7614',
    'latitude' => '31.2467601',
    'longitude' => '29.9020376',
    'is_primary' => true,
]);

// Create multiple new addresses
$user->addresses()->createMany([
    [...],
    [...],
    [...],
]);

// Find an existing address
$address = Bkfdev\Addressable\Models\Address::find(1);

// Update an existing address
$address->update([
    'label' => 'Default Work Address',
]);

// Delete address
$address->delete();

// Alternative way of address deletion
$user->addresses()->where('id', 123)->first()->delete();
```

### Manage your addressable model

The API is intuitive and very straight forward, so let's give it a quick look:

```php
// Get instance of your model
$user = new \App\Models\User::find(1);

// Get attached addresses collection
$user->addresses;

// Get attached addresses query builder
$user->addresses();

// Scope Primary Addresses
$primaryAddresses = Bkfdev\Addressable\Models\Address::isPrimary()->get();

// Scope Addresses in the given country
$algerianAddresses = Bkfdev\Addressable\Models\Address::inCountry('dz')->get();

```

## Changelog

Refer to the [Changelog](CHANGELOG.md) for a full history of the project.

## Support

Please raise a GitHub issue.

## Testing

```bash
$ composer test
```

## Contributing

Please see [contributing.md](contributing.md) for details and a todolist.

## Security

If you discover any security related issues, please email bkfdev@gmail.com instead of using the issue tracker.

## Credits

-   [Author Name][link-author]
-   [All Contributors][link-contributors]

## License

MIT. Please see the [license file](license.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/bkfdev/laravel-address.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/bkfdev/laravel-address.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/bkfdev/laravel-address/master.svg?style=flat-square
[ico-styleci]: https://styleci.io/repos/12345678/shield
[link-packagist]: https://packagist.org/packages/bkfdev/laravel-address
[link-downloads]: https://packagist.org/packages/bkfdev/laravel-address
[link-travis]: https://travis-ci.org/bkfdev/laravel-address
[link-styleci]: https://styleci.io/repos/12345678
[link-author]: https://github.com/bkfdev
[link-contributors]: ../../contributors
