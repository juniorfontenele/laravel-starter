<?php

declare(strict_types = 1);

namespace App\Filament\Admin\Resources\Exceptions\Pages;

use App\Filament\Admin\Resources\Exceptions\ExceptionResource;
use Filament\Resources\Pages\ListRecords;

class ListExceptions extends ListRecords
{
    protected static string $resource = ExceptionResource::class;

    protected function getHeaderActions(): array
    {
        return [
        ];
    }
}
