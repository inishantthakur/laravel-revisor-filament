<?php

declare(strict_types=1);

namespace Indra\RevisorFilament\Filament;

use Filament\Resources\Pages\ViewRecord;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Model;

class ViewVersion extends ViewRecord
{
    public int | string | null $version;

    protected ?Model $versionRecord = null;

    public function getHeaderActions(): array
    {
        return [
            RevertAction::make('revert'),
        ];
    }

    public function getRecordTitle(): string | Htmlable
    {
        $resource = static::getResource();

        if (! $resource::hasRecordTitle()) {
            return $resource::getTitleCaseModelLabel();
        }

        return $resource::getRecordTitle($this->getVersionRecord());
    }

    public function mount(int | string $record, int | string | null $version = null): void
    {
        parent::mount($record);

        $this->versionRecord = $this->resolveVersion($version);
    }

    protected function resolveVersion(int | string $key): Model
    {
        return $this->getRecord()->versionRecords()->findOrFail($version);
    }

    public function getVersionRecord(): Model
    {
        if (! $this->versionRecord) {
            $this->versionRecord = $this->resolveVersion($this->version);
        }

        return $this->versionRecord;
    }

    protected function fillForm(): void
    {
        $this->fillFormWithDataAndCallHooks($this->getVersionRecord());
    }
}
