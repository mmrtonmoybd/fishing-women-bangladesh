<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PostResource\Pages;
use App\Models\Category;
use App\Models\Post;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Navigation\NavigationItem;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class PostResource extends Resource
{
    protected static ?string $model = Post::class;

    protected static ?string $navigationIcon = 'heroicon-o-newspaper';

    protected static ?string $navigationGroup = 'Posts';

    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('category_id')
                    ->required()
                    ->options(Category::pluck('name', 'id')),
                Forms\Components\MarkdownEditor::make('content')
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('youtube_url')
                    ->nullable()
                    ->label('ইউটিউব ভিডিও লিংক(বাধ্যতামূলক না) (ইউটিউব ভিডিও দেওয়া হলে সেক্ষেত্রে ছবি / ভিডিও / অডিও প্রদান বাধ্যতামূলক না।)')
                    ->url()
                    ->maxLength(255),
                Forms\Components\FileUpload::make('thumbnail')
                    ->label('Image/Video/Audio')
                    ->requiredWithout('youtube_url'),
                Forms\Components\Toggle::make('status')
                    ->required()->default(true),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('category.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('title')
                    ->searchable(),
                Tables\Columns\TextColumn::make('user.name')
                    ->label('User name')
                    ->searchable(),
                Tables\Columns\IconColumn::make('is_guest')
                    ->boolean(),
                Tables\Columns\TextColumn::make('guest_name')
                    ->searchable(),
                Tables\Columns\ToggleColumn::make('status'),
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
                Tables\Actions\Action::make('View')
                    ->url(fn (Post $record): string => route('post.id', $record))
                    ->openUrlInNewTab(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])->defaultSort('created_at', 'desc');
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
            'index' => Pages\ListPosts::route('/'),
            'create' => Pages\CreatePost::route('/create'),
            'edit' => Pages\EditPost::route('/{record}/edit'),
            'pending' => Pages\PendingPost::route('/pending'),
        ];
    }

    public static function getNavigationItems(): array
    {
        return [
            // Link to the main "Posts" list (index page)
            NavigationItem::make('Posts')
                ->group(static::getNavigationGroup())
                ->icon(static::getNavigationIcon())
                ->url(static::getUrl('index'))
                ->isActiveWhen(fn () => request()->routeIs(static::getRouteBaseName().'.index')),

            // Link to the "Pending Post" page
            NavigationItem::make('Pending post')
                ->group(static::getNavigationGroup())
                ->icon('heroicon-o-clock') // Using a different icon for clarity
                ->url(static::getUrl('pending'))
                ->isActiveWhen(fn () => request()->routeIs(static::getRouteBaseName().'.pending'))
                ->badge(static::getModel()::where('status', 0)->count()),
        ];
    }
}
