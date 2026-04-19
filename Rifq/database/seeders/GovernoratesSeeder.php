<?php

namespace Database\Seeders;

use App\Models\Governorate;
use Illuminate\Database\Seeder;

class GovernoratesSeeder extends Seeder
{
    public function run(): void
    {
        $governorates = [
            'بغداد', 'البصرة', 'نينوى', 'أربيل', 'النجف',
            'كربلاء', 'ذي قار', 'ديالى', 'الأنبار', 'كركوك',
            'بابل', 'واسط', 'صلاح الدين', 'القادسية', 'المثنى',
            'ميسان', 'دهوك', 'السليمانية', 'ديالى',
        ];

        foreach ($governorates as $name) {
            Governorate::firstOrCreate(['name' => $name]);
        }
    }
}
