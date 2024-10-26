<?php

namespace App\Filament\Portal\Resources;

use App\Filament\Portal\Resources\TimeRegistrationResource\Pages;
use App\Models\TimeRegistration;
use Filament\Actions\DeleteAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TimePicker;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Actions\Action as ActionsAction;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
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
                DatePicker::make('date')
                    ->label('Datum')
                    ->required(),
                TimePicker::make('start_time')
                    ->label('Starttijd')
                    ->format('H:i')
                    ->seconds(false)
                    ->required(),
                TimePicker::make('end_time')
                    ->required()
                    ->format('H:i')
                    ->seconds(false)
                    ->label('Eindtijd'),
                TextInput::make('breaktime_minutes')
                    ->required()
                    ->label('Pauzetijd')
                    ->suffix('minuten')
                    ->numeric(),
                TextInput::make('mileage')
                    ->required()
                    ->label('Kilometerstand')
                    ->suffix('kilometer')
                    ->numeric(),
                Textarea::make('description')
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
                    Filter::make('date_from')
                        ->form([
                            DatePicker::make('date_from')
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
                            DatePicker::make('date_to')
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
                        })
                ],
                layout: FiltersLayout::AboveContentCollapsible
            )->filtersTriggerAction(
                fn(ActionsAction $action) => $action
                    ->button()
                    ->icon('heroicon-o-adjustments-horizontal')
                    ->label('Filters')
            )
            ->actions([
                ActionGroup::make([
                    EditAction::make()
                        ->label('Bewerken'),
                    DeleteAction::make()
                        ->label('Verwijderen'),
                ])->iconButton()
            ])
            ->defaultSort('date', 'desc')
            ->defaultPaginationPageOption(5);
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
