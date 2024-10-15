<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RuangRapatResource\Pages;
use App\Filament\Resources\RuangRapatResource\RelationManagers;
use App\Models\RuangRapat;
use Filament\Forms;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class RuangRapatResource extends Resource
{
    protected static ?string $model = RuangRapat::class;

    protected static ?string $navigationIcon = 'heroicon-o-home';

    protected static ?string $navigationLabel = 'Ruang Rapat';

    protected static ?string $navigationGroup = 'Settings';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()->schema([
                    TextInput::make('nama_ruang')->required()->label('Nama Ruang')->placeholder('Masukan Nama Ruang'),
                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nama_ruang')->searchable()->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
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
            'index' => Pages\ListRuangRapats::route('/'),
            'create' => Pages\CreateRuangRapat::route('/create'),
            'edit' => Pages\EditRuangRapat::route('/{record}/edit'),
        ];
    }
}
