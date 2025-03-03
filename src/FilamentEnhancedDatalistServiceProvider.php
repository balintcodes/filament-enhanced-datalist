<?php

namespace Balintcodes\FilamentEnhancedDatalist;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class FilamentEnhancedDatalistServiceProvider extends PackageServiceProvider
{
    public static string $name = 'filament-enhanced-datalist';

    public static string $viewNamespace = 'filament-enhanced-datalist';

    public function configurePackage(Package $package): void
    {
        $package->name(static::$name)
            ->hasViews()
            ->hasTranslations();
    }
}
