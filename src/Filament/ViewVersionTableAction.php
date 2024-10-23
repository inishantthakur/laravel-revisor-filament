<?php

namespace Indra\RevisorFilament\Filament;

use Filament\Actions\StaticAction;
use Filament\Resources\Pages\Page;
use Filament\Support\Facades\FilamentIcon;
use Filament\Tables\Actions\Action;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class ViewVersionTableAction extends Action
{
    public static function getDefaultName(): ?string
    {
        return 'view_version';
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->label(__('filament-actions::view.single.label'));
        $this->modalHeading(fn (): string => __(
            'filament-actions::view.single.modal.heading',
            ['label' => $this->getRecordTitle()]
        ));
        $this->modalSubmitAction(false);
        $this->modalCancelAction(fn (
            StaticAction $action
        ) => $action->label(__('filament-actions::view.single.modal.actions.close.label')));
        $this->color('gray');
        $this->icon(FilamentIcon::resolve('actions::view-action') ?? 'heroicon-m-eye');
        $this->disabledForm();
        $this->fillForm(function (Model $record, Table $table): array {
            if ($translatableContentDriver = $table->makeTranslatableContentDriver()) {
                $data = $translatableContentDriver->getRecordAttributesToArray($record);
            } else {
                $data = $record->attributesToArray();
            }

            if ($this->mutateRecordDataUsing) {
                $data = $this->evaluate($this->mutateRecordDataUsing, ['data' => $data]);
            }

            return $data;
        });

        $this->action(static function (): void {});

        $this->url(function (Model $record, Page $livewire) {
            $resource = $livewire->getResource();

            if (! $resource::hasPage('view_version')) {
                throw new \Exception("$resource does not have a view_version page defined on the Resource");
            }

            return $resource::getUrl('view_version', [
                'record' => $record->record_id,
                'version' => $record->{$record->getRouteKeyName()},
            ]);
        });
    }
}
