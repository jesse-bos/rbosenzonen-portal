<?php

namespace App\Filament\Portal\Resources;

use App\Filament\Portal\Resources\TimeRegistrationResource\Pages;
use App\Filament\Portal\Resources\TimeRegistrationResource\RelationManagers;
use App\Models\TimeRegistration;
use Filament\Forms;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class TimeRegistrationResource extends Resource
{
    protected static ?string $model = TimeRegistration::class;

    protected static ?string $navigationIcon = 'heroicon-o-clock';

    protected static ?string $navigationLabel = 'Uren';

    protected static ?string $breadcrumb = 'Uren';

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->where('user_id', Auth::id());
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Group::make()
                    ->relationship('user')
                    ->schema([
                        TextInput::make('name')
                            ->default(Auth::user()->name)
                            ->label('Naam')
                            ->disabled(),
                    ]),
                Forms\Components\DatePicker::make('date')
                    ->label('Datum')
                    ->required(),
                Forms\Components\TimePicker::make('start_time')
                    ->label('Starttijd')
                    ->format('H:i')
                    ->seconds(false)
                    ->required(),
                Forms\Components\TimePicker::make('end_time')
                    ->required()
                    ->format('H:i')
                    ->seconds(false)
                    ->label('Eindtijd'),
                Forms\Components\TextInput::make('breaktime_minutes')
                    ->required()
                    ->label('Pauzetijd (minuten)')
                    ->numeric(),
                Forms\Components\TextInput::make('mileage')
                    ->required()
                    ->label('Kilometerstand')
                    ->numeric(),
                Forms\Components\Textarea::make('description')
                    ->required()
                    ->columnSpanFull()
                    ->label('Omschrijving')
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('date')
                    ->label('Datum')
                    ->date('d-m-Y')
                    ->sortable(),
                Tables\Columns\TextColumn::make('start_time')
                    ->label('Starttijd')
                    ->time('H:i'),
                Tables\Columns\TextColumn::make('end_time')
                    ->label('Eindtijd')
                    ->time('H:i'),
                Tables\Columns\TextColumn::make('breaktime_minutes')
                    ->label('Pauzetijd (minuten)')
                    ->numeric()
                    ->visibleFrom('md'),
                Tables\Columns\TextColumn::make('mileage')
                    ->label('Kilometerstand')
                    ->numeric()
                    ->visibleFrom('md'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->label('Bewerken'),
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