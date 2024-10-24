<?php

use Indra\RevisorFilament\Tests\Models\Page;
use Indra\RevisorFilament\Tests\Resources\PageResource\Pages\ListPages;

use function Pest\Livewire\livewire;

it('renders correct publisher information', function () {
    $page = Page::create(['title' => 'page']);

    livewire(ListPages::class)
        ->assertTableColumnStateSet('publish_info', '-', $page);

    $page->publish();

    livewire(ListPages::class)
        ->assertTableColumnStateSet('publish_info', 'By ' . $page->publisher_name, $page);
});
