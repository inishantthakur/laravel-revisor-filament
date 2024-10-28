<?php

declare(strict_types=1);

namespace Indra\RevisorFilament\Filament;

use Filament\Resources\Pages\Concerns\InteractsWithRecord;
use Filament\Resources\Pages\ListRecords;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class ListVersions extends ListRecords
{
    use InteractsWithRecord;

    public function mount(int | string | null $record = null): void
    {
        if ($record === null) {
            throw new \InvalidArgumentException('Record is required');
        }

        $this->record = $this->resolveRecord($record);

        $this->authorizeAccess();
    }

    protected function authorizeAccess(): void
    {
        abort_unless(static::getResource()::canView($this->getRecord()), 403);
    }

    public function getHeading(): string
    {
        return static::$resource::getRecordTitle($this->record) . ' History';
    }

    public function table(Table $table): Table
    {
        $parent = $this->getRecord()->getKey();

        return $table
            ->columns([
                TextColumn::make('title'),
                TextColumn::make('version_number')
                    ->label('Version #'),
                IconColumn::make('is_current')
                    ->label('Current')
                    ->boolean(),
                IconColumn::make('is_published')
                    ->label('Published')
                    ->boolean(),
            ])
            ->bulkActions([
                DeleteBulkAction::make(),
            ])
            ->actions([
                ActionGroup::make([
                    ViewVersionTableAction::make('view'),
                    RevertTableAction::make(),
                    DeleteAction::make(),
                ]),
            ])->modifyQueryUsing(function (Builder $query) use ($parent): Builder {
                // @phpstan-ignore-next-line
                return $query->withVersionContext()
                    ->where('record_id', $parent);
            })->recordAction('view');
    }

    public function getBreadcrumb(): ?string
    {
        return static::$breadcrumb ?? 'History';
    }
}
