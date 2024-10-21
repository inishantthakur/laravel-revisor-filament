<?php

use Indra\RevisorFilament\Tests\Resources\PageResource;

it('can render page', function () {
    $this->get(PageResource::getUrl('index'))->assertSuccessful();
});
