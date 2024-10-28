<?php

use Indra\RevisorFilament\Tests\Models\Page;
use Indra\RevisorFilament\Tests\Resources\PageResource\Pages\ListPages;

use function Pest\Livewire\livewire;

it('displays correct status', function () {
    $draft = Page::create(['title' => 'draft']);

    $published = Page::create(['title' => 'published']);
    $published->publish();

    $revised = Page::create(['title' => 'published']);
    $revised->publish();

    $this->travel(1)->seconds();

    $revised->update(['title' => 'revised']);

    // Check that the status column displays placeholder for draft
    livewire(ListPages::class)
        ->assertTableColumnStateSet('status', '["draft"]', $draft)
        ->assertTableColumnStateSet('status', '["published"]', $published)
        ->assertTableColumnStateSet('status', '["published","revised"]', $revised);
});
