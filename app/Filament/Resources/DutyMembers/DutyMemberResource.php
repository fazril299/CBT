<?php

namespace App\Filament\Resources\DutyMembers;

use App\Filament\Resources\DutyMembers\Pages\CreateDutyMember;
use App\Filament\Resources\DutyMembers\Pages\EditDutyMember;
use App\Filament\Resources\DutyMembers\Pages\ListDutyMembers;
use App\Filament\Resources\DutyMembers\Schemas\DutyMemberForm;
use App\Filament\Resources\DutyMembers\Tables\DutyMembersTable;
use App\Models\DutyMember;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class DutyMemberResource extends Resource
{
    protected static ?string $model = DutyMember::class;

    protected static ?string $modelLabel = 'Laporan Piket (Anggota)';
    protected static ?string $pluralModelLabel = 'Laporan Piket';
    protected static ?string $navigationLabel = 'Laporan Piket';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedClipboardDocumentList;

    public static function form(Schema $schema): Schema
    {
        return DutyMemberForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return DutyMembersTable::configure($table);
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
            'index' => ListDutyMembers::route('/'),
            'create' => CreateDutyMember::route('/create'),
            'edit' => EditDutyMember::route('/{record}/edit'),
        ];
    }
}
