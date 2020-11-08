<?php
namespace App\Model;

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
                $datesArray[] = \DateTime::createFromFormat("Y-n-j", "{$this->year}-$m-$d");
            }
        }
        return $datesArray;
    }

    public function getDays() 
    {
        return $this->days;
    }

    public function getMonth(int $m)
    {
        $days = array();
        foreach($this->days as $d) 
        {
            if (((int)$d->getMonth())<10)
            {
                $mese = "0".$d->getMonth();
            } else {
                $mese = $d->getMonth();
            }
            if($mese == $m)
            {
                $days[] = $d;
            }
        }
        return $days;
    }
}