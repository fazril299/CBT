<?php

namespace App\Filament\Resources\DutyMembers\Pages;

use App\Filament\Resources\DutyMembers\DutyMemberResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditDutyMember extends EditRecord
{
    protected static string $resource = DutyMemberResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
