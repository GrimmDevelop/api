<?php

namespace App\Providers;

use App\Import\Persons\Converter\PersonConverter;
use App\Import\Persons\Parser\BioDataParser;
use App\Import\Persons\Parser\InheritanceParser;
use App\Import\Persons\Parser\NameParser;
use App\Import\Persons\Parser\PersonPrintParser;
use App\Import\Persons\Parser\RestFieldParser as PersonRestFieldParser;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(PersonConverter::class, function() {
            $converter = new PersonConverter();

            $converter->registerParsers([
                new NameParser(),
                new BioDataParser(),
                new PersonPrintParser(),
                new InheritanceParser(),
                new PersonRestFieldParser()
            ]);

            return $converter;
        });
    }
}
