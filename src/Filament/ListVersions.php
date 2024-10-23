<?php

namespace Indra\RevisorFilament\Filament;

use Filament\Forms\Form;
use Filament\Resources\Pages\Concerns\InteractsWithRecord;
use Filament\Resources\Pages\ListRecords;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Indra\Revisor\Contracts\HasRevisor;

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
        return static::$resource::getRecordTitle($this->record) . ' Versions';
    }

    public function table(Table $table): Table
    {
        $parent = $this->getRecord()->getKey();

        return $table
            ->columns([
                TextColumn::make('version_number')
                    ->label('Version #'),
                TextColumn::make('title'),
                IconColumn::make('is_current')
                    ->label('Current')
                    ->boolean(),
                IconColumn::make('is_published')
                    ->label('Published')
                    ->boolean(),
            ])
            ->actions([
                ActionGroup::make([
                    ViewVersionTableAction::make(),
                    EditAction::make()
                        ->hidden(fn (Model & HasRevisor $record) => ! $record->is_current),
                    RestoreTableAction::make(),
                    DeleteAction::make(),
                ]),
            ])->modifyQueryUsing(function (Builder $query) use ($parent): Builder {
                return $query->withVersionContext()->where('record_id', $parent);
            });
    }

    protected function configureEditAction(EditAction $action): void
    {
        $resource = static::getResource();

        $action
            ->authorize(fn (Model $record): bool => $resource::canEdit($record->draftRecord))
            ->form(fn (Form $form): Form => $this->form($form->columns(2)));

        if ($resource::hasPage('edit')) {
            $action->url(fn (Model $record): string => $resource::getUrl('edit', ['record' => $record->record_id]));
        }
    }
}
