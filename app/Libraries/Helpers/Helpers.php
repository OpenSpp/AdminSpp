<?php

function rupiah($number){
	$result_rupiah = "Rp " . number_format($number,2,',','.');
	return $result_rupiah;
}