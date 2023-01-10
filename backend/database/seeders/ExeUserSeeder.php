<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use App\Models\ExeUser;

class ExeUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ExeUser::truncate();

        $json = File::get("database/data/data.json");
        $countries = json_decode($json);

        foreach ($countries as $key => $value) {
            ExeUser::create([
                "name" => $value->name,
                'phone' => $value->phone,
                'email' => $value->email,
                'password' => Hash::make($value->password),
                'username' => $value->username,
                'company' => $value->company,
                'nationality' => $value->nationality
            ]);
        }
    }
}
