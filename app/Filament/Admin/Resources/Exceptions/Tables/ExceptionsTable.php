<?php

declare(strict_types = 1);

namespace App\Filament\Admin\Resources\Exceptions\Tables;

use App\Models\Exception;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class ExceptionsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->columns([
                TextColumn::make('created_at')
                    ->label('Data/Hora')
                    ->dateTime('d/m/Y H:i:s', getUserTimezone())
                    ->sortable()
                    ->badge()
                    ->color('info'),

                TextColumn::make('exception_class')
                    ->label('Classe da Exceção')
                    ->searchable()
                    ->sortable()
                    ->badge()
                    ->tooltip(fn (Exception $record): string => "Error ID: {$record->error_id}")
                    ->copyable()
                    ->copyableState(fn (Exception $record): string => $record->error_id)
                    ->color('danger'),

                TextColumn::make('message')
                    ->label('Mensagem')
                    ->searchable()
                    ->limit(30),

                TextColumn::make('status_code')
                    ->label('Status HTTP')
                    ->numeric()
                    ->sortable()
                    ->badge()
                    ->color('info'),

                TextColumn::make('user.name')
                    ->label('Usuário')
                    ->placeholder('Não identificado')
                    ->searchable()
                    ->badge()
                    ->color('primary')
                    ->icon('heroicon-o-user'),

                TextColumn::make('tenant.name')
                    ->label('Tenant')
                    ->placeholder('Não identificado')
                    ->searchable()
                    ->badge()
                    ->color('primary')
                    ->icon('heroicon-o-building-office'),

                IconColumn::make('is_retryable')
                    ->label('Pode Retentar')
                    ->boolean()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('danger'),

                TextColumn::make('error_id')
                    ->label('ID do Erro')
                    ->searchable()
                    ->badge()
                    ->color('gray')
                    ->copyable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('correlation_id')
                    ->label('ID de Correlação')
                    ->searchable()
                    ->badge()
                    ->color('info')
                    ->copyable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('request_id')
                    ->label('ID da Requisição')
                    ->searchable()
                    ->badge()
                    ->color('info')
                    ->copyable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('exception_class')
                    ->label('Classe da Exceção')
                    ->options(function () {
                        return Exception::query()
                            ->select('exception_class')
                            ->distinct()
                            ->orderBy('exception_class')
                            ->pluck('exception_class', 'exception_class')
                            ->toArray();
                    }),

                SelectFilter::make('status_code')
                    ->label('Status HTTP')
                    ->options([
                        '400' => '400 - Bad Request',
                        '401' => '401 - Unauthorized',
                        '403' => '403 - Forbidden',
                        '404' => '404 - Not Found',
                        '422' => '422 - Unprocessable Entity',
                        '500' => '500 - Internal Server Error',
                        '503' => '503 - Service Unavailable',
                    ]),

                TernaryFilter::make('is_retryable')
                    ->label('Pode Retentar')
                    ->placeholder('Todos')
                    ->trueLabel('Sim')
                    ->falseLabel('Não'),

                SelectFilter::make('user_id')
                    ->label('Usuário')
                    ->relationship('user', 'name')
                    ->searchable()
                    ->preload(),

                SelectFilter::make('tenant_id')
                    ->label('Tenant')
                    ->relationship('tenant', 'name')
                    ->searchable()
                    ->preload(),

                Filter::make('error_id')
                    ->label('ID do Erro')
                    ->indicateUsing(fn (array $data): ?string => $data['error_id'] ? "Error ID: {$data['error_id']}" : null)
                    ->schema([
                        TextInput::make('error_id')
                            ->label('ID do Erro')
                            ->placeholder('Digite o ID do erro...'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query->when(
                            $data['error_id'] ?? null,
                            fn (Builder $query, $value): Builder => $query->where('error_id', $value)
                        );
                    }),

                Filter::make('correlation_id')
                    ->label('ID de Correlação')
                    ->indicateUsing(fn (array $data): ?string => $data['correlation_id'] ? "Correlation ID: {$data['correlation_id']}" : null)
                    ->schema([
                        TextInput::make('correlation_id')
                            ->label('ID de Correlação')
                            ->placeholder('Digite o ID de correlação...'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query->when(
                            $data['correlation_id'] ?? null,
                            fn (Builder $query, $value): Builder => $query->where('correlation_id', $value)
                        );
                    }),

                Filter::make('request_id')
                    ->label('ID da Requisição')
                    ->indicateUsing(fn (array $data): ?string => $data['request_id'] ? "Request ID: {$data['request_id']}" : null)
                    ->schema([
                        TextInput::make('request_id')
                            ->label('ID da Requisição')
                            ->placeholder('Digite o ID da requisição...'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query->when(
                            $data['request_id'] ?? null,
                            fn (Builder $query, $value): Builder => $query->where('request_id', $value)
                        );
                    }),
            ])
            ->persistFiltersInSession()
            ->persistSearchInSession()
            ->persistColumnSearchesInSession()
            ->deferFilters(false)
            ->recordActions([
                ViewAction::make()
                    ->modalHeading('Detalhes da Exceção')
                    ->modalSubmitAction(false)
                    ->modalCancelActionLabel('Fechar')
                    ->hiddenLabel()
                    ->icon(null),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                ]),
            ]);
    }
}
