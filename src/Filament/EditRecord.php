<?php

namespace Indra\RevisorFilament\Filament;

use Filament\Resources\Pages\EditRecord as FilamentEditRecord;

class EditRecord extends FilamentEditRecord
{
    protected function getFormActions(): array
    {
        return [
            $this->getSaveFormAction(),
            ...$this->getRevisorActions(),
            $this->getCancelFormAction(),
        ];
    }

    public function getRevisorActions(): array
    {
        return [
            PublishAction::make(),
            UnpublishAction::make(),
        ];
    }
}
