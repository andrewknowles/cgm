<?php
//this program produces a parts replacement file
//set time limit to avoid timeout in long process
set_time_limit(0);
//open input file in read only mode
//this is full file
$file     = fopen("c:/tmp/CGMPP_Surmac_12637_FullFile.txt", "r");
//$file     = fopen("c:/tmp/cgmtest.txt", "r");
//open output file in append mode
$fileout  = fopen("c:/tmp/SurmacCGMCAPReplace17102014.unl", "a");
$lastline = '';
//read first line from input file file
$line     = fgets($file);

//initial look through all records in the file
while (!feof($file))
  {
    if (substr($line, 45, 1) == 3 && substr($line, 71, 2) == 'AA')
      {
        $pro_id_a = trim(substr($line, 24, 20));
        $pro_id_b = trim(substr($line, 47, 20));
        
        //Caterpillar part number will be presented in two formats when Part Type "AA".
        //Part Numbers with alpha characters are stored with a blank preceding the
        //six characters. Part number 1A2345 is stored as b1A2345 where b is a blank position.
        //Six positions part numbers with all numeric characters have a zero
        //inserted in the first position. Part number 123456 becomes 0123456.
        
        //If part no has no alpha characters and is 7 characters long and first character = 0 remove leading zero
        if (!ctype_alpha(trim($pro_id_b)) && strlen(trim($pro_id_b)) == 7 && substr(trim($pro_id_b), 0, 1) == 0)
          {
            $pro_id_b = substr(trim($pro_id_b), 1, 6);
          }
        
        // If part number has alpha character and is 7 characters long remove leading blank
        if (ctype_alpha(trim($pro_id_b)) && strlen($pro_id_b) == 7)
          {
            $pro_id_b = trim($pro_id_b);
          }
        
        
        echo '02|CMP|' . $pro_id_a . '|CAP|' . $pro_id_b . '|0|1|1|2014-10-15 00:00:00|10/10/14||1|0|0|0000|0|0|0|0|CMPCAP||~~~~||</BR>';
        $outline = '02|CMP|' . $pro_id_a . '|CAP|' . $pro_id_b . '|0|1|1|2014-10-15 00:00:00|10/10/14||1|0|0|0000|0|0|0|0|CMPCAP||~~~~||';
        fwrite($fileout, $outline . "\r\n");
      }
    $line = fgets($file);
  }

fclose($file);
fclose($fileout);

?>