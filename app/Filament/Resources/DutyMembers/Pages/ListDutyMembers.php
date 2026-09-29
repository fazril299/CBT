<?php

namespace App\Filament\Resources\DutyMembers\Pages;

use App\Filament\Resources\DutyMembers\DutyMemberResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListDutyMembers extends ListRecords
{
    protected static string $resource = DutyMemberResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
