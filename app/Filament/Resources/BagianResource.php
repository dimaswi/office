<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BagianResource\Pages;
use App\Filament\Resources\BagianResource\RelationManagers;
use App\Models\Bagian;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class BagianResource extends Resource
{
    protected static ?string $model = Bagian::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-office';

    protected static ?string $navigationLabel = 'Bagian';

    protected static ?string $navigationGroup = 'Settings';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()->schema([
                    TextInput::make('nama_bagian')->required()->placeholder('Masukan Nama Bagian'),
                    TextInput::make('kode_bagian')->required()->placeholder('Masukan Kode Bagian'),
                    Select::make('kepala_bagian')->searchable()->required()->options(
                        User::all()->pluck('name', 'id')
                        )->columnSpanFull(),
                    FileUpload::make('kop')
                        ->columnSpanFull()
                        ->image()
                        ->imageEditor()
                        ->disk('public')
                        ->directory('kop')
                        ->downloadable(),
                ])->columns(2)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nama_bagian')->searchable()->sortable(),
                TextColumn::make('kode_bagian')->searchable()->sortable()->badge(),
                TextColumn::make('kepala.name')->searchable()->sortable(),
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
            'index' => Pages\ListBagians::route('/'),
            'create' => Pages\CreateBagian::route('/create'),
            'edit' => Pages\EditBagian::route('/{record}/edit'),
        ];
    }
}
