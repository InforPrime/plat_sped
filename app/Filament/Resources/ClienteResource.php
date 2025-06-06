<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ClienteResource\Pages;
use App\Filament\Resources\ClienteResource\RelationManagers;
use App\Models\Cliente;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Infolists;
use Filament\Infolists\Infolist;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ClienteResource extends Resource
{
    protected static ?string $model = Cliente::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('nome')
                    ->required(),
                TextInput::make('nome_modelo')
                    ->label('Nome do Modelo')
                    ->required(),
                Select::make('contador_id')
                    ->label('Contador')
                    ->options(User::where('role', 'contador')->pluck('name', 'id')->toArray())
                    ->searchable()
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nome')->searchable(),
                TextColumn::make('nome_modelo')
                    ->label('Nome do Modelo')
                    ->searchable(),
                TextColumn::make('contador.name')
                    ->label('Contador')
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make()
                    ->visible(auth()->user()->role === 'admin'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->visible(auth()->user()->role === 'admin'),
                ]),
            ])->modifyQueryUsing(function (Builder $query) {
                if (auth()->user()->role === 'contador') {
                    $query->where('contador_id', auth()->id());
                } else {
                    $query->select('clientes.*')->get();
                }
            });
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Infolists\Components\TextEntry::make('nome'),
                Infolists\Components\TextEntry::make('nome_modelo')
                    ->label('Nome do Modelo'),
                Infolists\Components\TextEntry::make('contador.name')
                    ->columnSpanFull(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            'arquivos' => RelationManagers\ArquivosRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListClientes::route('/'),
            'create' => Pages\CreateCliente::route('/create'),
            'view' => Pages\ViewCliente::route('/{record}'),
            'edit' => Pages\EditCliente::route('/{record}/edit'),
        ];
    }
}
