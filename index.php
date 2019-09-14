<?php
require 'vendor/autoload.php';

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

    public function getDay() 
    {
        return $this->giorno;
    }

    public function getMonth() 
    {
        return $this->mese;
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

$pdf = new FPDF();

$cal = new Calendario(2020);

$pageWidth = 297;
$pageHeight = 210;
$margin = 5;
$gutter = 2;
$header = 20;

$width = $pageWidth - 2*$margin;
$height = $pageHeight - 2*$margin;
$columnWidth = ($width - 11*$gutter) / 12;
$columnHeight = $height - $header;
$rowMargin = 1;
$rowHeight = ($columnHeight - 1*$rowMargin) / 31;
$rowPadding = 1.5;
$textNumberHeight = 3;

$pdf->AddPage('L', [$pageWidth,$pageHeight]);
$pdf->SetMargins($margin, $margin, $margin);

$pdf->SetFont('Arial','B',10);

for($c = 0; $c<12 ; $c++) {
    $xColumn = $margin + $c*($columnWidth+$gutter);
    $yColumn = $margin + $header;
    $pdf->SetFillColor(196);
    //$pdf->Rect($xColumn,$yColumn,$columnWidth,$columnHeight,'F');
    $mese = $cal->getMonth($c+1);

    for($r = 0; $r<count($mese) ; $r++) {
        $pdf->SetFillColor(180);
        $yRow = $yColumn + $r * $rowHeight + $rowMargin;
        //$pdf->Rect($xColumn+$rowMargin,$yRow,$columnWidth-2*$rowMargin,$rowHeight-$rowMargin,'F');
        //$pdf->SetXY($xColumn+$rowMargin,$yRow);
        $pdf->Line($xColumn, $yRow+$rowHeight, $xColumn+$columnWidth, $yRow+$rowHeight);
        
        
        // Numero del mese
        $pdf->SetFont('Arial','B',10);
        $pdf->Text($xColumn+$rowMargin+$rowPadding,$yRow+$textNumberHeight+$rowPadding,$r+1);
        
        // Giorno della settimana
        $pdf->SetFont('Arial','',10);
        $pdf->Text($xColumn+$rowMargin+$rowPadding+5,$yRow+$textNumberHeight+$rowPadding,$mese[$r]->getDayOfWeek());
    }
}

/*
//$filename="./test.pdf";
//$pdf->Output($filename,'F');
*/

$pdf->Output();