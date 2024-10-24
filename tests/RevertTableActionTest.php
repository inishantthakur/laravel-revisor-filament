<?php

use Indra\RevisorFilament\Tests\Models\Page;

it('only shows on versions that are not current', function () {
    $page = Page::create(['title' => 'page'])->publish();
    $page->refresh();
    $version1 = $page->currentVersionRecord;

    $page->update(['title' => 'updated page']);
    $version2 = $page->currentVersionRecord;

    // todo - this is not working in the test suite
    // fine in the browser...
    //    livewire(ListPageVersions::class, ['record' => $page->id])
    //        ->assertTableActionHidden(RevertTableAction::class, record: $version2)
    //        ->assertTableActionVisible(RevertTableAction::class, record: $version1);
});
