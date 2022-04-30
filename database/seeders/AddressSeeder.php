<?php

namespace Database\Seeders;

use DB;
use File;
use Illuminate\Database\Seeder;

class AddressSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // https://github.com/daohoangson/dvhcvn
        $json = File::get("database/datas/sorted.json");
        $array = json_decode($json, true);

        // Province
        foreach ($array as $province) {
            // insert province to db
            DB::table('provinces')->insert([
                "id" => $province[0],
                "name" => $province[1],
                "type" => $province[2],
            ]);

            $province_id = $province[0];

            // district
            foreach ($province[4] as $district) {
                // insert district to db
                DB::table('districts')->insert([
                    "id" => $district[0],
                    "name" => $district[1],
                    "type" => $district[2],
                    "province_id" => $province_id,
                ]);

                $district_id = $district[0];

                // ward
                foreach ($district[4] as $ward) {
                    // insert ward to db
                    DB::table('wards')->insert([
                        "id" => $ward[0],
                        "name" => $ward[1],
                        "type" => $ward[2],
                        "district_id" => $district_id,
                    ]);
                    //end
                }
            }
        }
    }
}
