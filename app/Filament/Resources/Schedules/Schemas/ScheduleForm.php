<?php

namespace App\Filament\Resources\Schedules\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TimePicker;
use Filament\Schemas\Schema;

class ScheduleForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('piket_type')
                    ->label('Jenis Piket')
                    ->options(['piket_wc' => 'Piket WC', 'piket_rayon' => 'Piket Rayon'])
                    ->default('piket_wc')
                    ->required(),
                TextInput::make('location')
                    ->label('Lokasi'),
                DatePicker::make('date')
                    ->label('Tanggal')
                    ->required(),
                TextInput::make('day')
                    ->label('Hari')
                    ->required(),
                TimePicker::make('time')
                    ->label('Waktu')
                    ->required(),
                Select::make('status')
                    ->label('Status')
                    ->options([
            'belum_dilakukan' => 'Belum dilakukan',
            'sedang_berlangsung' => 'Sedang berlangsung',
            'selesai' => 'Selesai',
        ])
                    ->default('belum_dilakukan')
                    ->required(),
            ]);
    }
}
