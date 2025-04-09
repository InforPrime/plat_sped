<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')->label('Nome')
                    ->required(),
                TextInput::make('email')->email()
                    ->required(),
                Select::make('role')
                    ->label('Regra')
                    ->options([
                        'admin' => 'Admin',
                        'contador' => 'Contador',
                    ])
                    ->visible(
                        fn() => auth()->user()->role === 'admin'
                    ),
                TextInput::make('password')->password()->label('Senha')
                    ->required(),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('nome')
                    ->searchable(),
                TextColumn::make('email'),
                TextColumn::make('role')
                    ->label('tipo'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                    ->visible(
                        fn() => auth()->user()->role === 'admin'
                    ),
                ]),
            ]);
    }

    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery();

        // Se o usuário logado não for admin, filtra para retornar somente seu próprio registro
        if (auth()->user()->role !== 'admin') {
            $query->where('id', auth()->user()->id);
        }

        return $query;
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }

    public static function canAccess(): bool
    {
        if (auth()->user()->role === 'admin') {
            return true;
        } else if (auth()->id() == 1) {
            return true;
        }

        return false;
    }
}
