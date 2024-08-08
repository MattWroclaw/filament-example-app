<?php

namespace App\Filament\Resources\CategoryResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;


use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Section;
use Filament\Tables\Columns\ColorColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\CheckboxColumn;


class PostsRelationManager extends RelationManager
{
    protected static string $relationship = 'posts';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Create a Post')
                    ->description('Create Post over here')
                    ->collapsible()
                    ->schema([

                        Group::make()->schema([
                            TextInput::make('title')->required()->minLength(2)->maxLength(10),
                            TextInput::make('slug')->unique(ignoreRecord: true)->required(),
                        ]),

// *** We dont need Category in this place. Filament will auto select the propper Category ~~~****
                        // Select::make('category_id')
                        //     ->label('Category')
                        //     // ->options(
                        //     //     \App\Models\Category::all()->pluck('name', 'id'))
                        //     ->relationship('category', 'name')
                        //     ->searchable()
                        //     ->required(),


                        MarkdownEditor::make('content')->required()->columnSpan('full'),
                        ColorPicker::make('color'),
                    ])->columnSpan(2)->columns(2),

                Group::make()->schema([
                    Section::make('Image')
                        ->schema([

                            FileUpload::make('thumbnail')->disk('public')
                                ->directory('thumbnails')
                                ->nullable(),

                        ])->columnSpan(1)->collapsible(),

                    Section::make('Meta')
                        ->schema([
                            TagsInput::make('tag')->required(),
                            Checkbox::make('published'),
                        ]),
                ])



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








        // ->schema([
        //     Forms\Components\TextInput::make('title')
        //         ->required()
        //         ->maxLength(255),
        // ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('title')
            ->columns([
                Tables\Columns\TextColumn::make('title'),
                Tables\Columns\TextColumn::make('slug'),
                Tables\Columns\CheckboxColumn::make('published'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
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
}
