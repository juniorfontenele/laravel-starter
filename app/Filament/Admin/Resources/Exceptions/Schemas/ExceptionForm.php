<?php

declare(strict_types = 1);

namespace App\Filament\Admin\Resources\Exceptions\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Enums\FontWeight;
use Filament\Support\Enums\TextSize;

class ExceptionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informações Principais')
                    ->description('Detalhes básicos da exceção')
                    ->icon('heroicon-o-exclamation-triangle')
                    ->columns(3)
                    ->columnSpanFull()
                    ->collapsible()
                    ->components([
                        TextEntry::make('exception_class')
                            ->label('Classe da Exceção')
                            ->badge()
                            ->color('danger')
                            ->columnSpan(2)
                            ->weight(FontWeight::Bold),
                        TextEntry::make('created_at')
                            ->label('Timestamp')
                            ->dateTime('d/m/Y H:i:s', getUserTimezone())
                            ->badge()
                            ->color('info')
                            ->icon('heroicon-o-calendar'),
                        TextEntry::make('error_id')
                            ->label('ID do Erro')
                            ->copyable()
                            ->badge()
                            ->color('gray')
                            ->columnSpan(2),
                        TextEntry::make('code')
                            ->label('Código')
                            ->badge()
                            ->color('warning'),
                        TextEntry::make('status_code')
                            ->label('Status HTTP')
                            ->badge()
                            ->color('info'),
                        TextEntry::make('context.resource')
                            ->label('Recurso')
                            ->placeholder('Não informado')
                            ->badge()
                            ->color('primary'),
                        TextEntry::make('message')
                            ->label('Mensagem')
                            ->columnSpanFull(),
                        TextEntry::make('user_message')
                            ->label('Mensagem do Usuário')
                            ->columnSpanFull()
                            ->placeholder('Sem mensagem personalizada')
                            ->color('primary'),
                    ]),

                Section::make('Localização e Contexto')
                    ->description('Onde e quando o erro ocorreu')
                    ->icon('heroicon-o-map-pin')
                    ->columns(2)
                    ->columnSpanFull()
                    ->collapsed()
                    ->components([
                        TextEntry::make('file')
                            ->label('Arquivo')
                            ->copyable()
                            ->columnSpanFull(),
                        TextEntry::make('line')
                            ->label('Linha')
                            ->numeric()
                            ->badge()
                            ->color('gray'),
                        TextEntry::make('app_version')
                            ->label('Versão da Aplicação')
                            ->badge()
                            ->color('success'),
                        TextEntry::make('correlation_id')
                            ->label('ID de Correlação')
                            ->placeholder('Não informado')
                            ->badge()
                            ->color('info')
                            ->copyable(),
                        TextEntry::make('request_id')
                            ->label('ID da Requisição')
                            ->placeholder('Não informado')
                            ->badge()
                            ->color('info')
                            ->copyable(),
                        TextEntry::make('user.name')
                            ->label('Usuário')
                            ->placeholder('Usuário não identificado')
                            ->badge()
                            ->color('primary')
                            ->icon('heroicon-o-user'),
                        TextEntry::make('tenant.name')
                            ->label('Tenant')
                            ->placeholder('Tenant não identificado')
                            ->badge()
                            ->color('primary')
                            ->icon('heroicon-o-building-office'),
                        TextEntry::make('context.user.roles')
                            ->label('Papéis do Usuário')
                            ->placeholder('Nenhum papel atribuído')
                            ->badge(),
                        IconEntry::make('is_retryable')
                            ->label('Pode Retentar')
                            ->boolean()
                            ->trueIcon('heroicon-o-check-circle')
                            ->falseIcon('heroicon-o-x-circle')
                            ->trueColor('success')
                            ->falseColor('danger'),
                    ]),

                Section::make('Informações Técnicas')
                    ->description('Stack trace')
                    ->icon('heroicon-o-code-bracket')
                    ->collapsed()
                    ->columnSpanFull()
                    ->components([
                        TextEntry::make('stack_trace')
                            ->label('Stack Trace')
                            ->columnSpanFull()
                            ->size(TextSize::ExtraSmall)
                            ->placeholder('Stack trace não disponível'),
                    ]),

                Section::make('Exceção Anterior')
                    ->description('Detalhes da exceção que causou esta exceção')
                    ->icon('heroicon-o-arrow-uturn-left')
                    ->collapsed()
                    ->columnSpanFull()
                    ->visible(fn ($record): bool => ! empty($record->previous_exception_class))
                    ->columns(2)
                    ->components([
                        TextEntry::make('previous_exception_class')
                            ->label('Classe')
                            ->badge()
                            ->color('danger'),
                        TextEntry::make('previous_code')
                            ->label('Código')
                            ->badge()
                            ->color('warning'),
                        TextEntry::make('previous_message')
                            ->label('Mensagem')
                            ->columnSpanFull(),
                        TextEntry::make('previous_file')
                            ->label('Arquivo')
                            ->columnSpanFull()
                            ->copyable(),
                        TextEntry::make('previous_line')
                            ->label('Linha')
                            ->badge()
                            ->color('gray'),
                        TextEntry::make('previous_stack_trace')
                            ->label('Stack Trace Anterior')
                            ->columnSpanFull()
                            ->size(TextSize::ExtraSmall)
                            ->placeholder('Stack trace anterior não disponível'),
                    ]),
            ]);
    }
}
