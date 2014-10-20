<?php

set_time_limit ( 0 );
$filein     = fopen("c:/tmp/CGMPP_Surmac_12637_FullFile.txt", "r");
$fileout     = fopen("c:/tmp/SurmacCGMFull14102014.txt", "w");
$lastline = '';
$line     = fgets($filein);
$outflag2 = 0;
$outflag3 = 0;
$outline = '';
$outline2 = '';
$outline3 = '';

	while (!feof($filein))
  {
  	if (trim(substr($line, 91,1)) == 'Y' && $outline = substr($line, 45, 1) == 1)
  	{
  		$return = 0;
  	}
  	else
  	{
  		$return = 1;
  	}
        
        switch (substr($line, 45, 1))
        {
        	
        
            case 1:
               //linetype
            	$outline = substr($line, 45, 1) . '|'.
//Vendor Identifier - Manufacturer Code
                trim(substr($line, 0, 10)) . '|'.
//Part Number
              	trim(substr($line, 24, 20)) . '|'.
//Description
                trim(substr($line, 55,30)) . '|'.
//Material Pricing Group
                trim(substr($line, 86,2)) . '|'.
//Non-returnable Indicator
                $return . '|'.
//Replacement Code
                trim(substr($line, 92,1)) . '|'.
//Replacement Type
                trim(substr($line, 93,1)) . '|'.
//Minimum Order Qty
                trim(substr($line, 94,5)) . '|'.
//Net weight
                trim(substr($line, 118,9)) . '|'.
//Gross weight
                trim(substr($line, 127,9)) . '|'.
//Length
                trim(substr($line, 136,5)) . '|'.
//Width
                trim(substr($line, 141,5)) . '|'.
//Height
                trim(substr($line, 146,5)) . '|'.
//Unit of measure
                trim(substr($line, 151,2)) . '|'.
//Hazardous Indicator
                trim(substr($line, 153,1)) . '|'.
//Activity Indicator
                trim(substr($line, 155,1)) . '|'.
//Reman Part
                trim(substr($line, 156,1)) . '|'.
//Hose Assy
                trim(substr($line, 157,1)) . '|';
                break;
            case 2:
 //Implementation Date
                $outline2 =  trim(substr($line, 47, 8)) . '|' .
//Component Unit Cost - Dealer Net
                trim(substr($line, 55, 13)). '|' .
//Component Unit List
                trim(substr($line, 68, 13)). '|'.
//Core Full Unit Cost
                trim(substr($line, 81, 13)). '|' .
//Core Full Unit List
                trim(substr($line, 94, 13)). '|' .
//Core Damaged Unit Cost
                trim(substr($line, 107, 13)). '|' .
//Core Damaged Unit List
                trim(substr($line, 120, 13)). '|' .
//Currency Indicator
                trim(substr($line, 133, 3)). '|';

                $outflag2 = 1;
                break;
            case 3:
 //Six positions part numbers with all numeric characters have a zero
//inserted in the first position. Part number 123456 becomes 0123456
//when part type = AA
            	if(trim(substr($line, 71, 2)) == 'AA')
            	{
            		if(!ctype_alpha(trim(substr($line, 47, 20))))
            		{
            			$replno = '0'.trim(substr($line, 47, 20));
            		}
            	} else {
            		$replno = trim(substr($line, 47, 20));
            	}
//replacing part no
                $outline3 =  $replno . '||' .

//replacement quantity 
                trim(substr($line, 67, 4)) . '|'.
//part type
                trim(substr($line, 71, 2)) . '|';
                $outflag3 = 1;
                break;
        }

   
//store current line type    
    $lastlinetype = substr($line, 45, 1);
//read next line in file
    $line     = fgets($filein);
    $nextlinetype = substr($line, 45, 1);
//if the next line in the file is type 1 output the data to file    
    if ($nextlinetype == 1)
      {
        if ($outflag2 == 0)
          {
            $outline2 = '|0000000000001|0000000000001|0000000000000|0000000000000|0000000000000|0000000000000|USD|';
          }
        
        if ($outflag3 == 0)
          {
            $outline3 = '||0000|XX|';
          }
        $outlinet = $outline . $outline2 . $outline3;
//        echo $outlinet . '</BR>';
        $outlinet = $outlinet."\r\n";
        fwrite($fileout, $outlinet);

		$outline = '';
        $outline2 = '';
        $outline3 = '';
        $outflag2 = 0;
        $outflag3 = 0;
      }      

  } 
  
fclose($filein);
fclose($fileout);

?>