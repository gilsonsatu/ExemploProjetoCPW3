<?php
require_once './relatorios/fpdf/fpdf.php';

class RelUsuario {
    private $pdf;
    
    public function __construct() {
        $this->pdf = new FPDF("P", "pt", "A4");
        $this->pdf->AddPage();
        $this->pdf->SetFont("Arial", "", 12);
    }

    private function cabecalho() {
        $this->pdf->SetFont("Arial", "B", 16);
        $this->pdf->Cell(540, 20, "Sistema de Vendas", 1, 0, "C");
        $this->pdf->SetFont("Arial", "", 12);
        $this->pdf->ln(40);
    }
    
    private function titulos() {
        $this->pdf->SetFont("Arial", "B", 12);
        $this->pdf->Cell(110, 20, "Id.", 1, 0, "L");
        $this->pdf->Cell(430, 20, "E-mail", 1, 0, "L");
        $this->pdf->SetFont("Arial", "", 12);
        $this->pdf->ln(20);
    }

    private function lista($lista) {
        foreach ($lista as $usuario) {
            $this->pdf->Cell(110, 20, $usuario->getId(), 1, 0, "L");
            $this->pdf->Cell(430, 20, $usuario->getEmail(), 1, 0, "L");
            $this->pdf->ln(20);
        }
    }
    
    public function imprimir($lista) {
        $this->cabecalho();
        $this->titulos();
        $this->lista($lista);
        //ob_start(); // alguns servidores Web precisam desta linha
        $this->pdf->Output();
    }

}
