<?php
namespace App\Model;

class Pdf {
    public static function Make($year){
        $pdf = new \FPDF();
$cal = new \App\Model\Calendario($year);

$pageWidth = 297;
$pageHeight = 210;
$margin = 5;
$gutter = 2;
$header = 10;

$width = $pageWidth - 2*$margin;
$height = $pageHeight - 2*$margin;
$columnWidth = ($width - 11*$gutter) / 12;
$columnHeight = $height - $header;
$rowMargin = 1;
$rowHeight = ($columnHeight - 1*$rowMargin) / 31;
$rowPadding = 0.5;
$rowWidthNumber = 5;
$textNumberHeight = 3;

$pdf->AddPage('L', [$pageWidth,$pageHeight]);
$pdf->SetMargins($margin, $margin, $margin);

$pdf->SetFont('Arial','B',20);
$pdf->Text($margin + $width/2 -10, $margin + $header/2,$year);

for($c = 0; $c<12 ; $c++) {
    $xColumn = $margin + $c*($columnWidth+$gutter);
    $yColumn = $margin + $header;
    $pdf->SetFillColor(196);
    //$pdf->Rect($xColumn,$yColumn,$columnWidth,$columnHeight,'F');
    $mese = $cal->getMonth($c+1);
    $meseNome = Giorno::getMonthName($c+1);
    $pdf->SetFont('Arial','B',11);
    $pdf->Text($xColumn,$yColumn,($meseNome));

    for($r = 0; $r<count($mese) ; $r++) {
        $pdf->SetFillColor(180);
        $yRow = $yColumn + $r * $rowHeight + $rowMargin;
        
        if($mese[$r]->isHoliday())
        {
            $pdf->SetFillColor(230);
            $pdf->Rect($xColumn,$yRow+$rowPadding,$columnWidth,$rowHeight-2*$rowPadding,'F');
        }
        
        //$pdf->SetXY($xColumn+$rowMargin,$yRow);
        $pdf->Line($xColumn, $yRow+$rowHeight, $xColumn+$columnWidth, $yRow+$rowHeight);
        
        // Numero del mese
        $pdf->SetFont('Arial','B',10);
        $pdf->Text($xColumn,$yRow+$textNumberHeight+$rowPadding,$mese[$r]->getDay());
        
        // Giorno della settimana
        $pdf->SetFont('Arial','',9);
        $pdf->Text($xColumn+$rowWidthNumber,$yRow+$textNumberHeight+$rowPadding,$mese[$r]->getDayOfWeek());
    }
}

/*
//$filename="./test.pdf";
//$pdf->Output($filename,'F');
*/

$pdf->Output();
    }
}