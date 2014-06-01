<?php

require_once '../../TCPDF/config/lang/eng.php';
require_once '../../TCPDF/tcpdf.php';

/**
 * Export array to table in PDF.
 * 
 * 
 * sample:
 *  $pdf = new XsPdfExporter('L');
    $pdf->setHeaders(array('Adres www', 'Login', 'Imię', 'Nazwisko', 'Hasło', 'Stan konta', 'Pp'));
    $pdf->setData($array);
    $pdf->setAuthor('Etd');
    $pdf->setTitle('Lista użytkowników');
    $pdf->Output('lista.pdf', 'I');
 *
 * @author nerd
 * @version 2009-08-07
 * @see README
 */
class Etd_Pdf_Table extends TCPDF
{
  private $headers = array();
  private $data = array();

  public $fontMonospaced = PDF_FONT_MONOSPACED;
  public $fontNameMain = PDF_FONT_NAME_MAIN;
  public $fontSizeMain = PDF_FONT_SIZE_MAIN;
  public $fontNameData = PDF_FONT_NAME_DATA;
  public $fontSizeData = PDF_FONT_SIZE_DATA;
  public $font = 'dejavusans-extralight';
  public $fontSize = 10;

  public function __construct($orientation = 'P', $unit = 'mm', $format = 'A4', $unicode = true, $encoding = 'UTF-8', $diskcache = false)
  {
    // create new PDF document
    parent::__construct($orientation, $unit, $format, $unicode, $encoding, $diskcache);

    // set defaults
    $this->configure();
  }

  private function configure()
  {
    // set document information
    $this->SetCreator(PDF_CREATOR);

    // set default header data
    $this->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);

    // set header and footer fonts
    if (!is_null($this->fontNameMain)) {
      $this->setHeaderFont(Array($this->fontNameMain, '', $this->fontSizeMain));
    }
    if (!is_null($this->fontNameData)) {
      $this->setFooterFont(Array($this->fontNameData, '', $this->fontSizeData));
    }

    // set default monospaced font
    if (!is_null($this->fontMonospaced)) {
      $this->SetDefaultMonospacedFont($this->fontMonospaced);
    }
    //set margins
    $this->SetMargins(PDF_MARGIN_LEFT, 18, PDF_MARGIN_RIGHT);
    $this->SetHeaderMargin(5);
    $this->SetFooterMargin(PDF_MARGIN_FOOTER);

    //set auto page breaks
    $this->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

    //set image scale factor
    $this->setImageScale(PDF_IMAGE_SCALE_RATIO); 

    //set some language-dependent strings
    $this->setLanguageArray($GLOBALS['l']);

    // set font
    if ($this->font) {
      $this->SetFont($this->font, '', $this->fontSize);
    }
  }

  private function preparePdf()
  {
    // add a page
    $this->AddPage();

    // add content
    $this->writeHTML($this->_getHtml());
  }

  public function Output($name = 'doc.pdf', $dest = 'I')
  {
    $this->preparePdf();

    parent::Output($name, $dest);
  }

  public function Header()
  {
    // Set font
    //$this->SetFont('freesans', '', 20);
    $this->SetFont($this->font, 'B', 20);
    // Title
    if ($this->CurOrientation == 'L')
    {
      $this->Cell(205, 10, $this->title, 'B', 0, 'L');
    }
    else
    {
      $this->Cell(120, 10, $this->title, 'B', 0, 'L');
    }
    // Set font
    $this->SetFontSize(10);
    // Datetime
    $this->Cell(60, 10, strftime('%c'), 'B', 0, 'R');
    // Line break
    $this->Ln(3);
  }

  public function Footer()
  {
    // Position at 1.5 cm from bottom
    $this->SetY(-15);
    // Set font
    $this->SetFont($this->font, '', 8);
    // Page number
    $this->Cell(0, 7, 'Strona '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 'T', 0, 'R');
  }

  public function setHeaders(array $headers)
  {
    $this->headers = $headers;
  }
  
  public function getHeaders()
  {
    return $this->headers;
  }
  
  public function setData(array $data)
  {
    $this->data = $data;
  }
  
  public function getData()
  {
    return $this->data;
  }
  
  private function _getHtml()
  {
    ob_start();
    
    include "Table.tpl.php";
    
    $out = ob_get_contents();

    ob_end_clean();
    
    return $out;
    
  }

}
