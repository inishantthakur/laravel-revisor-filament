<?php

declare(strict_types=1);

namespace Indra\RevisorFilament\Filament;

use Filament\Actions\Action;
use Illuminate\Database\Eloquent\Model;
use Indra\Revisor\Contracts\HasRevisor;

class UnpublishAction extends Action
{
    public function setUp(): void
    {
        parent::setUp();

        $this
            ->name('unpublish')
            ->label('Unpublish')
            ->hidden(fn (Model&HasRevisor $record) => ! $record->isPublished())
            ->successNotificationTitle('Unpublished')
            ->action(function (Model&HasRevisor $record) {
                $record->unpublish();
                $this->success();
            });
    }
}
