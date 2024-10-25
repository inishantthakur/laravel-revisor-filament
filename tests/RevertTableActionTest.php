<?php

use Indra\RevisorFilament\Filament\RevertTableAction;
use Indra\RevisorFilament\Tests\Models\Page;
use Indra\RevisorFilament\Tests\Resources\PageResource\Pages\ListPageVersions;

use function Pest\Livewire\livewire;

it('only shows on versions that are not current and can be reverted', function () {
    $page = Page::create(['title' => 'page'])->publish();
    $page->refresh();
    $version1 = $page->currentVersionRecord;

    $page->update(['title' => 'updated page']);
    $version2 = $page->currentVersionRecord;

    livewire(ListPageVersions::class, ['record' => $page->id])
        ->assertTableActionHidden(RevertTableAction::class, $version2)
        ->assertTableActionVisible(RevertTableAction::class, $version1->refresh())
        ->callTableAction('revert', $version1);

    $this->expect($page->refresh()->title)->toBe('page');
});
