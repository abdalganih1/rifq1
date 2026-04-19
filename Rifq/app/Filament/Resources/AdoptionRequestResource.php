<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AdoptionRequestResource\Pages;
use App\Filament\Resources\AdoptionRequestResource\RelationManagers;
use App\Models\AdoptionRequest;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AdoptionRequestResource extends Resource
{
    protected static ?string $model = AdoptionRequest::class;

    protected static ?string $navigationIcon = 'heroicon-o-home';
    
    protected static ?string $navigationLabel = 'طلبات التبني';
    
    protected static ?string $modelLabel = 'طلب تبني';
    
    protected static ?string $pluralModelLabel = 'طلبات التبني';
    
    protected static ?string $navigationGroup = 'السجلات والطلبات';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('animal_id')
                    ->relationship('animal', 'name')
                    ->required(),
                Forms\Components\Select::make('adopter_id')
                    ->relationship('adopter', 'id')
                    ->required(),
                Forms\Components\TextInput::make('status')
                    ->required(),
                Forms\Components\Textarea::make('request_message')
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\Textarea::make('rejection_reason')
                    ->columnSpanFull(),
                Forms\Components\DateTimePicker::make('request_date')
                    ->required(),
                Forms\Components\DateTimePicker::make('decision_date'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('animal.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('adopter.id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('status'),
                Tables\Columns\TextColumn::make('request_date')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('decision_date')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('deleted_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
            'index' => Pages\ListAdoptionRequests::route('/'),
            'create' => Pages\CreateAdoptionRequest::route('/create'),
            'edit' => Pages\EditAdoptionRequest::route('/{record}/edit'),
        ];
    }
}
