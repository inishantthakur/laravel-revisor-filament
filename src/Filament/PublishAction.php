<?php

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
            ->label('Publish')
            ->hidden(fn (Model & HasRevisor $record) => $record->isPublished() && ! $record->isRevised())
            ->successNotificationTitle('Published')
            ->action(function (Model & HasRevisor $record) {
                $record->publish();
                $this->success();
            });
    }
}
