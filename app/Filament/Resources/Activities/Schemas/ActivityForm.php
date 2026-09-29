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
                    ->relationship('user', 'name')
                    ->required(),
                Select::make('schedule_id')
                    ->relationship('schedule', 'id'),
                TextInput::make('title')
                    ->required(),
                Textarea::make('description')
                    ->required()
                    ->columnSpanFull(),
                DateTimePicker::make('target_date')
                    ->required(),
                DateTimePicker::make('done_time'),
                Toggle::make('status')
                    ->required(),
            ]);
    }
}
