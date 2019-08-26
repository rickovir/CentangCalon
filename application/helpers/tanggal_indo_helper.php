<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
date_default_timezone_set("Asia/Jakarta");

if(!function_exists('tgl_indo')){
	function tgl_indo($tgl){
		$tanggal = substr($tgl,8,2);
		$bulan = bulan(substr($tgl,5,2));
		$tahun = substr($tgl,0,4);
		return $tanggal.' '.$bulan.' '.$tahun;
	}
}

if(!function_exists('bulan')){
	function bulan($bln){
		switch($bln){
			case 1:
			return "Januari";
			break;
			case 2:
			return "Februari";
			break;
			case 3:
			return "Maret";
			break;
			case 4:
			return "April";
			break;
			case 5:
			return "Mei";
			break;
			case 6:
			return "Juni";
			break;
			case 7:
			return "Juli";
			break;
			case 8:
			return "Agustus";
			break;
			case 9:
			return "September";
			break;
			case 10:
			return "Oktober";
			break;
			case 11:
			return "November";
			break;
			case 12:
			return "Desember";
			break;
		}
	}
}
if(!function_exists('hari')){
	function hari($hari){
		switch ($hari){
			case 0:
			return "Minggu";
			break;
			case 1:
			return "Senin";
			break;
			case 2:
			return "Selasa";
			break;
			case 3:
			return "Rabu";
			break;
			case 4:
			return "Kamis";
			break;
			case 5:
			return "Jumat";
			break;
			case 6:
			return "Sabtu";
			break;
		}
	}
}
?>