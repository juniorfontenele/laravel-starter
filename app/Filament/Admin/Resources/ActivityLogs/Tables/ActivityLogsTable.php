<?php

declare(strict_types = 1);

namespace App\Filament\Admin\Resources\ActivityLogs\Tables;

use App\Enums\LogLevel;
use App\Enums\LogType;
use App\Models\ActivityLog;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class ActivityLogsTable
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

                TextColumn::make('action')
                    ->label('Ação')
                    ->searchable()
                    ->sortable()
                    ->badge()
                    ->color('primary')
                    ->weight('bold'),

                TextColumn::make('type')
                    ->label('Tipo')
                    ->badge()
                    ->color(fn (LogType $state): string => match ($state) {
                        LogType::SYSTEM => 'info',
                        LogType::USER => 'success',
                    })
                    ->formatStateUsing(fn (LogType $state): string => match ($state) {
                        LogType::SYSTEM => 'Sistema',
                        LogType::USER => 'Usuário',
                    }),

                TextColumn::make('level')
                    ->label('Nível')
                    ->badge()
                    ->color(fn (LogLevel $state): string => match ($state) {
                        LogLevel::DEBUG => 'gray',
                        LogLevel::INFO => 'info',
                        LogLevel::NOTICE => 'primary',
                        LogLevel::WARNING => 'warning',
                        LogLevel::ERROR => 'danger',
                        LogLevel::CRITICAL => 'danger',
                        LogLevel::ALERT => 'danger',
                        LogLevel::EMERGENCY => 'danger',
                    })
                    ->formatStateUsing(fn (LogLevel $state): string => match ($state) {
                        LogLevel::DEBUG => 'Debug',
                        LogLevel::INFO => 'Info',
                        LogLevel::NOTICE => 'Notice',
                        LogLevel::WARNING => 'Warning',
                        LogLevel::ERROR => 'Error',
                        LogLevel::CRITICAL => 'Critical',
                        LogLevel::ALERT => 'Alert',
                        LogLevel::EMERGENCY => 'Emergency',
                    }),

                TextColumn::make('user.name')
                    ->label('Usuário')
                    ->placeholder('Sistema')
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

                TextColumn::make('subject_type')
                    ->label('Entidade')
                    ->searchable()
                    ->badge()
                    ->color('gray')
                    ->formatStateUsing(
                        fn (?string $state): string => $state ? class_basename($state) : 'N/A'
                    )
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('description')
                    ->label('Descrição')
                    ->limit(50)
                    ->tooltip(fn (ActivityLog $record): string => $record->description ?? '')
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('type')
                    ->label('Tipo')
                    ->options([
                        'system' => 'Sistema',
                        'user' => 'Usuário',
                    ]),

                SelectFilter::make('level')
                    ->label('Nível')
                    ->options([
                        LogLevel::DEBUG->value => 'Debug',
                        LogLevel::INFO->value => 'Info',
                        LogLevel::NOTICE->value => 'Notice',
                        LogLevel::WARNING->value => 'Warning',
                        LogLevel::ERROR->value => 'Error',
                        LogLevel::CRITICAL->value => 'Critical',
                        LogLevel::ALERT->value => 'Alert',
                        LogLevel::EMERGENCY->value => 'Emergency',
                    ]),

                SelectFilter::make('tenant_id')
                    ->label('Tenant')
                    ->relationship('tenant', 'name')
                    ->searchable()
                    ->preload(),

                SelectFilter::make('user_id')
                    ->label('Usuário')
                    ->relationship('user', 'name')
                    ->searchable()
                    ->preload(),

                Filter::make('action')
                    ->label('Ação')
                    ->schema([
                        TextInput::make('action')
                            ->label('Ação')
                            ->placeholder('Digite a ação...'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['action'],
                                fn (Builder $query, $action): Builder => $query->where('action', 'like', "%{$action}%"),
                            );
                    }),

                Filter::make('created_at')
                    ->label('Período')
                    ->indicateUsing(fn (array $data): ?string => ($data['created_from'] || $data['created_until']) ? "Período selecionado: {$data['created_from']} - {$data['created_until']}" : null)
                    ->schema([
                        DateTimePicker::make('created_from')
                            ->locale(getUserLocale())
                            ->displayFormat('d/m/Y H:i:s')
                            ->native(false)
                            ->label('De'),
                        DateTimePicker::make('created_until')
                            ->locale(getUserLocale())
                            ->displayFormat('d/m/Y H:i:s')
                            ->native(false)
                            ->label('Até'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['created_from'],
                                fn (Builder $query, $date): Builder => $query->where('created_at', '>=', fromUserDate($date)),
                            )
                            ->when(
                                $data['created_until'],
                                fn (Builder $query, $date): Builder => $query->where('created_at', '<=', fromUserDate($date)),
                            );
                    }),

                Filter::make('has_user')
                    ->label('Com usuário')
                    ->query(fn (Builder $query): Builder => $query->whereNotNull('user_id')),

                Filter::make('system_only')
                    ->label('Apenas sistema')
                    ->query(fn (Builder $query): Builder => $query->whereNull('user_id')),
            ])
            ->recordActions([
                ViewAction::make()
                    ->hiddenLabel()
                    ->icon(null),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    //
                ]),
            ])
            ->poll('30s');
    }
}
