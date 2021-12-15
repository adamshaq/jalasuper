<?php

use Illuminate\Database\Seeder;

class ComCodeTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('com_code')->delete();
        
        \DB::table('com_code')->insert(array (
            0 => 
            array (
                'com_cd' => 'FILE_TP_1',
                'code_nm' => 'Register Ereg',
                'code_group' => 'FILE_TP',
                'code_value' => NULL,
                'created_by' => 'seeder',
                'updated_by' => NULL,
                'created_at' => '2019-12-01 19:36:59',
                'updated_at' => NULL,
            ),
            1 => 
            array (
                'com_cd' => 'FILE_TP_2',
                'code_nm' => 'Register DJP9',
                'code_group' => 'FILE_TP',
                'code_value' => '',
                'created_by' => 'seeder',
                'updated_by' => NULL,
                'created_at' => '2019-12-01 19:36:59',
                'updated_at' => NULL,
            ),
            2 => 
            array (
                'com_cd' => 'FILE_TP_3',
                'code_nm' => 'Register Infomon SPT LB',
                'code_group' => 'FILE_TP',
                'code_value' => '',
                'created_by' => 'seeder',
                'updated_by' => '',
                'created_at' => '2019-12-01 19:36:59',
                'updated_at' => NULL,
            ),
            3 => 
            array (
                'com_cd' => 'NOTIFICATION_TP_0',
                'code_nm' => 'TIDAK PERLU PEMBERITAHUAN',
                'code_group' => 'NOTIFICATION_TP',
                'code_value' => NULL,
                'created_by' => 'seeder',
                'updated_by' => NULL,
                'created_at' => '2019-12-24 10:07:42',
                'updated_at' => NULL,
            ),
            4 => 
            array (
                'com_cd' => 'NOTIFICATION_TP_1',
                'code_nm' => 'PERLU PEMBERITAHUAN',
                'code_group' => 'NOTIFICATION_TP',
                'code_value' => '',
                'created_by' => 'seeder',
                'updated_by' => '',
                'created_at' => '2019-12-24 10:07:39',
                'updated_at' => NULL,
            ),
            5 => 
            array (
                'com_cd' => 'PROSES_ST_0',
                'code_nm' => 'TIDAK DISETUJUI',
                'code_group' => 'PROSES_ST',
                'code_value' => NULL,
                'created_by' => 'seeder',
                'updated_by' => NULL,
                'created_at' => '2019-11-19 10:35:51',
                'updated_at' => NULL,
            ),
            6 => 
            array (
                'com_cd' => 'PROSES_ST_1',
                'code_nm' => 'DALAM PROSES',
                'code_group' => 'PROSES_ST',
                'code_value' => NULL,
                'created_by' => 'seeder',
                'updated_by' => NULL,
                'created_at' => '2019-11-19 10:35:51',
                'updated_at' => NULL,
            ),
            7 => 
            array (
                'com_cd' => 'PROSES_ST_2',
                'code_nm' => 'SELESAI PROSES',
                'code_group' => 'PROSES_ST',
                'code_value' => NULL,
                'created_by' => 'seeder',
                'updated_by' => NULL,
                'created_at' => '2019-11-19 10:35:51',
                'updated_at' => NULL,
            ),
            8 => 
            array (
                'com_cd' => 'PROSES_ST_3',
                'code_nm' => 'DITERUSKAN KE KANWIL',
                'code_group' => 'PROSES_ST',
                'code_value' => '',
                'created_by' => 'seeder',
                'updated_by' => '',
                'created_at' => '2019-11-19 10:35:51',
                'updated_at' => NULL,
            ),
            9 => 
            array (
                'com_cd' => 'PROSES_ST_9',
                'code_nm' => 'PEMBERITAHUAN TERKIRIM',
                'code_group' => 'PROSES_ST',
                'code_value' => NULL,
                'created_by' => 'seeder',
                'updated_by' => NULL,
                'created_at' => '2019-11-19 10:35:51',
                'updated_at' => NULL,
            ),
            10 => 
            array (
                'com_cd' => 'USER_TP_1',
                'code_nm' => 'Super User',
                'code_group' => 'USER_TP',
                'code_value' => NULL,
                'created_by' => 'seeder',
                'updated_by' => NULL,
                'created_at' => '2019-12-01 19:35:06',
                'updated_at' => NULL,
            ),
            11 => 
            array (
                'com_cd' => 'USER_TP_2',
                'code_nm' => 'Administrator',
                'code_group' => 'USER_TP',
                'code_value' => NULL,
                'created_by' => 'seeder',
                'updated_by' => NULL,
                'created_at' => '2019-12-01 19:35:06',
                'updated_at' => NULL,
            ),
            12 => 
            array (
                'com_cd' => 'USER_TP_3',
                'code_nm' => 'Pegawai',
                'code_group' => 'USER_TP',
                'code_value' => NULL,
                'created_by' => 'seeder',
                'updated_by' => NULL,
                'created_at' => '2019-12-01 19:35:06',
                'updated_at' => NULL,
            ),
        ));
        
        
    }
}