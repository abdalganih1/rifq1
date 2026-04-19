<?php

namespace App\Filament\Resources;

use App\Filament\Resources\GovernorateResource\Pages;
use App\Models\Governorate;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class GovernorateResource extends Resource
{
    protected static ?string $model = Governorate::class;
    protected static ?string $navigationIcon = 'heroicon-o-map';
    protected static ?string $navigationLabel = 'المحافظات';
    protected static ?string $modelLabel = 'محافظة';
    protected static ?string $pluralModelLabel = 'المحافظات';
    protected static ?string $navigationGroup = 'إدارة الموقع';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('name')
                ->required()
                ->maxLength(255)
                ->unique(ignoreRecord: true)
                ->label('اسم المحافظة'),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('id')->sortable(),
            Tables\Columns\TextColumn::make('name')->searchable()->label('اسم المحافظة'),
            Tables\Columns\TextColumn::make('independentTeams_count')
                ->counts('independentTeams')
                ->label('عدد الفرق'),
            Tables\Columns\TextColumn::make('created_at')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true),
        ])->actions([
            Tables\Actions\EditAction::make(),
        ])->bulkActions([
            Tables\Actions\BulkActionGroup::make([
                Tables\Actions\DeleteBulkAction::make(),
            ]),
        ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListGovernorates::route('/'),
            'create' => Pages\CreateGovernorate::route('/create'),
            'edit' => Pages\EditGovernorate::route('/{record}/edit'),
        ];
    }
}
