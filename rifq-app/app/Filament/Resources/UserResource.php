<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Spatie\Permission\Models\Role;

class UserResource extends Resource
{
    protected static ?string $model = User::class;
    protected static ?string $navigationIcon = 'heroicon-o-users';
    protected static ?string $navigationLabel = 'المستخدمين';
    protected static ?string $modelLabel = 'مستخدم';
    protected static ?string $pluralModelLabel = 'المستخدمين';
    protected static ?string $navigationGroup = 'إدارة المستخدمين';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('معلومات الحساب')->schema([
                Forms\Components\TextInput::make('first_name')->required()->maxLength(255)->label('الاسم الأول'),
                Forms\Components\TextInput::make('last_name')->required()->maxLength(255)->label('الاسم الأخير'),
                Forms\Components\TextInput::make('username')->maxLength(255)->label('اسم المستخدم')->unique(ignoreRecord: true),
                Forms\Components\TextInput::make('email')->email()->required()->maxLength(255)->label('البريد الإلكتروني'),
                Forms\Components\DateTimePicker::make('email_verified_at')->label('تأكيد البريد'),
                Forms\Components\TextInput::make('password')->password()->dehydrated(fn ($state) => filled($state))->maxLength(255)->label('كلمة المرور'),
            ])->columns(2),

            Forms\Components\Section::make('معلومات شخصية')->schema([
                Forms\Components\Select::make('gender')->options([
                    'Male' => 'ذكر',
                    'Female' => 'أنثى',
                ])->required()->label('الجنس'),
                Forms\Components\DatePicker::make('birth_date')->required()->label('تاريخ الميلاد'),
                Forms\Components\TextInput::make('national_id')->required()->maxLength(255)->label('رقم الهوية')->unique(ignoreRecord: true),
                Forms\Components\TextInput::make('phone_number')->tel()->required()->maxLength(255)->label('رقم الهاتف'),
            ])->columns(2),

            Forms\Components\Section::make('الصلاحيات والانتماء')->schema([
                Forms\Components\Select::make('roles')
                    ->relationship('roles', 'name', fn ($query) => $query->whereNotNull('name'))
                    ->multiple()
                    ->preload()
                    ->label('الأدوار (Spatie)'),
                Forms\Components\Select::make('organization_id')
                    ->relationship('organization', 'name', fn ($query) => $query->whereNotNull('name'))
                    ->searchable()->preload()
                    ->label('المنظمة'),
                Forms\Components\Select::make('governorate_id')
                    ->relationship('governorate', 'name', fn ($query) => $query->whereNotNull('name'))
                    ->searchable()->preload()
                    ->label('المحافظة'),
                Forms\Components\Select::make('independent_team_id')
                    ->relationship('independentTeam', 'name', fn ($query) => $query->whereNotNull('name'))
                    ->searchable()->preload()
                    ->label('الفريق المستقل'),
            ])->columns(2),

            Forms\Components\Section::make('معلومات إضافية')->schema([
                Forms\Components\TextInput::make('specialization')->maxLength(255)->label('التخصص'),
                Forms\Components\TextInput::make('academic_level')->maxLength(255)->label('المستوى الأكاديمي'),
            ])->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('first_name')->searchable()->label('الاسم الأول'),
            Tables\Columns\TextColumn::make('last_name')->searchable()->label('الاسم الأخير'),
            Tables\Columns\TextColumn::make('username')->searchable()->label('اسم المستخدم'),
            Tables\Columns\TextColumn::make('email')->searchable()->label('البريد'),
            Tables\Columns\TextColumn::make('roles.name')->badge()->label('الدور')->color('primary'),
            Tables\Columns\TextColumn::make('independentTeam.name')->label('الفريق')->sortable(),
            Tables\Columns\TextColumn::make('governorate.name')->label('المحافظة')->sortable(),
            Tables\Columns\TextColumn::make('phone_number')->searchable()->label('الهاتف'),
            Tables\Columns\TextColumn::make('created_at')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true)->label('تاريخ الإنشاء'),
        ])->filters([
            Tables\Filters\SelectFilter::make('roles')->relationship('roles', 'name')->label('الدور')->multiple(),
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
