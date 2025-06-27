<?php

namespace App\Filament\Pages;

use BezhanSalleh\FilamentShield\Traits\HasPageShield;
use Closure;
use Filament\Forms\Components;
use Filament\Forms\Components\Tabs;
use Outerweb\FilamentSettings\Filament\Pages\Settings as BaseSettings;

class Settings extends BaseSettings
{
    use HasPageShield;

    protected static ?string $navigationGroup = 'Settings';

    public function schema(): array|Closure
    {
        return [
            Tabs::make('Settings')
                ->schema([
                    Tabs\Tab::make('General')
                        ->schema([
                            Components\TextInput::make('general.brand_name')
                                ->required(),
                            Components\FileUpload::make('general.brand_logo')
                                ->image(),
                        ]),
                    Tabs\Tab::make('Seo')
                        ->schema([
                            Components\TextInput::make('seo.title')
                                ->required(),
                            Components\TextInput::make('seo.description')
                                ->required(),
                        ]),
                ]),
        ];
    }
}
