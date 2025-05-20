<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Customer;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Customer::create([
            'name' => 'Adriana Aina',
            'matric' => 'A19EC0001',
            'email' => 'adrianaaina322@gmail.com',
            'race' => 'Malay',
            'phone' => '01125709642',
            'ic' => ' 0001234567895',
            'address' => 'Blok H1',
            'college' => 'K9',
            'faculty' => 'FSSH',
            'bank' => 'Maybank',
            'acc_num' => '12342342434',
            'acc_num_name' => 'Adriana Aina',
        ]);

        Customer::create([
            'name' => 'Ahmad Najwan Bin Lawrence',
            'matric' => 'A19EA0001',
            'email' => 'farwanajwan@gmail.com',
            'race' => 'Malay',
            'phone' => '60198599544',
            'ic' => ' 0001234567896',
            'address' => 'Blok MA1',
            'college' => 'KTDI',
            'faculty' => 'FC',
            'bank' => 'Maybank',
            'acc_num' => '151516162626',
            'acc_num_name' => 'Ahmad Najwan',
        ]);

        Customer::create([
            'name' => 'Ahmad Shahril Adham Bin Mustafa',
            'matric' => 'A19EM0001',
            'email' => 'shahriladham77@gmail.com',
            'race' => 'Malay',
            'phone' => ' 60199755463',
            'ic' => ' 0001234567897',
            'address' => 'Blok MA1',
            'college' => 'KTDI',
            'faculty' => 'FC',
            'bank' => 'Maybank',
            'acc_num' => '956846459485',
            'acc_num_name' => 'Ahmad Shahril Adham Bin Mustafa',
        ]);
    }
}
