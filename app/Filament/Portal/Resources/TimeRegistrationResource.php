<?php

namespace App\Filament\Portal\Resources;

use App\Filament\Portal\Resources\TimeRegistrationResource\Pages;
use App\Models\TimeRegistration;
use Filament\Forms;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\Action as ActionsAction;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;
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
                            ->default(Auth::user()?->name)
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
                    ->label('Pauzetijd')
                    ->suffix('minuten')
                    ->numeric(),
                Forms\Components\TextInput::make('mileage')
                    ->required()
                    ->label('Kilometerstand')
                    ->suffix('kilometer')
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
                TextColumn::make('date')
                    ->label('Datum')
                    ->date('d-m-Y (l)')
                    ->weight('bold')
                    ->sortable(),
                TextColumn::make('work_hours')
                    ->label('Werkuren'),
                TextColumn::make('breaktime_minutes')
                    ->label('Pauzetijd')
                    ->numeric()
                    ->suffix(' minuten')
                    ->visibleFrom('md'),
                TextColumn::make('work_duration')
                    ->label('Werkduur')
                    ->visibleFrom('md'),
                TextColumn::make('mileage')
                    ->label('Kilometerstand')
                    ->numeric()
                    ->visibleFrom('md'),
            ])
            ->filters(
                [
                    SelectFilter::make('date')
                        ->label('Maand')
                        ->options([
                            '01' => 'Januari',
                            '02' => 'Februari',
                            '03' => 'Maart',
                            '04' => 'April',
                            '05' => 'Mei',
                            '06' => 'Juni',
                            '07' => 'Juli',
                            '08' => 'Augustus',
                            '09' => 'September',
                            '10' => 'Oktober',
                            '11' => 'November',
                            '12' => 'December',
                        ])
                        ->query(function ($query, array $data) {
                            if (! $month = Arr::get($data, 'value')) {
                                return $query;
                            };

                            return $query->whereMonth('date', $month);
                        })
                ],
                layout: FiltersLayout::AboveContent
            )->filtersTriggerAction(
                fn(ActionsAction $action) => $action
                    ->button()
                    ->icon('heroicon-o-adjustments-horizontal')
                    ->label('Filters')
            )
            ->actions([
                ActionGroup::make([
                    Tables\Actions\EditAction::make()
                        ->label('Bewerken'),
                    Tables\Actions\DeleteAction::make()
                        ->label('Verwijderen'),
                ])->iconButton()
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
        ];
    }
}
