<?php

namespace App\Filament\Portal\Resources;

use App\Filament\Portal\Resources\TimeRegistrationResource\Pages;
use App\Filament\Portal\Resources\TimeRegistrationResource\RelationManagers;
use App\Models\TimeRegistration;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TimeRegistrationResource extends Resource
{
    protected static ?string $model = TimeRegistration::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\DatePicker::make('date')
                    ->required(),
                Forms\Components\TimePicker::make('start_time')
                    ->required(),
                Forms\Components\TimePicker::make('end_time')
                    ->required(),
                Forms\Components\TextInput::make('breaktime_minutes')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('mileage')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('description')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('date')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('start_time')
                    ->time(),
                Tables\Columns\TextColumn::make('end_time')
                    ->time(),
                Tables\Columns\TextColumn::make('breaktime_minutes')
                    ->numeric(),
                Tables\Columns\TextColumn::make('mileage')
                    ->numeric(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListTimeRegistrations::route('/'),
            'create' => Pages\CreateTimeRegistration::route('/create'),
            'edit' => Pages\EditTimeRegistration::route('/{record}/edit'),
        ];
    }
}
