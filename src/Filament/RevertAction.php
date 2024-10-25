<?php

namespace Indra\RevisorFilament\Filament;

use Filament\Actions\Action;
use Illuminate\Database\Eloquent\Model;
use Indra\Revisor\Contracts\HasRevisor;

class RevertAction extends Action
{
    protected ?Model $draftRecord = null;

    public static function getDefaultName(): ?string
    {
        return 'revert';
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this
            ->action(function (HasRevisor $record, Action $action) {
                dd('here');
                //                $record->revertDraftToThisVersion();
                //                $action->success();
            })
//            /->hidden(fn () => $this->getRecord()->is_current)
//            ->record(function (\Filament\Pages\Page $livewire) {
//                $resource = $livewire->getResource();
//                $model = $resource::getModel();
//
//                return $model::find($livewire->draft_id);
//            })
            ->requiresConfirmation()
            ->successNotificationTitle(fn (HasRevisor $record) => "Record reverted to version $record->version_number")
            ->icon('heroicon-o-arrow-path');

        //            ->successRedirectUrl(function (HasRevisor $record, Page $livewire) {
        //                $resource = $livewire->getResource();
        //                if ($resource::hasPage('edit')) {
        //                    return $resource::getUrl('edit', [
        //                        'record' => $record->{config('revisor.versioning.table_columns.record_id')}
        //                    ]);
        //                }
        //
        //                if ($resource::hasPage('view')) {
        //                    return $resource::getUrl('view', [
        //                        'record' => $record->{config('revisor.versioning.table_columns.record_id')}
        //                    ]);
        //                }
        //
        //                return false;
        //            });
    }

    public function getRecord(): ?Model
    {
        if (! $this->draftRecord) {
            $this->draftRecord = $this->livewire->getResource()::getModel()::find($this->livewire->draft_id);
        }

        return $this->draftRecord;
    }
}
