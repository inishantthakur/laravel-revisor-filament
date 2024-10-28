<?php

declare(strict_types=1);

namespace Indra\RevisorFilament\Filament;

use Filament\Actions\Action;
use Illuminate\Database\Eloquent\Model;
use Indra\Revisor\Contracts\HasRevisor;

class PublishAction extends Action
{
    public function setUp(): void
    {
        parent::setUp();

        $this
            ->name('publish')
            ->label(fn(Model & HasRevisor $record) => $record->isPublished() ? 'Publish changes' : 'Publish')
            ->hidden(fn(Model & HasRevisor $record) => $record->isPublished() && !$record->isRevised())
            ->successNotificationTitle('Published')
            ->action(function (Model & HasRevisor $record) {
                $record->publish();
                $this->success();
            });
    }
}
