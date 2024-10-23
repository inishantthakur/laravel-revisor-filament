<?php

namespace Indra\RevisorFilament\Filament;

use Filament\Resources\Pages\Concerns\InteractsWithRecord;
use Filament\Resources\Pages\ListRecords;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class ListVersions extends ListRecords
{
    use InteractsWithRecord;

    public function mount(): void
    {
        $this->record = $this->resolveRecord(request()->record);

        $this->authorizeAccess();
    }

    protected function authorizeAccess(): void
    {
        abort_unless(static::getResource()::canView($this->getRecord()), 403);
    }

    public function getHeading(): string
    {
        return static::$resource::getRecordTitle($this->record).' Versions';
    }

    public function table(Table $table): Table
    {
        $parent = $this->getRecord()->getKey();

        return $table
            ->columns([
                TextColumn::make('version_number')->label('Version #'),
                TextColumn::make('title'),
                IconColumn::make('is_current')->boolean(),
                IconColumn::make('is_published')->boolean(),
            ])
            ->actions([
                ActionGroup::make([
                    ViewVersionTableAction::make(),
                    RestoreTableAction::make(),
                    //->record(fn (Model & HasRevisor $record) => $record)
                    //->hidden(fn (Model & HasRevisor $record) => $record->is_current),
                    //                    EditAction::make()->record(fn (Model & HasRevisor $record) => $record->draftRecord)
                    //                        ->hidden(fn (Model & HasRevisor $record) => ! $record->is_current),
                    //                    Action::make('view')
                    //                        ->label(fn (Model & HasRevisor $record) => $record->is_current ? 'Edit' : 'View')
                    //                        ->icon(fn (Model & HasRevisor $record) => $record->is_current ? 'heroicon-o-pencil' : 'heroicon-o-eye')
                    //                        ->url(
                    //                            fn (Model & HasRevisor $record) => $record->is_current ?
                    //                                static::getUrl('edit', ['record' => $record->record_id]) :
                    //                                static::getUrl('version', [
                    //                                    'record' => $record->record_id,
                    //                                    'version' => $record->id,
                    //                                ])
                    //                        ),
                    DeleteAction::make(),
                ]),
            ])->modifyQueryUsing(function (Builder $query) use ($parent): Builder {
                return $query->withVersionContext()->where('record_id', $parent);
            });
    }
}
