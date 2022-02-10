<?php
namespace App\Controllers;

class Calendario
{
    public function CreaAnni() {
        $anni = [];

        $anno_in_corso = date("Y");
        if(is_numeric($anno_in_corso)) {
            $anno_in_corso = intval($anno_in_corso);
            for($c = 0; $c<3 ; $c++) {
                $anni[] = $anno_in_corso + $c;
            }
        }
        return $anni;
    }
    public function Homepage($f3)
    {
        $anni = $this->CreaAnni();
        $f3->set('anni', $anni);
        echo \Template::instance()->render('app/templates/homepage.htm');
    }

    public function Pdf($f3, $params)
    {
        $anno = $params['anno'];
        if(is_numeric($anno) && $anno >= 1000 & $anno <= 3000) {
            \App\Model\Pdf::Make($anno);
        } else {
            $f3->reroute('@home');
        }        
    }
}