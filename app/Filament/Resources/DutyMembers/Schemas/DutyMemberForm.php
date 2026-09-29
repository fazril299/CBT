<?php

namespace App\Filament\Resources\DutyMembers\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class DutyMemberForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('schedule_id')
                    ->label('Jadwal Piket')
                    ->relationship('schedule', 'location')
                    ->getOptionLabelFromRecordUsing(fn ($record) => "{$record->day} - {$record->location} ({$record->date?->format('d M Y')})")
                    ->searchable()
                    ->preload()
                    ->required(),
                Select::make('user_id')
                    ->label('Siswa')
                    ->relationship('user', 'name', fn ($query) => $query->where('role', 'siswa'))
                    ->searchable()
                    ->preload()
                    ->required(),
                Toggle::make('is_pj')
                    ->label('Penanggung Jawab (PJ)')
                    ->required(),
            ]);
    }
}
