<?php

namespace App\Filament\Resources\Activities\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class ActivityForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('user_id')
                    ->label('Siswa / Petugas')
                    ->relationship('user', 'name')
                    ->required(),
                Select::make('schedule_id')
                    ->label('Jadwal Piket')
                    ->relationship('schedule', 'location')
                    ->getOptionLabelFromRecordUsing(fn ($record) => "{$record->day} - {$record->location}"),
                TextInput::make('title')
                    ->label('Nama Tugas')
                    ->required(),
                Textarea::make('description')
                    ->label('Deskripsi')
                    ->required()
                    ->columnSpanFull(),
                DateTimePicker::make('target_date')
                    ->label('Batas Waktu (Deadline)')
                    ->required(),
                DateTimePicker::make('done_time')
                    ->label('Diselesaikan Pada'),
                Toggle::make('status')
                    ->label('Status (Sudah Selesai?)')
                    ->required(),
            ]);
    }
}
