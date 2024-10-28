<?php

declare(strict_types=1);

namespace Indra\RevisorFilament\Filament;

use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Model;
use Indra\Revisor\Contracts\HasRevisor;

class PublishInfoColumn extends TextColumn
{
    protected function setUp(): void
    {
        $this
            ->label('Published')
            ->getStateUsing(function (Model&HasRevisor $record) {
                return $record->publisher_name ? 'By '.$record->publisher_name : '-';
            })
            ->description(function (Model $record) {
                return $record->{config('revisor.publishing.table_columns.published_at')};
            })
            ->placeholder('-');
    }
}
