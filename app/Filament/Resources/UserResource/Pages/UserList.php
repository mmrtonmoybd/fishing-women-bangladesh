<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Pages\ListRecords;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Hash;

class UserList extends ListRecords
{
    protected static string $resource = UserResource::class;

    protected static ?string $title = 'Users';

    public function getTitle(): string
    {
        return 'Users';
    }

    public function getBreadcrumb(): string
    {
        return 'Users';
    }

    public function getBreadcrumbs(): array
    {
        return [
            route('filament.admin.resources.users.users') => 'Users',
            '' => 'List',
        ];
    }

    public function getTableQuery(): Builder
    {
        return User::query()->where('is_admin', false);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('phone')
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
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->label('Create User')
                    ->modalHeading('Create User')
                    ->url(null)
                    ->mutateFormDataUsing(function (array $data) {
                        $data['is_admin'] = 0; // ensure non-admin
                        if (! empty($data['password'])) {
                            $data['password'] = Hash::make($data['password']);
                        }

                        return $data;
                    })
                    ->form([
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('phone')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255),
                        Forms\Components\TextInput::make('password')
                            ->password()
                            ->confirmed()
                            ->required()
                            ->dehydrateStateUsing(fn ($state) => Hash::make($state))
                            ->dehydrated(fn ($state) => filled($state))
                            ->helperText('Set an initial password.'),
                        Forms\Components\TextInput::make('password_confirmation')
                            ->password()
                            ->dehydrated(false),
                    ]),
            ])

            ->actions([
                Tables\Actions\EditAction::make()
                    ->url(null)
                    ->modalHeading('Edit user')
                    // This is the key part: define the form for the modal here
                    ->form([
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('phone')
                            ->required() // Use ->tel() for phone number validation
                            ->unique(ignoreRecord: true)
                            ->maxLength(255),
                        // It's good practice to make password changes optional on edit
                        Forms\Components\TextInput::make('password')
                            ->password()
                            ->confirmed()
                            ->dehydrateStateUsing(fn ($state) => Hash::make($state))
                            ->dehydrated(fn ($state) => filled($state)) // Only update password if a new one is entered
                            ->helperText('Leave blank to keep the current password.'),
                        Forms\Components\TextInput::make('password_confirmation')
                            ->password()
                            ->dehydrated(false),
                    ]),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
