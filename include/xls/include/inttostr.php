<?php

/** 
 * @author [Eugene Marsakov] 
 * @copyright 2009 
 * @site [http://forwebm.net] 
 */ 

 /* 
 Данный модуль я перевел из модуля преобразования дробного числа в строкое представление
 из языка Object Pascal (Delphi) в скриптовый язык php + добавленны данные с долларами.
 Оригеналом модуля является модуль, написанный на Object Pascal (delphi). 
 Результат перевода в код php - работа кода на 100% соответствует оригеналу.
  
  
 Функции, представляющая вещественные числа словами 
 function FloatToText($R,$Precision) 
 Преобразует вещественное (целое) число в текстовое представление с точностью
 до Precision <= 4 знаков после точки. 
  
 function CurrencyToText($sum,$price = "RUR")  
 Преобразует сумму в слова (как целую, так и дробную) 
 если параметр $price = RUR - выводит со словами рублей иили копеек, 
 если $price = USD - со словами долларов иили центов 
 ------------------- 
 function ArabicToRoman($num_int) 
 переводит целое число $num_int в римское представление числа 
  
 function RomanToArabic($rim_num)  
 переводит число из римского представления в арабское 
 ------------------- 
  
  
  

 function AmountOfUnits($AUnit,$R,$Precision,$Options) 
 То же, что и FloatToText, но с учётом единицы измерения и опциями: 
 ntoExplicitZero: "ноль целых" 
 ntoMinus, ntoPlus: "минус", "плюс". 
 ntoNotReduceFrac: "пятьдесят сотых" вместо "пяти десятых". 

 function CountOfUnits($AUnit,$N,$Options) 
 То же для целых чисел. Все функции модуля реализованы через неё. 
*/  

//-----------------------------------------------------------------------  
 /* set as constants */ 
 define('GENMASCULINE','genMasculine', false);  
 define('GENNEUTER','genNeuter', false); 
 define('GENFEMININE','genFeminine', false); 
//-----------------------------------------------------------------------  
 //******************************************** 
 /* constants of rules */ 
 $WD_EMPTY    = array( 
  'Gender'=>GENMASCULINE, 
  'Base'=>'', 
  'End1'=>'', 
  'End2'=>'', 
  'End5'=>'', 
 ); 
 $WD_THOUSEND = array( 
  'Gender'=>GENFEMININE, 
  'Base'=>'тысяч', 
  'End1'=>'а', 
  'End2'=>'и', 
  'End5'=>'', 
 ); 
 $WD_MILLION  = array( 
  'Gender'=>GENMASCULINE, 
  'Base'=>'миллион', 
  'End1'=>'', 
  'End2'=>'а', 
  'End5'=>'ов', 
 ); 
 $WD_MILLIARD = array( 
  'Gender'=>GENMASCULINE, 
  'Base'=>'миллиард', 
  'End1'=>'', 
  'End2'=>'а', 
  'End5'=>'ов', 
 );  
  
 $WD_INT      = array( 
  'Gender'=>GENFEMININE, 
  'Base'=>'цел', 
  'End1'=>'ая', 
  'End2'=>'ых', 
  'End5'=>'ых', 
 ); 
 $WD_FRAC     = array( 
    1=> 
     array( 
    'Gender'=>GENFEMININE, 
    'Base'=>'десят', 
    'End1'=>'ая', 
    'End2'=>'ых', 
    'End5'=>'ых', 
    ), 
    2=> 
     array( 
    'Gender'=>GENFEMININE, 
    'Base'=>'coт', 
    'End1'=>'ая', 
    'End2'=>'ых', 
    'End5'=>'ых', 
    ),     
    3=> 
     array( 
    'Gender'=>GENFEMININE, 
    'Base'=>'тысячн', 
    'End1'=>'ая', 
    'End2'=>'ых', 
    'End5'=>'ых', 
    ), 
    4=> 
     array( 
    'Gender'=>GENFEMININE, 
    'Base'=>'десятитысячн', 
    'End1'=>'ая', 
    'End2'=>'ых', 
    'End5'=>'ых', 
    ), 
    ); 
 //******************************************** 
  /* Рубли, копейки */ 
 $WD_RUBLE    = array( 
    'Gender'=>GENMASCULINE, 
    'Base'=>'рубл', 
    'End1'=>'ь', 
    'End2'=>'я', 
    'End5'=>'ей', 
    ); 

 $WD_KOPECK   = array( 
    'Gender'=>GENFEMININE, 
    'Base'=>'копе', 
    'End1'=>'йка', 
    'End2'=>'йки', 
    'End5'=>'ек', 
    ); 
 //********************************************    
  /* Доллары, центы */ 
 $WD_USD    = array( 
    'Gender'=>GENMASCULINE, 
    'Base'=>'доллар', 
    'End1'=>'', 
    'End2'=>'а', 
    'End5'=>'ов', 
    ); 

 $WD_CENT   = array( 
    'Gender'=>GENMASCULINE, 
    'Base'=>'цент', 
    'End1'=>'', 
    'End2'=>'а', 
    'End5'=>'ов', 
    );  
 //******************************************** 
  /* секунды */ 
 $WD_SECOND    = array( 
    'Gender'=>GENFEMININE, 
    'Base'=>'секунд', 
    'End1'=>'а', 
    'End2'=>'ы', 
    'End5'=>'', 
    );     
  /* минуты */ 
 $WD_MINUTES    = array( 
    'Gender'=>GENFEMININE, 
    'Base'=>'минут', 
    'End1'=>'а', 
    'End2'=>'ы', 
    'End5'=>'', 
    );     
  /* часы */ 
 $WD_HOURS    = array( 
    'Gender'=>GENMASCULINE, 
    'Base'=>'час', 
    'End1'=>'', 
    'End2'=>'а', 
    'End5'=>'ов', 
    );      
  /* дни */ 
 $WD_DAYS    = array( 
    'Gender'=>GENMASCULINE, 
    'Base'=>'', 
    'End1'=>'день', 
    'End2'=>'дня', 
    'End5'=>'дней', 
    ); 
  /* недели */ 
 $WD_WEEKS    = array( 
    'Gender'=>GENFEMININE, 
    'Base'=>'недел', 
    'End1'=>'я', 
    'End2'=>'и', 
    'End5'=>'ь', 
    );     
 //месяцы    
 $WD_MONTH    = array( 
    'Gender'=>GENMASCULINE, 
    'Base'=>'месяц', 
    'End1'=>'', 
    'End2'=>'а', 
    'End5'=>'ев', 
    ); 
 //годы    
 $WD_YEAR    = array( 
    'Gender'=>GENMASCULINE, 
    'Base'=>'', 
    'End1'=>'год', 
    'End2'=>'года', 
    'End5'=>'лет', 
    ); 
 //********************************************             

   
 $TenIn = array( 
  1=>10, 
  2=>100, 
  3=>1000, 
  4=>10000 
 );  
  
 $MaxPrecision = 4; // до десятитысячных 
  
  
//----------------------------------------------------------------------- 
 /* для работы с римскими числами */ 
  $Rim  = array(1=>'I', 2=>'IV', 3=>'V', 4=>'IX', 5=>'X', 6=>'XL', 7=>'L', 8=>'XC', 9=>'C', 10=>'CD', 11=>'D', 12=>'CM', 13=>'M',);
  $Arab = array(1=>1, 2=>4, 3=>5, 4=>9, 5=>10, 6=>40, 7=>50, 8=>90, 9=>100, 10=>400, 11=>500, 12=>900, 13=>1000,);  
  
//-----------------------------------------------------------------------  
 /* declaraited functions */ 
 function mod($a,$b) { return $a%$b; } 
 function div($a,$b) { return floor($a/$b); } 
 function Trunc($a) { return div($a, 1); } 
 function Frac($a) {  $out = explode('.', $a); return $out[1]; } 
 function FreeZero($a) { 
   $s = ''; $s_len = strlen($a); 
   while ($s_len >= 0) {  
       if (substr($a,$s_len, 1) == 0) { $s_len--; } 
    else { $s = substr($a, 0,$s_len+1); break; }    
   } 
   return $s;  
 } 
//-----------------------------------------------------------------------  
  


//----------------------------------------------------------------------- 
 /* class as convert data */ 
 class NumberAnaliz { 
   
  private $FFirstLevel  = 0; 
  private $FSecondLevel = 0; 
  private $FThirdLevel  = 0; 
   
  var $UnitWord     = array('Gender'=>GENNEUTER,'Base'=>'','End1'=>'','End2'=>'','End5'=>'',);
  var $FNumber      = 0; 
   
  function Levels($I) {    
   switch ($I) { 
    case 1: return $this->FFirstLevel; 
    case 2: return $this->FSecondLevel; 
    case 3: return $this->FThirdLevel;     
   }       
  } 
   
  function SetNumber($AValue) { 
   if ($this->FNumber != $AValue) {     
    $this->FNumber = $AValue; 
    $this->FFirstLevel  = mod($this->FNumber, 10); 
    $this->FSecondLevel = mod(div($this->FNumber, 10), 10); 
    $this->FThirdLevel  = mod(div($this->FNumber, 100), 10); 
    if ($this->FSecondLevel == 1) { 
     $this->FFirstLevel = $this->FFirstLevel + 10; 
     $this->FSecondLevel = 0;     
    }     
   }     
  } 
   
  private function GetNumberInWord($N,$Level) {     
   if ($Level == 1) { 
    switch ($N) { 
     case 0: return ''; 
     case 1: if ($this->Gender() == GENMASCULINE) { return 'один'; } 
      else if ($this->Gender() == GENFEMININE) { return 'одна'; }     
      else if ($this->Gender() == GENNEUTER) { return 'одно'; } 
     case 2: if ($this->Gender() == GENMASCULINE) { return 'два'; } 
      else if ($this->Gender() == GENFEMININE) { return 'две'; }     
      else if ($this->Gender() == GENNEUTER) { return 'два'; }      
     case 3:  return 'три'; 
     case 4:  return 'четыре'; 
     case 5:  return 'пять'; 
     case 6:  return 'шесть'; 
     case 7:  return 'семь'; 
     case 8:  return 'восемь'; 
     case 9:  return 'девять'; 
     case 10: return 'десять'; 
     case 11: return 'одиннадцать'; 
     case 12: return 'двенадцать'; 
     case 13: return 'тринадцать'; 
     case 14: return 'четырнадцать'; 
     case 15: return 'пятнадцать'; 
     case 16: return 'шестнадцать'; 
     case 17: return 'семнадцать'; 
     case 18: return 'восемнадцать'; 
     case 19: return 'девятнадцать';                    
    }//switch     
   }//level 1 
   else if ($Level == 2) { 
    switch ($N) { 
     case 0: return ''; 
     case 1: return 'десять'; 
     case 2: return 'двадцать'; 
     case 3: return 'тридцать'; 
     case 4: return 'сорок'; 
     case 5: return 'пятьдесят'; 
     case 6: return 'шестьдесят'; 
     case 7: return 'семьдесят'; 
     case 8: return 'восемьдесят'; 
     case 9: return 'девяносто';         
    }     
   }//level 2 
   else if ($Level == 3) { 
    switch ($N) { 
     case 0: return ''; 
     case 1: return 'сто'; 
     case 2: return 'двести'; 
     case 3: return 'триста'; 
     case 4: return 'четыреста'; 
     case 5: return 'пятьсот'; 
     case 6: return 'шестьсот'; 
     case 7: return 'семьсот'; 
     case 8: return 'восемьсот'; 
     case 9: return 'девятьсот';         
    }     
   }//level 3        
  } 
   
  function Gender() { 
   return $this->UnitWord['Gender'];     
  } 
   
  function UnitWordInRightForm() { 
   $result = $this->UnitWord['Base']; 
   $slevel = $this->Levels(1); 
   if ($slevel == 1) { return $result.$this->UnitWord['End1']; } 
   if (($slevel == 0) or (($slevel >= 5) and ($slevel <= 19))) { return $result.$this->UnitWord['End5']; } 
   if (($slevel >= 2) or ($slevel <= 4)) { return $result.$this->UnitWord['End2']; }        
  } 
   
  private function Convert() {   
   if ($this->FNumber == 0) { return ''; } 
   $result = ''; 
   for ($i = 3;$i >= 1;$i--) { 
    $s = $this->GetNumberInWord($this->Levels($i),$i); 
    if ($s != "") { $result .= $s.' '; } 
   }//for 
   return $result.$this->UnitWordInRightForm().' ';         
  } 
   
  function ConvertToText($AUnit = array('Gender'=>GENNEUTER,'Base'=>'','End1'=>'','End2'=>'','End5'=>'',), $ANumber) {  
   $this->UnitWord = $AUnit; 
   $this->SetNumber($ANumber); 
   return $this->Convert();        
  } 
      
 }//end of class number 
//----------------------------------------------------------------------- 
  
 /* create global class object */ 
 $NumberAnalyser = new NumberAnaliz(); 


//----------------------------------------------------------------------- 
 //$Options = (ntoExplicitZero, ntoMinus, ntoPlus, ntoDigits, ntoNotReduceFrac)
 function CountOfUnits($AUnit = array('Gender'=>GENNEUTER,'Base'=>'','End1'=>'','End2'=>'','End5'=>'',), $N,$Options = array()) {
  global $NumberAnalyser,$WD_MILLIARD,$WD_MILLION,$WD_THOUSEND; 
   
  $result = ''; 
  if (($N == 0) and (!@in_array('ntoExplicitZero',$Options))) { return $result; }
   
  if (!@in_array('ntoDigits',$Options)) { 
   if (($N < 0) and (@in_array('ntoMinus',$Options))) { $result = 'минус '; }
   else  
   if (($N > 0) and (@in_array('ntoPlus',$Options))) { $result = 'плюс '; } 
   else 
   if ($N == 0) { return 'ноль '.$AUnit['Base'].$AUnit['End5']; }     
  }//if 
  else 
  { 
   if (($N < 0) and (@in_array('ntoMinus',$Options))) { $result = '-'; } 
   else 
   if (($N > 0) and (@in_array('ntoPlus',$Options))) { $result = '+'; }       
  }//else 
   
  $N = Abs($N); 
   
  if (@in_array('ntoDigits',$Options)) { 
   $NumberAnalyser->SetNumber($N); 
   $NumberAnalyser->UnitWord = $AUnit; 
   $result = $N." ".$NumberAnalyser->UnitWordInRightForm();     
  }//if 
  else 
  { 
   $Mrd = mod(div($N, 1000000000), 1000); 
   $Mil = mod(div($N, 1000000), 1000); 
   $Th  = mod(div($N, 1000), 1000); 
   $Un  = mod($N, 1000); 
    
   $result .=  
   $NumberAnalyser->ConvertToText($WD_MILLIARD,$Mrd). 
   $NumberAnalyser->ConvertToText($WD_MILLION,$Mil). 
   $NumberAnalyser->ConvertToText($WD_THOUSEND,$Th); 
    
   if ($Un > 0) { $result .= $NumberAnalyser->ConvertToText($AUnit,$Un); } 
   else { $result .= $AUnit['Base'].$AUnit['End5']; }     
     
  }//else     
  return $result; 
 } 
//----------------------------------------------------------------------- 
 //$Options = (ntoExplicitZero, ntoMinus, ntoPlus, ntoDigits, ntoNotReduceFrac)
 function AmountOfUnits($AUnit = array('Gender'=>GENNEUTER,'Base'=>'','End1'=>'','End2'=>'','End5'=>'',), $R, $Precision, $Options = array()) {
  global $MaxPrecision,$TenIn,$WD_INT,$WD_FRAC; 
   
  // Количество цифр после запятой 
  if ($Precision < 0) { $Precision = 0; } 
  if ($Precision > $MaxPrecision) { $Precision = $MaxPrecision; } 
   
  $result = ''; 
  if (($R > 0) and (@in_array('ntoPlus',$Options))) { $result = 'плюс '; } 
  if (($R < 0) and (@in_array('ntoMinus',$Options))) { $result = 'минус '; }
   
  $R = abs($R); 

  // Если Precision = 0, т.е. без дробной части, округляется в большую сторону
  if ($Precision > 0) { $n_int = Trunc($R); } else { $n_int = round($R); } 
   
  // Дробная часть 
  $n_frac = round(($R - $n_int) * $TenIn[$Precision]); 
   
  // Отбрасывание нулей в дробной части 
  // опция ntoNotReduceFrac не работает при n_frac = 0 (т.е. не будет "ноль сотых")  
   
  if (!@in_array('ntoNotReduceFrac',$Options)) { 
   while ((mod($n_frac, 10) == 0) and ($Precision > 0)) { 
    $n_frac = div($n_frac, 10); 
    $Precision--; 
   }     
  }//if 
   
 // Явная запись нуля 
 if ($n_int == 0) { 
  if ($n_frac == 0) { 
  // При отсутствии дробной части "ноль" добавляется вне зависимости от опции ntoExplicitZero
  // "Result +" отброшено, чтобы избежать "минус ноль" 
  // при очень маленькой дробной части за пределами точности   
  return 'ноль '.$AUnit['Base'].$AUnit['End5']; } 
  else if (@in_array('ntoExplicitZero',$Options)) { $result .= 'ноль целых '; }    
 }//if 
   
 if ($n_frac == 0) { $result .= CountOfUnits($AUnit,$n_int, array()); } // N единиц
 else { $result .= CountOfUnits($WD_INT,$n_int, array()); } // столько-то целых 
  
 if ($n_frac == 0) { return $result; } 
  
 $result .= CountOfUnits($WD_FRAC[$Precision], $n_frac, array()); 
 // N десятых, сотых... 
 $result .= $AUnit['Base'].$AUnit['End2'];  
  
 return $result;     
 } 

//-----------------------------------------------------------------------  
 //перевод вещественного числа в строчное представление 
 function FloatToText($R, $Precision = 4) { 
  global $WD_EMPTY; 
  try { 
   return AmountOfUnits($WD_EMPTY,$R,$Precision, array('ntoExplicitZero','ntoMinus'));        
  } catch (Exception $e)  
  {  
      return '';  
  }     
 } 
//----------------------------------------------------------------------- 
 /* перевод денежной единицы в строковое предствление  
    $price = RUR - рубликопейки 
    $price = USD - долларыценты 
         
    $price = SECOND - секунды (только целое число) 
    $price = MINUTES - минуты (только целое число) 
    $price = HOURS - часы (только целое число) 
    $price = DAY - дни (только целое число) 
    $price = WEEKS - недели (только целое число) 
    $price = MONTH - месяцы (только целое число) 
    $price = YEAR - года (только целое число) 
 */ 
 function CurrencyToText($sum,$price = "RUR") { 
  global $WD_RUBLE,$WD_KOPECK,$WD_USD,$WD_CENT, 
  $WD_YEAR,$WD_MONTH,$WD_WEEKS,$WD_DAYS,$WD_HOURS,$WD_MINUTES,$WD_SECOND; 
   
  $price  = trim($price); 
  $RubSum = Trunc($sum); 
  $KopSum = Round(Frac($sum)); 
   
  if ($KopSum > 100) {  
   $KopSum = round($KopSum/100, 2); 
   $RubSum = $RubSum + Trunc($KopSum); 
   $KopSum = FreeZero(Round(Frac($KopSum) * 100));     
  } 
   
  $sprice  = $WD_RUBLE; 
  $sprice1 = $WD_KOPECK;      
  switch ($price) { 
       case 'USD'     : $sprice = $WD_USD;   $sprice1 = $WD_CENT; break; 
     
    case 'SECOND'  : $sprice = $WD_SECOND;  break; 
    case 'MINUTES' : $sprice = $WD_MINUTES; break; 
    case 'HOURS'   : $sprice = $WD_HOURS;   break; 
    case 'DAY'     : $sprice = $WD_DAYS;    break; 
    case 'WEEKS'   : $sprice = $WD_WEEKS;   break; 
    case 'MONTH'   : $sprice = $WD_MONTH;   break; 
    case 'YEAR'    : $sprice = $WD_YEAR;    break; 
  }            
  $result = CountOfUnits($sprice,$RubSum, array('ntoExplicitZero')).' '.CountOfUnits($sprice1,$KopSum, array());
  $result = trim($result); 
  if ($result != "") { $str = strtoupper($result[0]); $result[0] = $str; } 
  return $result;     
 } 
//----------------------------------------------------------------------- 
  
 //перевод числа (целого) в римское представление  
 function ArabicToRoman($num_int) {  
  global $Rim,$Arab;  
  $num_int = Trunc($num_int); 
  $result = ''; 
  $i = 13; 
  while ($num_int > 0) { 
   while ($Arab[$i] > $num_int) { $i--; } 
   $result .= $Rim[$i]; 
   $num_int = $num_int - $Arab[$i];        
  } 
  return $result;         
 } 
  
 //перевод римского числа в обычное целое 
 function RomanToArabic($rim_num) { 
  global $Rim,$Arab; 
  $result = 0; 
  $i = 13; 
  $p = 0; 
  while ($p <= strlen($rim_num)) { 
   while (substr($rim_num,$p, strlen($Rim[$i])) != $Rim[$i]) { 
    $i--; 
    if ($i == 0) { return $result; }          
   } 
   $result .= $Arab[$i]; 
   $p = $p + strlen($Rim[$i]); 
  } 
  return $result;     
 } 
//-----------------------------------------------------------------------
?>