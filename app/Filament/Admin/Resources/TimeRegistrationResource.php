<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\TimeRegistrationResource\Pages;
use App\Filament\Admin\Resources\TimeRegistrationResource\Pages\ViewTimeRegistration;
use App\Filament\Admin\Resources\TimeRegistrationResource\RelationManagers;
use App\Models\TimeRegistration;
use Filament\Forms;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TimeRegistrationResource extends Resource
{
    protected static ?string $model = TimeRegistration::class;

    protected static ?string $navigationIcon = 'heroicon-o-clock';

    protected static ?string $navigationLabel = 'Uren';

    protected static ?string $breadcrumb = 'Uren';

    public static function form(Form $form): Form
    {
        return $form
        ->schema([
            Group::make()
                ->relationship('user')
                ->schema([
                    TextInput::make('name')
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
                TextColumn::make('user.name')
                    ->label('Naam')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('date')
                    ->label('Datum')
                    ->date('d-m-Y')
                    ->sortable(),
                TextColumn::make('start_time')
                    ->label('Starttijd')
                    ->time('H:i')
                    ->visibleFrom('md'),
                TextColumn::make('end_time')
                    ->label('Eindtijd')
                    ->time('H:i')
                    ->visibleFrom('md'),
                TextColumn::make('breaktime_minutes')
                    ->label('Pauzetijd (minuten)')
                    ->numeric()
                    ->visibleFrom('md'),
                TextColumn::make('mileage')
                    ->label('Kilometerstand')
                    ->numeric()
                    ->visibleFrom('md'),
            ])
            ->filters([
                SelectFilter::make('user_id')
                    ->label('Naam')
                    ->relationship('user', 'name')
            ], layout: FiltersLayout::Modal)
            ->actions([
                // Tables\Actions\EditAction::make()
            ])
            ->recordUrl(
                fn (TimeRegistration $record): string => ViewTimeRegistration::getUrl(['record' => $record->id])
            )
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('date', 'desc');
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
            'view' => Pages\ViewTimeRegistration::route('/{record}'),
        ];
    }
}
