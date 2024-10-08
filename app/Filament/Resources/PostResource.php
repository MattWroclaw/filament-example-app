<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PostResource\Pages;

use App\Filament\Resources\PostResource\RelationManagers\AuthorsRelationManager;
use App\Models\Post;
use Filament\Forms;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Tabs\Tab;
use Filament\Support\Enums\IconPosition;
use Filament\Tables;
use Filament\Tables\Columns\ColorColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\CheckboxColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PostResource extends Resource
{
    protected static ?string $model = Post::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                Tabs::make('Create New Post')->tabs([

                    Tab::make('Tab 1')
                        ->icon('heroicon-o-chat-bubble-oval-left')
                        ->iconPosition(IconPosition::After)
                        ->badge('this is a badge')
                        ->schema([
                        TextInput::make('title')->required()->minLength(2)->maxLength(10),
                        TextInput::make('slug')->unique(ignoreRecord: true)->required(),
                        Select::make('category_id')
                            ->label('Category')
                            // ->options(
                            //     \App\Models\Category::all()->pluck('name', 'id'))
                            ->relationship('category', 'name')
                            ->searchable()
                            ->required(),
                        ColorPicker::make('color'),
                    ]),

                    Tab::make('Content')->schema([

                        MarkdownEditor::make('content')->required()->columnSpan('full'),
                    ]),

                    Tab::make('Meta')->schema([

                        FileUpload::make('thumbnail')->disk('public')
                            ->directory('thumbnails')
                            ->nullable(),

                        TagsInput::make('tag')->required(),
                        Checkbox::make('published'),
                    ]),
                ])->columnSpanFull()->activeTab(2)->persistTabInQueryString(),



            ])->columns(
                2
                // we can control it manually but this is not needed, filament will handle it automatically
                //     [
                //     'default' => 1,
                //     'md' => 2,
                //     'lg' => 3,
                //     'xl' => 4,
                // ]

            );
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->sortable()->searchable()->toggleable(isToggledHiddenByDefault: true),

                ImageColumn::make('thumbnail')->toggleable(),
                ColorColumn::make('color')->toggleable(),
                TextColumn::make('title')->sortable()->searchable(),
                TextColumn::make('slug')->sortable()->searchable(),
                TextColumn::make('category.name')->label('Category Name')->sortable()->searchable(),
                TextColumn::make('tag'),
                CheckboxColumn::make('published')->toggleable(),
                TextColumn::make('created_at')->label('Published on')
                    ->date()->sortable()->searchable()->toggleable(),


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
            AuthorsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPosts::route('/'),
            'create' => Pages\CreatePost::route('/create'),
            'edit' => Pages\EditPost::route('/{record}/edit'),
        ];
    }
}
