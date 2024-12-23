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
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;

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
                    TextColumn::make('work_hours')
                    ->label('Werkuren')
                    ->visibleFrom('md'),
                TextColumn::make('breaktime_minutes')
                    ->label('Pauzetijd (minuten)')
                    ->numeric()
                    ->visibleFrom('md'),
                    TextColumn::make('work_duration')
                    ->label('Werkduur')
                    ->visibleFrom('md'),
                TextColumn::make('mileage')
                    ->label('Kilometerstand')
                    ->numeric()
                    ->visibleFrom('md'),
            ])
            ->filters([
                Filter::make('date_from')
                    ->form([
                        Forms\Components\DatePicker::make('date_from')
                            ->label('Datum vanaf'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['date_from'],
                                fn(Builder $query, $date): Builder => $query->whereDate('date', '>=', $date),
                            );
                    })->indicateUsing(function (array $data): ?string {
                        if (! $data['date_from']) {
                            return null;
                        }

                        return 'Datum vanaf ' . Carbon::parse($data['date_from'])->format('d-m-Y');
                    }),
                Filter::make('date_to')
                    ->form([
                        Forms\Components\DatePicker::make('date_to')
                            ->label('Datum tot'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['date_to'],
                                fn(Builder $query, $date): Builder => $query->whereDate('date', '<=', $date),
                            );
                    })->indicateUsing(function (array $data): ?string {
                        if (! $data['date_to']) {
                            return null;
                        }

                        return 'Datum tot ' . Carbon::parse($data['date_to'])->format('d-m-Y');
                    }),
                SelectFilter::make('user_id')
                    ->label('Werknemer')
                    ->relationship('user', 'name')
                    ->placeholder('Iedereen'),
            ], layout: FiltersLayout::AboveContentCollapsible)
            ->filtersTriggerAction(
                fn(Action $action) => $action
                    ->button()
                    ->icon('heroicon-o-adjustments-horizontal')
                    ->label('Filters')
            )
            ->actions([
                // Tables\Actions\EditAction::make()
            ])
            ->recordUrl(
                fn(TimeRegistration $record): string => ViewTimeRegistration::getUrl(['record' => $record->id])
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
