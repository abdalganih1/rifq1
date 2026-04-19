<?php

namespace App\Filament\Resources;

use App\Filament\Resources\IndependentTeamResource\Pages;
use App\Models\IndependentTeam;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class IndependentTeamResource extends Resource
{
    protected static ?string $model = IndependentTeam::class;
    protected static ?string $navigationIcon = 'heroicon-o-user-group';
    protected static ?string $navigationLabel = 'الفرق المستقلة';
    protected static ?string $modelLabel = 'فريق مستقل';
    protected static ?string $pluralModelLabel = 'الفرق المستقلة';
    protected static ?string $navigationGroup = 'إدارة الموقع';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('name')
                ->required()
                ->maxLength(255)
                ->unique(ignoreRecord: true)
                ->label('اسم الفريق'),
            Forms\Components\Select::make('governorate_id')
                ->relationship('governorate', 'name')
                ->searchable()
                ->preload()
                ->label('المحافظة'),
            Forms\Components\TextInput::make('contact_phone')
                ->tel()
                ->maxLength(255)
                ->label('هاتف التواصل'),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('id')->sortable(),
            Tables\Columns\TextColumn::make('name')->searchable()->label('اسم الفريق'),
            Tables\Columns\TextColumn::make('governorate.name')->label('المحافظة')->sortable(),
            Tables\Columns\TextColumn::make('contact_phone')->label('هاتف التواصل')->searchable(),
            Tables\Columns\TextColumn::make('users_count')
                ->counts('users')
                ->label('عدد الأعضاء'),
            Tables\Columns\TextColumn::make('animals_count')
                ->counts('animals')
                ->label('عدد الحيوانات'),
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
            'index' => Pages\ListIndependentTeams::route('/'),
            'create' => Pages\CreateIndependentTeam::route('/create'),
            'edit' => Pages\EditIndependentTeam::route('/{record}/edit'),
        ];
    }
}
