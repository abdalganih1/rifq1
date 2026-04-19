<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AIScanResource\Pages;
use App\Filament\Resources\AIScanResource\RelationManagers;
use App\Models\AIScan;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AIScanResource extends Resource
{
    protected static ?string $model = AIScan::class;

    protected static ?string $navigationIcon = 'heroicon-o-camera';
    
    protected static ?string $navigationLabel = 'فحوصات الذكاء الاصطناعي';
    
    protected static ?string $modelLabel = 'فحص';
    
    protected static ?string $pluralModelLabel = 'فحوصات الذكاء الاصطناعي';
    
    protected static ?string $navigationGroup = 'الفحوصات';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
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
            'index' => Pages\ListAIScans::route('/'),
            'create' => Pages\CreateAIScan::route('/create'),
            'edit' => Pages\EditAIScan::route('/{record}/edit'),
        ];
    }
}
