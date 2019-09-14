<?php

function getEasterDate($year = false){
    if($year === false) {
        $year = date("Y");
    }
    $easterDays = easter_days($year);
    $march21 = date($year . '-03-21');
    return DateTime::createFromFormat('d-m-Y', date('d-m-Y', strtotime("$march21 + $easterDays days")));
}

var_dump(getEasterDate(2020)->format('d'));
var_dump(getEasterDate(2020)->format('m'));

$pasqua = getEasterDate(2020);
var_dump( "12" == $pasqua->format('d'));
var_dump( "04" == $pasqua->format('m'));

$pasquetta = $pasqua->add(new DateInterval('P1D'));
var_dump($pasquetta);