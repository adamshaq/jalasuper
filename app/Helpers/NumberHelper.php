<?php 
if ( ! function_exists('rupiah')){
    function rupiah($angka){
        $hasil_rupiah = "Rp " . number_format($angka,2,',','.');
        return $hasil_rupiah;
    
    }
}

if ( ! function_exists('uang')){
    function uang($angka){
        return str_replace(',00','',str_replace('.','',$angka));
    }
}

if ( ! function_exists('decimal')){
    function decimal($angka){
        return str_replace(',','.',$angka);
    }
}
