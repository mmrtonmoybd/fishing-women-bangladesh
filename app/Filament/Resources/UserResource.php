<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Navigation\NavigationItem;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Hash;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static ?string $navigationGroup = 'Administration';

    protected static ?string $modelLabel = 'Admin';

    protected static ?string $pluralModelLabel = 'Admins';

    protected static ?string $navigationLabel = 'Admins';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('email')
                    ->email()
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->maxLength(255),

                Forms\Components\TextInput::make('password')
                    ->password()
                    ->confirmed()
                    ->columnSpan(1)
                    ->dehydrateStateUsing(fn ($state) => Hash::make($state))
                    ->dehydrated(fn ($state) => filled($state))
                    ->required(fn (string $context): bool => $context === 'create'),
                Forms\Components\TextInput::make('password_confirmation')
                    ->required(fn (string $context): bool => $context === 'create')
                    ->columnSpan(1)
                    ->password()
                    ->dehydrated(false),

                Forms\Components\Select::make('roles')
                    ->searchable()
                    ->preload()
                    ->required()
                    ->multiple()
                    ->relationship('roles', 'name')
                    ->label('Roles'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('roles.name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('posts_count')
                    ->counts([
                        'posts' => fn (Builder $query) => $query->where('status', true),
                    ]),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
            'users' => Pages\UserList::route('/users'),
        ];
    }

    public static function getNavigationItems(): array
    {
        return [
            // Link to the main "Posts" list (index page)
            NavigationItem::make('Admins')
                ->group(static::getNavigationGroup())
                ->icon(static::getNavigationIcon())
                ->url(static::getUrl('index'))
                ->isActiveWhen(fn () => request()->routeIs(static::getRouteBaseName().'.index')),

            // Link to the "Pending Post" page
            NavigationItem::make('Users')
                ->group(static::getNavigationGroup())
                ->icon('heroicon-o-user-group') // Using a different icon for clarity
                ->url(static::getUrl('users'))
                ->isActiveWhen(fn () => request()->routeIs(static::getRouteBaseName().'.users'))
                ->badge(static::getModel()::where('is_admin', false)->count()),
        ];
    }
}
