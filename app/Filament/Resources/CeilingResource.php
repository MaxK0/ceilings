<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CeilingResource\Pages;
use App\Models\Ceiling;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class CeilingResource extends Resource
{
    protected static ?string $model = Ceiling::class;

    protected static ?string $slug = 'ceilings';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationLabel = 'Потолки';
    protected static ?string $pluralLabel = 'Потолки';
    protected static ?string $label = 'Потолок';

    public static function form(Form $form): Form
    {
        return $form->schema([
            TextInput::make('name')
                ->label('Название')
                ->required()
                ->maxLength(255),

            Select::make('category_id')
                ->label('Категория')
                ->relationship('category', 'name')
                ->required(),

            Select::make('manufacturer_id')
                ->label('Производитель')
                ->relationship('manufacturer', 'name')
                ->required(),

            RichEditor::make('description')
                ->label('Описание')
                ->required()
                ->columnSpanFull(),

            TextInput::make('thickness')
                ->label('Толщина полотна')
                ->required()
                ->numeric()
                ->step(0.01)
                ->suffix('мм'),

            TextInput::make('width')
                ->label('Ширина полотна')
                ->required()
                ->numeric()
                ->integer()
                ->minValue(1)
                ->suffix('м'),

            TextInput::make('price')
                ->label('Цена')
                ->required()
                ->numeric()
                ->integer()
                ->minValue(1)
                ->prefix('₽')
                ->suffix('/м²'),

            Repeater::make('images')
                ->label('Изображения')
                ->relationship()
                ->schema([
                    FileUpload::make('image_path')
                        ->label('Фото')
                        ->image()
                        ->directory('ceilings')
                        ->required(),
                    TextInput::make('sort')
                        ->label('Порядок')
                        ->numeric()
                        ->default(0),
                ])
                ->orderable('sort')
                ->defaultItems(0)
                ->collapsible(),

            Placeholder::make('created_at')
                ->label('Создано')
                ->content(fn(?Ceiling $record): string => $record?->created_at?->diffForHumans() ?? '-'),

            Placeholder::make('updated_at')
                ->label('Обновлено')
                ->content(fn(?Ceiling $record): string => $record?->updated_at?->diffForHumans() ?? '-'),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Название')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('category.name')
                    ->label('Категория')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('manufacturer.name')
                    ->label('Производитель')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('price')
                    ->label('Цена')
                    ->money('RUR')
                    ->sortable(),

                TextColumn::make('thickness')
                    ->label('Толщина')
                    ->suffix(' мм')
                    ->sortable(),

                TextColumn::make('width')
                    ->label('Ширина')
                    ->suffix(' м')
                    ->sortable(),

                TextColumn::make('created_at')
                    ->label('Дата создания')
                    ->dateTime('d.m.Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCeilings::route('/'),
            'create' => Pages\CreateCeiling::route('/create'),
            'edit' => Pages\EditCeiling::route('/{record}/edit'),
        ];
    }

    public static function getGlobalSearchEloquentQuery(): Builder
    {
        return parent::getGlobalSearchEloquentQuery()->with(['category', 'manufacturer']);
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['name', 'category.name', 'manufacturer.name'];
    }

    public static function getGlobalSearchResultDetails(Model $record): array
    {
        $details = [];

        if ($record->category) {
            $details['Category'] = $record->category->name;
        }

        if ($record->manufacturer) {
            $details['Manufacturer'] = $record->manufacturer->name;
        }

        return $details;
    }
}
