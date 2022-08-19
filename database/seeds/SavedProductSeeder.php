<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class SavedProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (range(1, 10) as $i) {
            DB::table('saved_designs')->insert([
                [
                    'customer_id' => 1, 
                    'design' => '1658756850.png',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'customer_id' => 2, 
                    'design' => 'pi_10337_image.png',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'customer_id' => 1, 
                    'design' => 'pi_13201_image.png',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'customer_id' => 2, 
                    'design' => 'pi_13481_image.png',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
            ]);
        }
        
        foreach (range(1, 10) as $i) {
            DB::table('quote_requests')->insert([
                [
                    'customer_id' => 1, 
                    'design' => '1658756850.png',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'customer_id' => 2, 
                    'design' => 'pi_10337_image.png',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'customer_id' => 1, 
                    'design' => 'pi_13201_image.png',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'customer_id' => 2, 
                    'design' => 'pi_13481_image.png',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
            ]);
        }
    }
}
