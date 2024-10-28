<?php

declare(strict_types=1);

namespace Indra\RevisorFilament\Tests;

use BladeUI\Heroicons\BladeHeroiconsServiceProvider;
use BladeUI\Icons\BladeIconsServiceProvider;
use Filament\Actions\ActionsServiceProvider;
use Filament\FilamentServiceProvider;
use Filament\Forms\FormsServiceProvider;
use Filament\Infolists\InfolistsServiceProvider;
use Filament\Notifications\NotificationsServiceProvider;
use Filament\Support\SupportServiceProvider;
use Filament\Tables\TablesServiceProvider;
use Filament\Widgets\WidgetsServiceProvider;
use Illuminate\Database\Eloquent\Factories\Factory;
use Indra\Revisor\Enums\RevisorContext;
use Indra\Revisor\RevisorServiceProvider;
use Indra\RevisorFilament\RevisorFilamentServiceProvider;
use Indra\RevisorFilament\Tests\Models\User;
use Indra\RevisorFilament\Tests\Providers\AdminPanelProvider;
use Livewire\LivewireServiceProvider;
use Orchestra\Testbench\Concerns\WithWorkbench;
use Orchestra\Testbench\TestCase as Orchestra;
use RyanChandler\BladeCaptureDirective\BladeCaptureDirectiveServiceProvider;

class TestCase extends Orchestra
{
    use WithWorkbench;

    protected function setUp(): void
    {
        parent::setUp();

        Factory::guessFactoryNamesUsing(
            fn (string $modelName) => 'Indra\\RevisorFilament\\Database\\Factories\\'.class_basename($modelName).'Factory'
        );

        $this->actingAs(User::factory()->create());
    }

    protected function getPackageProviders($app)
    {
        return [
            AdminPanelProvider::class,
            ActionsServiceProvider::class,
            BladeCaptureDirectiveServiceProvider::class,
            BladeHeroiconsServiceProvider::class,
            BladeIconsServiceProvider::class,
            FilamentServiceProvider::class,
            FormsServiceProvider::class,
            InfolistsServiceProvider::class,
            LivewireServiceProvider::class,
            NotificationsServiceProvider::class,
            SupportServiceProvider::class,
            TablesServiceProvider::class,
            WidgetsServiceProvider::class,
            RevisorServiceProvider::class,
            RevisorFilamentServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app)
    {
        config()->set('database.default', 'testing');
        config()->set('revisor.default_context', RevisorContext::Draft);
        config()->set('auth.providers.users.model', User::class);

        $migration = include __DIR__.'/database/create_test_tables.php';
        $migration->up();
    }
}
