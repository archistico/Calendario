<?php
namespace App\Model;

class Giorno 
{
    private $giorno;
    private $mese;
    private $anno;
    
    private $giorno_settimana;
    private $giorno_settimana_numerico;
    private $mese_nome;

    public function __construct(\DateTime $data)
    {
        $this->giorno = $data->format("d");
        $this->mese = $data->format("m");
        $this->anno = $data->format("Y");
        $this->giorno_settimana_numerico = $data->format("w");

        switch($this->giorno_settimana_numerico) {
            case 0: $this->giorno_settimana = "Do"; break;
            case 1: $this->giorno_settimana = "Lu"; break;
            case 2: $this->giorno_settimana = "Ma"; break;
            case 3: $this->giorno_settimana = "Me"; break;
            case 4: $this->giorno_settimana = "Gi"; break;
            case 5: $this->giorno_settimana = "Ve"; break;
            case 6: $this->giorno_settimana = "Sa"; break;
        }
    }

    private function getEasterDate($year = false){
        if($year === false) {
            $year = date("Y");
        }
        $easterDays = easter_days($year);
        $march21 = date($year . '-03-21');
        return \DateTime::createFromFormat('d-m-Y', date('d-m-Y', strtotime("$march21 + $easterDays days")));
    }

    public function isHoliday()
    {
        if( $this->giorno_settimana == "Do" || $this->giorno_settimana == "Sa" ) 
        {
            return true;
        }

        $pasqua = $this->getEasterDate($this->anno);
        
        if( $this->giorno == $pasqua->format('d') && $this->mese == $pasqua->format('m') )
        {
            return true;
        }

        $pasquetta = $pasqua->add(new \DateInterval('P1D'));
        
        if( $this->giorno == $pasquetta->format('d') && $this->mese == $pasquetta->format('m') )
        {
            return true;
        }

        if( $this->giorno == "01" && $this->mese == "01" )
        {
            return true;
        }

        if( $this->giorno == "06" && $this->mese == "01" )
        {
            return true;
        }

        if( $this->giorno == "25" && $this->mese == "04" )
        {
            return true;
        }

        if( $this->giorno == "01" && $this->mese == "05" )
        {
            return true;
        }

        if( $this->giorno == "02" && $this->mese == "06" )
        {
            return true;
        }

        if( $this->giorno == "15" && $this->mese == "08" )
        {
            return true;
        }

        if( $this->giorno == "01" && $this->mese == "11" )
        {
            return true;
        }

        if( $this->giorno == "08" && $this->mese == "12" )
        {
            return true;
        }

        if( $this->giorno == "25" && $this->mese == "12" )
        {
            return true;
        }

        if( $this->giorno == "26" && $this->mese == "12" )
        {
            return true;
        }

        return false;
    }

    public function getDay() 
    {
        return $this->giorno;
    }

    public function getMonth() 
    {
        return $this->mese;
    }

    public static function getMonthName(int $month)
    {
        switch($month)
        {
            case 1: return 'Gennaio';
            case 2: return 'Febbraio';
            case 3: return 'Marzo';
            case 4: return 'Aprile';
            case 5: return 'Maggio';
            case 6: return 'Giugno';
            case 7: return 'Luglio';
            case 8: return 'Agosto';
            case 9: return 'Settembre';
            case 10: return 'Ottobre';
            case 11: return 'Novembre';
            case 12: return 'Dicembre';
        }
    }

    public function getYear() 
    {
        return $this->anno;
    }

    public function getDayOfWeek() 
    {
        return $this->giorno_settimana;
    }
}