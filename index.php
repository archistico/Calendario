<?php

class Giorno 
{
    private $giorno;
    private $mese;
    private $anno;
    
    private $giorno_settimana;
    private $giorno_settimana_numerico;

    public function __construct(DateTime $data)
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
}

class Calendario 
{

    private $year;
    private $days;

    public function __construct(int $year)
    {
        $this->year = $year;
        $this->days = array();
        foreach($this->loadDays() as $d) {
            $this->days[] = new Giorno($d);
        }
    }

    private function loadDays()
    {
        $datesArray = array();

        for($m=1; $m<=12; $m++)
        {
            $number_days = cal_days_in_month( 0, $m, $this->year);
            for($d=1; $d<=$number_days; $d++)
            {
                $datesArray[] = DateTime::createFromFormat("Y-n-j", "{$this->year}-$m-$d");
            }
        }
        return $datesArray;
    }

    public function getDays() 
    {
        return $this->days;
    }
}


class Pdf 
{
    private $calendario;

    public function __construct(int $year) 
    {
        $this->calendario = new Calendario($year);
    }
}

$pdf = new Pdf(2019);
