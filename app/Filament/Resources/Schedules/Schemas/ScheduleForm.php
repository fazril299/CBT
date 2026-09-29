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
                    ->options(['piket_wc' => 'Piket wc', 'piket_rayon' => 'Piket rayon'])
                    ->default('piket_wc')
                    ->required(),
                TextInput::make('location'),
                DatePicker::make('date')
                    ->required(),
                TextInput::make('day')
                    ->required(),
                TimePicker::make('time')
                    ->required(),
                Select::make('status')
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
