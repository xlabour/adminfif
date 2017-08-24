<?php
$WEB_TITLE = 'Registrasi Pengajuan Kredit FIF';
$DB_HOST = getenv('MYSQL_SERVICE_HOST');
$DB_NAME = getenv('MYSQL_DATABASE');
$DB_USERNAME = getenv('MYSQL_USER');
$DB_PASSWORD = getenv('MYSQL_PASSWORD');

//field definition
$arrFieldProp = array(
	'nama'=>array('field'=>'nama','mandatory'=>true),
	'lahir_tempat'=>array('field'=>'lahir_tempat','mandatory'=>true),
	'lahir_tanggal'=>array('field'=>'lahir_tanggal','mandatory'=>true),
	'alamat'=>array('field'=>'alamat','mandatory'=>true),
	'notelp'=>array('field'=>'notelp','mandatory'=>true),
	'jenis_kelamin'=>array('field'=>'jenis_kelamin','mandatory'=>true),
	'email'=>array('field'=>'email','mandatory'=>true),
	'pekerjaan'=>array('field'=>'pekerjaan','mandatory'=>true),
	'status_rumah'=>array('field'=>'status_rumah','mandatory'=>true),
	'pendidikan'=>array('field'=>'pendidikan','mandatory'=>true),
	'marital_status'=>array('field'=>'marital_status','mandatory'=>true),
	'tanggungan'=>array('field'=>'tanggungan','mandatory'=>true),
	'object'=>array('field'=>'object','mandatory'=>true),
	'dp'=>array('field'=>'dp','mandatory'=>true),
	'angsuran'=>array('field'=>'angsuran','mandatory'=>true),
	'top'=>array('field'=>'top','mandatory'=>true)
);

?>