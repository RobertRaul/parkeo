<?php

namespace App\Http\Controllers\Reportes;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Codedge\Fpdf\Fpdf\Fpdf;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\Empresa;

class PDF extends Fpdf
{
    private $titul, $caj_id, $user_id, $tipo_hoja, $tipo_report;
    private $logo_ruta;

    public function Cabecera($titulo, $caj_id, $user_id, $tipo_hoja, $tipo_report)
    {
        $this->titul = $titulo;
        $this->caj_id = $caj_id;
        $this->user_id = $user_id;
        $this->tipo_hoja = $tipo_hoja;
        $this->tipo_report=$tipo_report;

        $emp=Empresa::findOrFail(1);
        if($emp->empr_logo == null)
            $this->logo_ruta=asset('images/logo/no_logo.png');
        else
            $this->logo_ruta=asset('images/logo/'.$emp->empr_logo);
    }
    // Cabecera de página
    function Header()
    {
        //Si el reporte es de tipo "REPORTES" mostrara esta cabecera
        if ($this->tipo_report == 'Reportes')
        {
                // Logo
               //$this->Image(asset('images/parkeo/parking.png'), 10, 5, 20);
               $this->Image($this->logo_ruta, 10, 5, 30 , 20);
                $this->SetFont('Arial', 'B', 15);

                $this->Cell(80);
                $this->Cell(30, 6, $this->titul, 0, 0, 'C');
                $this->SetFont('Arial', '', 11);
                $this->Cell(85, 6, 'Fecha:' . Carbon::now()->format('d/m/Y'), 0, 0, 'R');
                $this->Ln();
                $this->Cell(80);
                $this->Cell(115, 6, 'Hora:' . Carbon::now()->format('H:i:s'), 0, 0, 'R');
                $this->Ln(15);
        }
        //Si el reporte es de tipo caja, mostrara esta cabecera
        else if ($this->tipo_report == 'Caja')
        {
            if ($this->tipo_hoja == 'L') //TIPO DE HOJA HORIZONTAL
            {
                // Logo
                //$this->Image(asset('images/parkeo/parking.png'), 10, 5, 20);
                $this->Image($this->logo_ruta, 10, 5, 30 , 20);
                $this->SetFont('Arial', 'B', 15);
                $this->Cell(120);
                $this->Cell(60, 6, $this->titul, 0, 0, 'C');
                $this->SetFont('Arial', '', 11);
                $this->Cell(100, 6, 'Fecha:' . Carbon::now()->format('d/m/Y'), 0, 0, 'R');
                $this->Ln();
                $this->Cell(120);
                $this->Cell(60, 6, 'Codigo: ' . $this->caj_id . ' - ' . 'Usuario: ' . $this->user_id, 0, 0, 'C');
                $this->Cell(100, 6, 'Hora:' . Carbon::now()->format('H:i:s'), 0, 0, 'R');
                $this->Ln(20);
            } else //TIPO DE HOJA  EN VERTICAL
            {
                // Logo
                //$this->Image(asset('images/parkeo/parking.png'), 10, 5, 20);
                $this->Image($this->logo_ruta, 10, 5, 30 , 20);
                $this->SetFont('Arial', 'B', 15);


                $this->Cell(80);
                $this->Cell(30, 6, $this->titul, 0, 0, 'C');
                $this->SetFont('Arial', '', 11);
                $this->Cell(85, 6, 'Fecha:' . Carbon::now()->format('d/m/Y'), 0, 0, 'R');
                $this->Ln();
                $this->Cell(80);
                $this->Cell(30, 6, 'Codigo: ' . $this->caj_id . ' - ' . 'Usuario: ' . $this->user_id, 0, 0, 'C');
                $this->Cell(85, 6, 'Hora:' . Carbon::now()->format('H:i:s'), 0, 0, 'R');
                $this->Ln(20);
            }
        }
    }

    // Pie de página
    function Footer()
    {
        // Posición: a 1,5 cm del final
        $this->SetY(-15);
        // Arial italic 8
        $this->SetFont('Arial', 'I', 8);
        // Número de página
        $this->Cell(0, 10, 'Pagina ' . $this->PageNo() . '/{nb}', 0, 0, 'C');
    }

    //--------------------------------- PROBANDO NUEVA ------------------------------//
    // variable to store widths and aligns of cells, and line height
    var $widths;
    var $aligns;
    var $lineHeight;


    //Set the array of column widths
    function SetWidths($w)
    {
        $this->widths = $w;
    }

    //Set the array of column alignments
    function SetAligns($a)
    {
        $this->aligns = $a;
    }

    //Set line height
    function SetLineHeight($h)
    {
        $this->lineHeight = $h;
    }

    //Calculate the height of the row
    function Row($data)
    {
        // number of line
        $nb = 0;

        // loop each data to find out greatest line number in a row.
        for ($i = 0; $i < count($data); $i++) {
            // NbLines will calculate how many lines needed to display text wrapped in specified width.
            // then max function will compare the result with current $nb. Returning the greatest one. And reassign the $nb.
            $nb = max($nb, $this->NbLines($this->widths[$i], $data[$i]));
        }

        //multiply number of line with line height. This will be the height of current row
        $h = $this->lineHeight * $nb;

        //Issue a page break first if needed
        $this->CheckPageBreak($h);

        //Draw the cells of current row
        for ($i = 0; $i < count($data); $i++) {
            // width of the current col
            $w = $this->widths[$i];
            // alignment of the current col. if unset, make it left.
            $a = isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';
            //Save the current position
            $x = $this->GetX();
            $y = $this->GetY();
            //Draw the border
            $this->Rect($x, $y, $w, $h);
            //Print the text
            $this->MultiCell($w, 5, $data[$i], 0, $a);
            //Put the position to the right of the cell
            $this->SetXY($x + $w, $y);
        }
        //Go to the next line
        $this->Ln($h);
    }

    function CheckPageBreak($h)
    {
        //If the height h would cause an overflow, add a new page immediately
        if ($this->GetY() + $h > $this->PageBreakTrigger)
            $this->AddPage($this->CurOrientation);
    }

    function NbLines($w, $txt)
    {
        //calculate the number of lines a MultiCell of width w will take
        $cw = &$this->CurrentFont['cw'];
        if ($w == 0)
            $w = $this->w - $this->rMargin - $this->x;
        $wmax = ($w - 2 * $this->cMargin) * 1000 / $this->FontSize;
        $s = str_replace("\r", '', $txt);
        $nb = strlen($s);
        if ($nb > 0 and $s[$nb - 1] == "\n")
            $nb--;
        $sep = -1;
        $i = 0;
        $j = 0;
        $l = 0;
        $nl = 1;
        while ($i < $nb) {
            $c = $s[$i];
            if ($c == "\n") {
                $i++;
                $sep = -1;
                $j = $i;
                $l = 0;
                $nl++;
                continue;
            }
            if ($c == ' ')
                $sep = $i;
            $l += $cw[$c];
            if ($l > $wmax) {
                if ($sep == -1) {
                    if ($i == $j)
                        $i++;
                } else
                    $i = $sep + 1;
                $sep = -1;
                $j = $i;
                $l = 0;
                $nl++;
            } else
                $i++;
        }
        return $nl;
    }


    function BasicTable($header, $data, $x = 0, $y = 0)
    {

        $this->SetXY($x, $y);

        // Header
        foreach ($header as $col)
            $this->Cell(40, 7, $col, 1);
        $this->Ln();

        // Data
        $i = 7;
        $this->SetXY($x, $y + $i);
        foreach ($data as $row) {
            foreach ($row as $col) {
                //$this->SetXY($x , $y + $i);
                $this->Cell(40, 6, $col, 1);
            }
            $i = $i + 6;  // incremento el valor de la columna
            $this->SetXY($x, $y + $i);
            //$this->Ln();
        }
    }
}
