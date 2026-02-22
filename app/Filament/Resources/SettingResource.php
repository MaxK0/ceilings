<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SettingResource\Pages;
use App\Models\Setting;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class SettingResource extends Resource
{
    protected static ?string $model = Setting::class;

    protected static ?string $navigationIcon = 'heroicon-o-cog';
    protected static ?string $navigationLabel = 'Настройки цен';
    protected static ?string $modelLabel = 'Настройку';
    protected static ?string $pluralModelLabel = 'Настройки';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Настройка')
                    ->schema([
                        Forms\Components\TextInput::make('translation')
                            ->label('Название')
                            ->disabled()
                            ->required(),

                        Forms\Components\TextInput::make('value')
                            ->label('Значение')
                            ->numeric()
                            ->required()
                            ->reactive(),
                    ])
                    ->columns(1),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('translation')
                    ->label('Название')
                    ->searchable(),
                Tables\Columns\TextColumn::make('value')
                    ->label('Значение')
                    ->formatStateUsing(fn ($state) => number_format($state, 0, ',', ' ') . ' ₽'),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Обновлено')
                    ->dateTime(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                // Удалены массовые действия
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
            'index' => Pages\ListSettings::route('/'),
            'edit' => Pages\EditSetting::route('/{record}/edit'),
        ];
    }
}
