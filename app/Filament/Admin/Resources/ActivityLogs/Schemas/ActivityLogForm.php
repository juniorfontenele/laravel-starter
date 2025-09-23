<?php

declare(strict_types = 1);

namespace App\Filament\Admin\Resources\ActivityLogs\Schemas;

use App\Enums\LogLevel;
use App\Enums\LogType;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Enums\FontWeight;

class ActivityLogForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informações Principais')
                    ->description('Detalhes da atividade registrada')
                    ->icon('heroicon-o-clipboard-document-list')
                    ->columns(3)
                    ->columnSpanFull()
                    ->collapsible()
                    ->components([
                        TextEntry::make('action')
                            ->label('Ação')
                            ->badge()
                            ->color('primary')
                            ->columnSpan(2)
                            ->weight(FontWeight::Bold),
                        TextEntry::make('created_at')
                            ->label('Data/Hora')
                            ->dateTime('d/m/Y H:i:s', getUserTimezone())
                            ->badge()
                            ->color('info')
                            ->icon('heroicon-o-calendar'),
                        TextEntry::make('type')
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
                        TextEntry::make('level')
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
                        TextEntry::make('user.name')
                            ->label('Usuário')
                            ->placeholder('Sistema')
                            ->badge()
                            ->color('primary')
                            ->icon('heroicon-o-user'),
                        TextEntry::make('description')
                            ->label('Descrição')
                            ->columnSpanFull()
                            ->placeholder('Sem descrição'),
                    ]),

                Section::make('Contexto e Relacionamentos')
                    ->description('Informações sobre a entidade e relacionamentos')
                    ->icon('heroicon-o-link')
                    ->columns(3)
                    ->columnSpanFull()
                    ->collapsed()
                    ->components([
                        TextEntry::make('tenant.name')
                            ->label('Tenant')
                            ->placeholder('Não identificado')
                            ->badge()
                            ->color('primary')
                            ->icon('heroicon-o-building-office'),
                        TextEntry::make('subject_type')
                            ->label('Tipo da Entidade')
                            ->placeholder('Nenhuma entidade')
                            ->badge()
                            ->color('gray')
                            ->formatStateUsing(
                                fn (?string $state): string => $state ? class_basename($state) : 'N/A'
                            ),
                        TextEntry::make('subject_id')
                            ->label('ID da Entidade')
                            ->placeholder('N/A')
                            ->badge()
                            ->color('gray'),
                    ]),

                Section::make('Metadados')
                    ->description('Dados estruturados da atividade')
                    ->icon('heroicon-o-code-bracket')
                    ->columnSpanFull()
                    ->collapsed()
                    ->components([
                        TextEntry::make('metadata')
                            ->label('Dados JSON')
                            ->columnSpanFull()
                            ->placeholder('Nenhum metadado')
                            ->formatStateUsing(function ($state): string {
                                if (! $state) {
                                    return 'Nenhum metadado disponível';
                                }

                                // Se já é array, use diretamente
                                if (is_array($state)) {
                                    return json_encode($state, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
                                }

                                // Se é string, tente decodificar primeiro
                                if (is_string($state)) {
                                    $decoded = json_decode($state, true);

                                    if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                                        return json_encode($decoded, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
                                    }

                                    // Se não conseguir decodificar, retorne a string original
                                    return $state;
                                }

                                return 'Dados inválidos';
                            })
                            ->copyable()
                            ->copyableState(function ($state): string {
                                if (! $state) {
                                    return '';
                                }

                                // Se já é array, use diretamente
                                if (is_array($state)) {
                                    return json_encode($state, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
                                }

                                // Se é string, tente decodificar primeiro
                                if (is_string($state)) {
                                    $decoded = json_decode($state, true);

                                    if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                                        return json_encode($decoded, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
                                    }

                                    return $state;
                                }

                                return '';
                            }),
                    ]),

                Section::make('IDs de Rastreamento')
                    ->description('Identificadores para rastreamento e depuração')
                    ->icon('heroicon-o-finger-print')
                    ->columns(2)
                    ->columnSpanFull()
                    ->collapsed()
                    ->visible(function ($record) {
                        $metadata = $record->metadata;

                        // Se é string, tente decodificar
                        if (is_string($metadata)) {
                            $metadata = json_decode($metadata, true);

                            if (json_last_error() !== JSON_ERROR_NONE) {
                                return false;
                            }
                        }

                        return is_array($metadata) && (
                            isset($metadata['request_id']) ||
                            isset($metadata['correlation_id'])
                        );
                    })
                    ->components([
                        TextEntry::make('metadata.request_id')
                            ->label('ID da Requisição')
                            ->placeholder('Não informado')
                            ->badge()
                            ->color('info')
                            ->copyable()
                            ->getStateUsing(function ($record) {
                                $metadata = $record->metadata;

                                if (is_string($metadata)) {
                                    $metadata = json_decode($metadata, true);

                                    if (json_last_error() !== JSON_ERROR_NONE) {
                                        return null;
                                    }
                                }

                                return is_array($metadata) ? ($metadata['request_id'] ?? null) : null;
                            }),
                        TextEntry::make('metadata.correlation_id')
                            ->label('ID de Correlação')
                            ->placeholder('Não informado')
                            ->badge()
                            ->color('info')
                            ->copyable()
                            ->getStateUsing(function ($record) {
                                $metadata = $record->metadata;

                                if (is_string($metadata)) {
                                    $metadata = json_decode($metadata, true);

                                    if (json_last_error() !== JSON_ERROR_NONE) {
                                        return null;
                                    }
                                }

                                return is_array($metadata) ? ($metadata['correlation_id'] ?? null) : null;
                            }),
                    ]),
            ]);
    }
}
