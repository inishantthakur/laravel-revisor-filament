<?php

use Indra\RevisorFilament\Tests\Models\Page;
use Indra\RevisorFilament\Tests\Resources\PageResource\Pages\ViewPageVersion;
use function Pest\Livewire\livewire;

it('only shows versions that are not current', function () {
    $page = Page::create(['title' => 'page']);
    $page->update(['title' => 'updated page']);

    livewire(ViewPageVersion::class, ['record' => $page->id, 'version' => 1])
        ->assertActionVisible('revert');

    livewire(ViewPageVersion::class, ['record' => $page->id, 'version' => 2])
        ->assertActionHidden('revert');
});

it('can revert to a version', function () {
    $page = Page::create(['title' => 'page']);
    $page->update(['title' => 'updated page']);

    livewire(ViewPageVersion::class, ['record' => $page->id, 'version' => 1])
        ->callAction('revert');

    expect($page->refresh()->title)->toBe('page');
});
