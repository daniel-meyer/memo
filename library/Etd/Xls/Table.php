<?php
require_once('../../Spreadsheet/Excel/Writer.php');

/**
 * A class to handle exporting Doctrine_Collection objects to XLS files
 *
 * @author Paweł Skiścim
 * @version 2009-07-02
 *
 */

class Etd_Xls_Table
{

  /**
   * Function exporting array of data to xls
   *
   * @author Pawel
   * @version 2009-07-09
   * @param array() $collection - array of data to be exported
   * @param array() $headers - array of optional headers
   */

  public static function export2xls($collection, $headers = array(), $filename = null)
  {
    error_reporting(0); //to avoid printing strict standards warnings

    
   
    $workbook = new Spreadsheet_Excel_Writer();
    $workbook->setVersion(8);

    $just_bold = $workbook->addFormat();
    $just_bold->setBold();

    // File name
    if(null == $filename){
        $filename = 'export '.date('d-m-Y h:i').'.xls';
    }
    
    $workbook->send($filename);

    $worksheet = $workbook->addWorksheet('Worksheet');

  // Coding
  // 'cp-1250', 'UTF-8'
    $worksheet->setInputEncoding('UTF-8');

  //set headers of the table
    if(!empty($headers))
    {
      $int_colCounter = 0;
      foreach($headers as $head)
      {
        $worksheet->writeString(0,$int_colCounter, $head, $just_bold);
        $int_colCounter++;
      }
    }

    $int_colCounter = 0;
    $int_rowCounter = 1;
    
    foreach($collection as $col)
    {
      foreach($col as $c)
      {
        if($c === true)
        {
          $worksheet->writeString($int_rowCounter,$int_colCounter, 'v');
        }
        elseif($c === false)
        {
          $worksheet->writeString($int_rowCounter,$int_colCounter, '--');
        }
        else
        {
          $worksheet->writeString($int_rowCounter,$int_colCounter, $c);
        }
        $int_colCounter++;
      }
      $int_colCounter = 0;
      $int_rowCounter++;
    }

    $workbook->close();
  }
}
