<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run()
    {

    	$datas = [
		         	[
		            'name' => 'pencil',
		            'category' => 'school supplies',
		            'description' => 'Mongol brand',
		            'date_time' => date('Y-m-d H:i:s')
		        	],
		        	[
		            'name' => 'color pencil',
		            'category' => 'school supplies',
		            'description' => 'Fabre castle brand',
		            'date_time' => date('Y-m-d H:i:s')
		        	],
		        	[
		            'name' => 'Scissor',
		            'category' => 'school supplies',
		            'description' => 'Maped brand',
		            'date_time' => date('Y-m-d H:i:s')
		        	]
		    	];

    	foreach($datas as $data)
    	{
	        DB::table('products')->insert([
	            'name' => $data['name'],
	            'category' => $data['category'],
	            'description' => $data['description'],
	            'date_time' => date('Y-m-d H:i:s'),
	            'created_at' => date('Y-m-d H:i:s'),
	            'updated_at' => date('Y-m-d H:i:s')
	        ]);
    	}
    }
}
