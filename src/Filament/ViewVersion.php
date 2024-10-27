<?php

declare(strict_types=1);

namespace Indra\RevisorFilament\Filament;

use Filament\Resources\Pages\ViewRecord;
use Illuminate\Database\Eloquent\Model;

class ViewVersion extends ViewRecord
{
    public int|string|null $version;

    protected ?Model $versionRecord = null;

    public function getHeaderActions(): array
    {
        return [
            RevertAction::make('revert'),
        ];
    }

    public function mount(int|string $record, int|string|null $version = null): void
    {
        parent::mount($record);

        $this->versionRecord = $this->resolveVersion($version);
    }

    protected function resolveVersion(int|string $id): Model
    {
        return $this->getRecord()->versionRecords()->findOrFail($id);
    }

    public function getVersionRecord(): Model
    {
        if (!$this->versionRecord) {
            $this->versionRecord = $this->resolveVersion($this->version);
        }

        return $this->versionRecord;
    }

    protected function fillForm(): void
    {
        $this->fillFormWithDataAndCallHooks($this->getVersionRecord());
    }

    public function getBreadcrumb(): string
    {
        return static::$breadcrumb ?? 'Version #'.$this->getVersionRecord()->version_number;
    }

    public function getHeading(): string
    {
        return $this->getResource()::getRecordTitle($this->getVersionRecord());
    }
}
