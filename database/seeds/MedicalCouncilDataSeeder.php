<?php

use Illuminate\Database\Seeder;

class MedicalCouncilDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	 DB::table('medicalcouncils')->insert(['name'=>'NOT APPLICABLE']);
         DB::table('medicalcouncils')->insert(['name'=>'ANDHRA PRADESH']);
         DB::table('medicalcouncils')->insert(['name'=>'ARUNACHAL PRADESH']);
         DB::table('medicalcouncils')->insert(['name'=>'ASSAM']);
         DB::table('medicalcouncils')->insert(['name'=>'BIHAR']);
         DB::table('medicalcouncils')->insert(['name'=>'CHATTISGARH']);
         DB::table('medicalcouncils')->insert(['name'=>'DELHI']);
         DB::table('medicalcouncils')->insert(['name'=>'DENTAL COUNCIL OF INDIA']);
         DB::table('medicalcouncils')->insert(['name'=>'GOA']);
         DB::table('medicalcouncils')->insert(['name'=>'GUJARAT']);
         DB::table('medicalcouncils')->insert(['name'=>'HARYANA']);
         DB::table('medicalcouncils')->insert(['name'=>'HIMACHAL PRADESH']);
         DB::table('medicalcouncils')->insert(['name'=>'JAMMU & KASHMIR']);
         DB::table('medicalcouncils')->insert(['name'=>'JHARKHAND']);
         DB::table('medicalcouncils')->insert(['name'=>'KARNATAKA']);
         DB::table('medicalcouncils')->insert(['name'=>'KERALA']);
         DB::table('medicalcouncils')->insert(['name'=>'MADHYA PRADESH']);
         DB::table('medicalcouncils')->insert(['name'=>'MADRAS']);
         DB::table('medicalcouncils')->insert(['name'=>'MAHARASHTRA']);
         DB::table('medicalcouncils')->insert(['name'=>'MANIPUR']);
         DB::table('medicalcouncils')->insert(['name'=>'MEDICAL COUNCIL OF INDIA']);
         DB::table('medicalcouncils')->insert(['name'=>'ORISSA']);
         DB::table('medicalcouncils')->insert(['name'=>'PUNJAB']);
         DB::table('medicalcouncils')->insert(['name'=>'RAJASTHAN']);
         DB::table('medicalcouncils')->insert(['name'=>'SIKKIM']);
         DB::table('medicalcouncils')->insert(['name'=>'TAMIL NADU']);
         DB::table('medicalcouncils')->insert(['name'=>'TELANGANA']);
         DB::table('medicalcouncils')->insert(['name'=>'TRIPURA']);
         DB::table('medicalcouncils')->insert(['name'=>'TRIVANDRUM']);
         DB::table('medicalcouncils')->insert(['name'=>'UTTAR PRADESH']);
         DB::table('medicalcouncils')->insert(['name'=>'UTTRAKHAND']);
         DB::table('medicalcouncils')->insert(['name'=>'UTTARANCHAL']);
         DB::table('medicalcouncils')->insert(['name'=>'WEST BENGAL']);
         

    }
}
