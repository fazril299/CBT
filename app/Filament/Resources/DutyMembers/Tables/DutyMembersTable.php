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
            ->modifyQueryUsing(fn ($query) => $query->with(['schedule', 'attendances']))
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
                    ->formatStateUsing(fn (bool $state): string => $state ? 'PJ' : 'Anggota')
                    ->color(fn (bool $state): string => $state ? 'danger' : 'gray'),
                TextColumn::make('effective_status_label')
                    ->label('Laporan / Status')
                    ->badge()
                    ->color(fn (string $state): string => match (true) {
                        str_contains(strtolower($state), 'hadir') => 'success',
                        str_contains(strtolower($state), 'alpa') => 'danger',
                        str_contains(strtolower($state), 'izin') || str_contains(strtolower($state), 'sakit') => 'warning',
                        default => 'gray',
                    }),
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
                \Filament\Actions\DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}


