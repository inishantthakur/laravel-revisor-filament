<?php

namespace Indra\RevisorFilament\Tests\Resources;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use Indra\RevisorFilament\Filament\ListVersionsTableAction;
use Indra\RevisorFilament\Filament\PublishedStatusTableColumn;
use Indra\RevisorFilament\Filament\PublishTableAction;
use Indra\RevisorFilament\Filament\UnpublishTableAction;
use Indra\RevisorFilament\Tests\Resources\PageResource\Pages\EditPage;
use Indra\RevisorFilament\Tests\Resources\PageResource\Pages\ListPages;
use Indra\RevisorFilament\Tests\Resources\PageResource\Pages\ListPageVersions;
use Indra\RevisorFilament\Tests\Resources\PageResource\Pages\ViewPageVersion;

// use LiveSource\Chord\Filament\Actions\CreateChildPageTableAction;
// use Livesource\Chord\Filament\Actions\PublishBulkAction;
// use LiveSource\Chord\Filament\Actions\PublishTableAction;
// use Livesource\Chord\Filament\Actions\UnpublishBulkAction;
// use LiveSource\Chord\Filament\Actions\UnpublishTableAction;
// use LiveSource\Chord\Models\ChordPage;

class PageResource extends Resource
{
    protected static ?string $model = \Indra\RevisorFilament\Tests\Models\Page::class;

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
                Tables\Columns\TextColumn::make('id')
                    ->toggleable()
                    ->toggledHiddenByDefault(),
                Tables\Columns\TextColumn::make('title')
                    ->searchable(),
                PublishedStatusTableColumn::make('published_status'),
                Tables\Columns\TextColumn::make('publisher.name')
                    ->label('Published')
                    ->prefix('By: ')
                    ->description(fn (Model $record) => 'On: ' . $record->published_at)
                    ->placeholder('-'),
            ])
            ->configure()
            ->filters([
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    EditAction::make(),
                    PublishTableAction::make(),
                    UnpublishTableAction::make(),
                    ListVersionsTableAction::make(),
                    // Tables\Actions\Action::make('versions')
                    //     ->label('History')
                    //     ->url(fn (ChordPage $record) => PageResource::getUrl('versions', ['record' => $record->{$record->getRouteKeyName()}]))
                    //     ->icon('heroicon-o-clock'),
                    // Tables\Actions\Action::make('view_published')
                    //     ->label('View Published')
                    //     ->url(fn (ChordPage $record) => $record->getLink(true))
                    //     ->openUrlInNewTab()
                    //     ->icon('heroicon-o-arrow-top-right-on-square')
                    //     ->hidden(fn (ChordPage $record) => ! $record->is_published),
                    // Tables\Actions\Action::make('view_revision')
                    //     ->label('View Revision')
                    //     ->url(fn (ChordPage $record) => $record->getLink(true, $record->id))
                    //     ->openUrlInNewTab()
                    //     ->icon('heroicon-o-arrow-top-right-on-square')
                    //     ->hidden(fn (ChordPage $record) => $record->isPublished()),
                    // Tables\Actions\ActionGroup::make([
                    //     CreateChildPageTableAction::make(),
                    //     PublishTableAction::make(),
                    //     UnpublishTableAction::make(),
                    // ])->dropdown(false),
                ]),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    // PublishBulkAction::make(),
                    // UnpublishBulkAction::make(),
                    // Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function versionsTable(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('version_number')->label('Version #'),
                Tables\Columns\TextColumn::make('title'),
                Tables\Columns\IconColumn::make('is_current')->boolean(),
                Tables\Columns\IconColumn::make('is_published')->boolean(),
                // Tables\Columns\TextColumn::make('publisher.name')
                //     ->label('Published')
                //     ->prefix('By: ')
                //     ->description(fn (ChordPage $record) => 'On: '.$record->published_at),
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    // Tables\Actions\Action::make('view')
                    //     ->label(fn (Model $record) => $record->is_current ? 'Edit' : 'View')
                    //     ->icon(fn (Model $record) => $record->is_current ? 'heroicon-o-pencil' : 'heroicon-o-eye')
                    //     ->url(
                    //         fn (Model $record) => $record->is_current ?
                    //             static::getUrl('edit', ['record' => $record->record_id]) :
                    //             static::getUrl('version', [
                    //                 'record' => $record->record_id,
                    //                 'version' => $record->id,
                    //             ])
                    //     ),
                    // Tables\Actions\Action::make('restore')
                    //     ->action(function (ChordPage $record, Tables\Actions\Action $action) {
                    //         $record->restoreDraftToThisVersion();
                    //         $action->success();
                    //     })
                    //     ->requiresConfirmation()
                    //     ->successNotificationTitle('Page version restored as Draft')
                    //     ->icon('heroicon-o-arrow-path'),
                    Tables\Actions\DeleteAction::make(),
                ]),
            ]);
    }

    // public static function getRelations(): array
    // {
    //     return [
    //         //RevisionsRelationManager::class,
    //     ];
    // }

    public static function getPages(): array
    {
        return [
            'index' => ListPages::route('/'),
            'edit' => EditPage::route('/{record}/edit'),
            'versions' => ListPageVersions::route('/{record?}/versions'),
            'view_version' => ViewPageVersion::route('/{record}/version/{version}'),
        ];
    }
}
