<?php
//this program produces a parts replacement file
//set time limit to avoid timeout in long process
set_time_limit(0);
//open input file in read only mode
//this is full file
$file     = fopen("c:/tmp/CGMPP_Surmac_12637_FullFile.txt", "r");
//$file     = fopen("c:/tmp/cgmtest.txt", "r");
//open output file in append mode
$fileout  = fopen("c:/tmp/SurmacCGMCMPReplace17102014.unl", "a");
$lastline = '';
//read first line from input file file
$line     = fgets($file);

//initial look through all records in the file
while (!feof($file))
  {
    if (substr($line, 45, 1) == 3 && substr($line, 71, 2) == 'BE')
      {
        $pro_id_a = trim(substr($line, 24, 20));
        $pro_id_b = trim(substr($line, 47, 20));
        echo '02|CMP|' . $pro_id_a . '|CMP|' . $pro_id_b . '|0|1|1|2014-10-15 00:00:00|10/10/14||1|0|0|0000|0|0|0|0|CMPCMP||~~~~||</BR>';
        $outline = '02|CMP|'.$pro_id_a.'|CMP|'.$pro_id_b.'|0|1|1|2014-10-15 00:00:00|10/10/14||1|0|0|0000|0|0|0|0|CMPCMP||~~~~||';
        fwrite($fileout, $outline."\r\n");
      }
    $line = fgets($file);
  }

fclose($file);
fclose($fileout);

?>