<?php

use Carbon\Carbon;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('delivery')->insert([
            [
                'id' => '1',
                'name' => 'Pizza delivery',
                'company_name' => 'company 1',
                'url' => Request::root() . ':3001/api/transport-company/calculation/fast-delivery',
                'type' => 1,
                'price' => 300,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'id' => '2',
                'name' => 'Pizza delivery',
                'company_name' => 'company 2',
                'url' => Request::root() . ':3001/api/transport-company/calculation/fast-delivery',
                'type' => 1,
                'price' => 500,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'id' => '3',
                'name' => 'Pizza delivery',
                'company_name' => 'company 3',
                'url' => Request::root() . ':3001/api/transport-company/calculation/slow-delivery',
                'type' => 0,
                'price' => 150,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'id' => '4',
                'name' => 'Pizza delivery',
                'company_name' => 'company 4',
                'url' => Request::root() . ':3001/api/transport-company/calculation/slow-delivery',
                'type' => 0,
                'price' => 150,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table('delivery')->truncate();
    }
};
