<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CutiResource\Pages;
use App\Filament\Resources\CutiResource\RelationManagers;
use App\Models\Cuti;
use Filament\Forms;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CutiResource extends Resource
{
    protected static ?string $model = Cuti::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-plus';

    protected static ?string $navigationLabel = 'Cuti';

    protected static ?string $navigationGroup = 'Surat';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()->schema([
                    DatePicker::make('tanggal_mulai')->required()->label('Tanggal Mulai'),
                    DatePicker::make('tanggal_selesai')->required()->label('Tanggal Selesai'),
                    RichEditor::make('alasan_cuti')->label('Alasan Cuti')->columnSpanFull()
                ])->columns(2)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(function (Builder $query) {
                if (!auth()->user()->hasRole('Verifikator Cuti')) {

                    return $query->where('karyawan', auth()->user()->id);
                }
            })
            ->columns([
                TextColumn::make('user.name')->searchable()->sortable()->label('Nama Karyawan'),
                TextColumn::make('alasan_cuti')->searchable()->limit(100)->html()->label('Alasan Cuti'),
                TextColumn::make('created_at')->searchable()->sortable()->badge()->label('Dibuat')->since(),
            ])
            ->filters([
                //
            ])
            ->actions([
                ActionGroup::make([
                    Tables\Actions\EditAction::make(),
                    Action::make('ajukan')->color('primary')->icon('heroicon-o-check-circle')
                        ->action(
                            function (Cuti $cuti) {
                                $cuti->update(['status' => 1]);
                            }
                        )->requiresConfirmation()->hidden(fn() => auth()->user()->hasRole('Verifikator Cuti')),
                    Action::make('setujui')->color('success')->icon('heroicon-o-check-circle')
                        ->action(
                            function (Cuti $cuti) {
                                $cuti->update(['status' => 2]);
                            }
                        )->requiresConfirmation()->hidden(fn(Cuti $cuti) => !auth()->user()->hasRole('Verifikator Cuti')),
                    Action::make('tolak')->color('danger')->icon('heroicon-o-x-circle')
                        ->action(
                            function (Cuti $cuti) {
                                $cuti->update(['status' => 3]);
                            }
                        )->requiresConfirmation()->hidden(fn(Cuti $cuti) => !auth()->user()->hasRole('Verifikator Cuti'))
                ])->hidden(fn(Cuti $cuti) => $cuti->status > 1)
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
            'index' => Pages\ListCutis::route('/'),
            'create' => Pages\CreateCuti::route('/create'),
            'edit' => Pages\EditCuti::route('/{record}/edit'),
        ];
    }
}
