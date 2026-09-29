<?php

namespace App\Filament\Resources\DutyMembers\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class DutyMembersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')
                    ->label('Siswa')
                    ->searchable()
                    ->sortable()
                    ->weight('medium'),
                TextColumn::make('schedule.day')
                    ->label('Hari')
                    ->badge()
                    ->color('primary'),
                TextColumn::make('schedule.location')
                    ->label('Lokasi')
                    ->searchable(),
                TextColumn::make('is_pj')
                    ->label('Peran')
                    ->badge()
                    ->formatStateUsing(fn (bool $state): string => $state ? 'PJ (Penanggung Jawab)' : 'Anggota')
                    ->color(fn (bool $state): string => $state ? 'danger' : 'gray'),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
