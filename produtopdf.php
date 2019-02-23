<?php
require('fpdf/fpdf.php');
class PDF extends FPDF
{
// Load data
function LoadData($file)
{
    // Read file lines
    $lines = file($file);
    $data = array();
    foreach($lines as $line)
        $data[] = explode(';',trim($line));
    return $data;
}

// Colored table
function FancyTable($header, $data)
{
    // Colors, line width and bold font
    $this->SetFillColor(0,0,0);
    $this->SetTextColor(255);
    $this->SetDrawColor(0,0,0);
    $this->SetLineWidth(.3);
    $this->SetFont('','B');
    // Header
    $w = array(30, 200, 260, 100, 100, 100);
    for($i=0;$i<count($header);$i++)
        $this->Cell($w[$i],20,$header[$i],1,0,'C',true);
    $this->Ln();
    // Color and font restoration
    $this->SetFillColor(205,205,205);
    $this->SetTextColor(0);
    $this->SetFont('');
    // Data
    $fill = false;
    foreach($data as $row)
    {
        $this->Cell($w[0],18,$row[0],'LR',0,'C',$fill);
        $this->Cell($w[1],18,$row[1],'LR',0,'L',$fill);
        $this->Cell($w[2],18,$row[2],'LR',0,'L',$fill);
        $this->Cell($w[3],18,$row[3],'LR',0,'L',$fill);
        $this->Cell($w[4],18,$row[4],'LR',0,'L',$fill);
        $this->Cell($w[5],18,$row[5],'LR',0,'R',$fill);
        $this->Ln();
        $fill = !$fill;
    }
    // Closing line
    $this->Cell(array_sum($w),0,'','T');
}
}

$pdf = new PDF("L", "pt", "A4");   
// Column headings
$header = array('ID', 'Modelo', 'Descrição', 'Sub-Categoria', 'Fabricante', 'Custo');
// Data loading
$data = $pdf->LoadData('produto.txt');
$pdf->SetFont('Arial','',10);
$pdf->AddPage();
$pdf->FancyTable($header,$data);
$pdf->Output();
?>