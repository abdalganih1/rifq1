<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AnimalResource\Pages;
use App\Models\Animal;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;

class AnimalResource extends Resource
{
    protected static ?string $model = Animal::class;
    protected static ?string $navigationIcon = 'heroicon-o-heart';
    protected static ?string $navigationLabel = 'الحيوانات';
    protected static ?string $modelLabel = 'حيوان';
    protected static ?string $pluralModelLabel = 'الحيوانات';
    protected static ?string $navigationGroup = 'إدارة الحيوانات';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('معلومات أساسية')->schema([
                Forms\Components\TextInput::make('serial_number')->label('الرقم التسلسلي')->maxLength(255),
                Forms\Components\TextInput::make('uuid')->label('UUID')->maxLength(255)->disabled(),
                Forms\Components\TextInput::make('animal_type')->label('نوع الحيوان')->maxLength(255),
                Forms\Components\TextInput::make('animal_type_en')->label('Animal Type (EN)')->maxLength(255),
                Forms\Components\TextInput::make('breed_name')->label('السلالة')->maxLength(255),
                Forms\Components\TextInput::make('breed_name_en')->label('Breed (EN)')->maxLength(255),
                Forms\Components\Select::make('gender')->label('الجنس')->options([
                    'Male' => 'ذكر',
                    'Female' => 'أنثى',
                    'Unknown' => 'غير معروف',
                ])->required(),
                Forms\Components\TextInput::make('estimated_age')->label('العمر المقدر')->maxLength(255),
                Forms\Components\TextInput::make('color')->label('اللون')->maxLength(255),
                Forms\Components\TextInput::make('color_en')->label('Color (EN)')->maxLength(255),
                Forms\Components\Textarea::make('distinguishing_marks')->label('العلامات المميزة'),
                Forms\Components\Textarea::make('distinguishing_marks_en')->label('Distinguishing Marks (EN)'),
            ])->columns(2),

            Forms\Components\Section::make('الموقع')->schema([
                Forms\Components\TextInput::make('city_province')->label('المدينة/المحافظة')->maxLength(255),
                Forms\Components\TextInput::make('city_province_en')->label('City (EN)')->maxLength(255),
                Forms\Components\TextInput::make('relocation_place')->label('مكان الترحيل')->maxLength(255),
                Forms\Components\TextInput::make('relocation_place_en')->label('Relocation (EN)')->maxLength(255),
                Forms\Components\Textarea::make('location_found')->label('مكان الوجود'),
            ])->columns(2),

            Forms\Components\Section::make('الحالة والفريق')->schema([
                Forms\Components\Select::make('status')->label('الحالة')->options([
                    'Stray' => 'شارد',
                    'In_Shelter' => 'في المأوى',
                    'Adopted' => 'متبنى',
                    'Available' => 'متاح',
                    'Deceased' => 'متوفي',
                ])->required(),
                Forms\Components\Toggle::make('data_entered_status')->label('تم إدخال البيانات')->default(false),
                Forms\Components\Select::make('independent_team_id')
                    ->relationship('independentTeam', 'name')
                    ->label('الفريق المستقل')
                    ->searchable()->preload(),
                Forms\Components\Select::make('organization_id')
                    ->relationship('organization', 'name')
                    ->label('المنظمة')
                    ->searchable()->preload(),
                Forms\Components\TextInput::make('emergency_contact_phone')->label('هاتف الطوارئ')->tel()->maxLength(255),
            ])->columns(2),

            Forms\Components\Section::make('السجلات الطبية (JSON)')->schema([
                Forms\Components\KeyValue::make('medical_procedures')->label('الإجراءات الطبية')->keyLabel('الإجراء')->valueLabel('التفاصيل'),
                Forms\Components\KeyValue::make('parasite_treatments')->label('علاجات الطفيليات')->keyLabel('العلاج')->valueLabel('التفاصيل'),
                Forms\Components\KeyValue::make('vaccinations_details')->label('التطعيمات')->keyLabel('التطعيم')->valueLabel('التفاصيل'),
                Forms\Components\KeyValue::make('medical_supervisor_info')->label('المشرف الطبي')->keyLabel('المفتاح')->valueLabel('القيمة'),
            ])->columns(2)->collapsed(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('serial_number')->searchable()->label('الرقم التسلسلي')->sortable(),
            Tables\Columns\TextColumn::make('animal_type')->searchable()->label('نوع الحيوان'),
            Tables\Columns\TextColumn::make('breed_name')->searchable()->label('السلالة'),
            Tables\Columns\TextColumn::make('gender')->label('الجنس'),
            Tables\Columns\TextColumn::make('estimated_age')->label('العمر')->sortable(),
            Tables\Columns\TextColumn::make('status')->label('الحالة')->badge()->color(fn (string $state): string => match ($state) {
                'Adopted' => 'success',
                'Available', 'Stray' => 'warning',
                'In_Shelter' => 'info',
                'Deceased' => 'danger',
                default => 'gray',
            }),
            Tables\Columns\IconColumn::make('data_entered_status')->boolean()->label('تم الإدخال')->trueIcon('heroicon-o-check-circle')->falseIcon('heroicon-o-x-circle'),
            Tables\Columns\TextColumn::make('independentTeam.name')->label('الفريق')->sortable(),
            Tables\Columns\TextColumn::make('city_province')->label('المحافظة')->searchable(),
            Tables\Columns\TextColumn::make('created_at')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true)->label('تاريخ الإنشاء'),
        ])->filters([
            SelectFilter::make('status')->label('الحالة')->options([
                'Stray' => 'شارد',
                'In_Shelter' => 'في المأوى',
                'Adopted' => 'متبنى',
                'Available' => 'متاح',
                'Deceased' => 'متوفي',
            ]),
            SelectFilter::make('independent_team_id')->relationship('independentTeam', 'name')->label('الفريق'),
            TernaryFilter::make('data_entered_status')->label('حالة الإدخال'),
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
            'index' => Pages\ListAnimals::route('/'),
            'create' => Pages\CreateAnimal::route('/create'),
            'edit' => Pages\EditAnimal::route('/{record}/edit'),
        ];
    }
}
