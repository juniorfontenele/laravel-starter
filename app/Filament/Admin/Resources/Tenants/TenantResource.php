<?php

declare(strict_types = 1);

namespace App\Filament\Admin\Resources\Tenants;

use App\Filament\Admin\Resources\Tenants\Pages\CreateTenant;
use App\Filament\Admin\Resources\Tenants\Pages\EditTenant;
use App\Filament\Admin\Resources\Tenants\Pages\ListTenants;
use App\Filament\Admin\Resources\Tenants\RelationManagers\HostsRelationManager;
use App\Filament\Admin\Resources\Tenants\Schemas\TenantForm;
use App\Filament\Admin\Resources\Tenants\Tables\TenantsTable;
use App\Models\Tenant;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class TenantResource extends Resource
{
    protected static ?string $model = Tenant::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBuildingOffice;

    protected static ?string $recordTitleAttribute = 'name';

    public static function getGloballySearchableAttributes(): array
    {
        return ['name', 'hosts.host'];
    }

    /** @param Tenant $record */
    public static function getGlobalSearchResultDetails(Model $record): array
    {
        return [
            __('Hosts') => implode(', ', $record->hosts->pluck('host')->toArray()),
        ];
    }

    public static function form(Schema $schema): Schema
    {
        return TenantForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return TenantsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            HostsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListTenants::route('/'),
            'create' => CreateTenant::route('/create'),
            'edit' => EditTenant::route('/{record}/edit'),
        ];
    }
}
