# Laran

<hr>

### Installation
This package is not yet available on Packagist, so you need to add it to your project's `composer.json` file manually. This process tells Composer where to find the package's code.

#### Step 1: Add the Repository Source
Open your Laravel project's `composer.json` file and add the following `repositories` section. If you already have this section, just add the new entry to the array.
```json
"repositories": [
    {
        "type": "vcs",
        "url": "https://github.com/ErfanMasboogh/laran.git"
    }
],
```
#### Step 2: Require the Package
Next, add the package to the `require` section of your `composer.json` file. This tells Composer to install your package from the source you just defined.
```json
"require": {
    "erfanmasboogh/laran": "dev-main"
}
```
<b>Note:</b> We recommend using a specific branch like `dev-main` for development. Once the package is stable, you can create a tagged release (e.g., `1.0.0`) and change the version constraint.

#### Step 3: Install the Package
Finally, run the `composer update` command from your terminal to download and install the package.
```bash
    composer update
```
Composer will now install the `laran` package and its dependencies, and it will be available in your `vendor` directory.

#### Step 4: Publish the Package's Resources
The final step is to publish the package's configuration, front-end assets and ... to your application's directories.

```bash
    php artisan vendor:publish
```
Then, choose the `ErfanMasboogh\Laran\Providers\LaranServiceProvider` option to complete the process.
<br>

<b>Important:</b> You must also add our main seeder to your `DatabaseSeeder.php` file. To do this, Open 
`database/seeders/DatabaseSeeder.php` and add the following line to the `run()` method:
```php
$this->call(LaranSeeder::class);
```

<hr>

### Usage

Coming soon...

<hr>

### License

The Laran package is open-sourced software licensed under the [MIT license](https://opensource.org/license/MIT).

<hr>

### Author

- [Erfan Masboogh](https://github.com/ErfanMasboogh)
