<?php

declare(strict_types = 1);

namespace App\Filament\Admin\Resources\Exceptions;

use App\Filament\Admin\Resources\Exceptions\Pages\ListExceptions;
use App\Filament\Admin\Resources\Exceptions\Schemas\ExceptionForm;
use App\Filament\Admin\Resources\Exceptions\Tables\ExceptionsTable;
use App\Models\Exception;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class ExceptionResource extends Resource
{
    protected static ?string $model = Exception::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBugAnt;

    protected static ?string $recordTitleAttribute = 'exception_class';

    public static function getGloballySearchableAttributes(): array
    {
        return ['exception_class', 'message', 'error_id', 'correlation_id', 'request_id'];
    }

    /** @param Exception $record */
    public static function getGlobalSearchResultDetails(Model $record): array
    {
        return [
            'Error ID' => $record->error_id,
            'User' => $record->user->name ?? 'N/A',
            'Tenant' => $record->tenant->name ?? 'N/A',
        ];
    }

    public static function canCreate(): bool
    {
        return false;
    }

    public static function canEdit(Model $record): bool
    {
        return false;
    }

    public static function canDelete(Model $record): bool
    {
        return false;
    }

    public static function infolist(Schema $schema): Schema
    {
        return ExceptionForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ExceptionsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListExceptions::route('/'),
        ];
    }
}
