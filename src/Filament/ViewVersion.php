<?php

declare(strict_types=1);

namespace Indra\RevisorFilament\Filament;

use Filament\Resources\Pages\ViewRecord;
use Illuminate\Database\Eloquent\Model;
use Indra\Revisor\Facades\Revisor;

class ViewVersion extends ViewRecord
{
    public string | int | null $draft_id = null;

    public function getHeaderActions(): array
    {
        return [
            RevertAction::make('revert'),
        ];
    }

    public function mount(int | string $record, int | string | null $version = null): void
    {
        if (! $version) {
            abort(404);
        }
        $this->draft_id = $record;
        $this->record = $this->resolveRecord($version);

        $this->authorizeAccess();

        if (! $this->hasInfolist()) {
            $this->fillForm();
        }
    }

    protected function resolveRecord(int | string $key): Model
    {
        return Revisor::withVersionContext(fn () => parent::resolveRecord($key));
    }
}
