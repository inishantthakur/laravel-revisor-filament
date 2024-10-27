<?php

namespace Indra\RevisorFilament\Tests\Resources;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Indra\RevisorFilament\Filament\ListVersionsTableAction;
use Indra\RevisorFilament\Filament\PublishBulkAction;
use Indra\RevisorFilament\Filament\PublishInfoColumn;
use Indra\RevisorFilament\Filament\PublishTableAction;
use Indra\RevisorFilament\Filament\StatusColumn;
use Indra\RevisorFilament\Filament\UnpublishBulkAction;
use Indra\RevisorFilament\Filament\UnpublishTableAction;
use Indra\RevisorFilament\Tests\Models\Page;
use Indra\RevisorFilament\Tests\Resources\PageResource\Pages\EditPage;
use Indra\RevisorFilament\Tests\Resources\PageResource\Pages\ListPages;
use Indra\RevisorFilament\Tests\Resources\PageResource\Pages\ListPageVersions;
use Indra\RevisorFilament\Tests\Resources\PageResource\Pages\ViewPageVersion;

class PageResource extends Resource
{
    protected static ?string $model = Page::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static ?string $modelLabel = 'Page';

    protected static ?string $navigationGroup = 'Revisor';

    protected static ?string $recordTitleAttribute = 'title';

    public static function form(Form $form): Form
    {
        $form->schema([
            TextInput::make('title')->required(),
        ]);

        return $form;
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title'),
                StatusColumn::make('status'),
                PublishInfoColumn::make('publish_info'),
            ])
            ->configure()
            ->filters([
            ])
            ->actions([
                ActionGroup::make([
                    EditAction::make(),
                    DeleteAction::make(),
                    ActionGroup::make([
                        PublishTableAction::make(),
                        UnpublishTableAction::make(),
                        ListVersionsTableAction::make(),
                    ])->dropdown(false),
                ]),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    PublishBulkAction::class::make(),
                    UnpublishBulkAction::class::make(),
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListPages::route('/'),
            'edit' => EditPage::route('/{record}/edit'),
            'versions' => ListPageVersions::route('/{record?}/versions'),
            'view_version' => ViewPageVersion::route('/{record}/versions/{version}'),
        ];
    }
}
