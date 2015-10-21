<?php
class BanglaNumberToWord{
    var $eng_to_bn = array('1'=>'১', '2'=>'২', '3'=>'৩', '4'=>'৪', '5'=>'৫','6'=>'৬', '7'=>'৭', '8'=>'৮', '9'=>'৯', '0'=>'০');
    var $num_to_bd = array('1'=>'এক','2'=>'দুই','3'=>'তিন','4'=>'চার','5'=>'পাঁচ','6'=>'ছয়','7'=>'সাত','8'=>'আট', '9'=>'নয়','10'=>'দশ','11'=>'এগার','12'=>'বার','13'=>'তের','14'=>'চৌদ্দ','15'=>'পনের','16'=>'ষোল','17'=>'সতের','18'=>'আঠার','19'=>'ঊনিশ','20'=>'বিশ','21'=>'একুশ','22'=>'বাইশ','23'=>'তেইশ','24'=>'চব্বিশ','25'=>'পঁচিশ','26'=>'ছাব্বিশ','27'=>'সাতাশ','28'=>'আঠাশ','29'=>'ঊনত্রিশ','30'=>'ত্রিশ','31'=>'একত্রিশ','32'=>'বত্রিশ','33'=>'তেত্রিশ','34'=>'চৌত্রিশ','35'=>'পঁয়ত্রিশ','36'=>'ছত্রিশ','37'=>'সাঁইত্রিশ','38'=>'আটত্রিশ','39'=>'ঊনচল্লিশ','40'=>'চল্লিশ','41'=>'একচল্লিশ','42'=>'বিয়াল্লিশ','43'=>'তেতাল্লিশ','44'=>'চুয়াল্লিশ','45'=>'পঁয়তাল্লিশ','46'=>'ছেচল্লিশ','47'=>'সাতচল্লিশ','48'=>'আটচল্লিশ','49'=>'ঊনপঞ্চাশ','50'=>'পঞ্চাশ','51'=>'একান্ন','52'=>'বায়ান্ন','53'=>'তিপ্পান্ন','54'=>'চুয়ান্ন','55'=>'পঞ্চান্ন','56'=>'ছাপ্পান্ন','57'=>'সাতান্ন','58'=>'আটান্ন','59'=>'ঊনষাট','60'=>'ষাট','61'=>'একষট্টি','62'=>'বাষট্টি','63'=>'তেষট্টি','64'=>'চৌষট্টি','65'=>'পঁয়ষট্টি','66'=>'ছেষট্টি','67'=>'সাতষট্টি','68'=>'আটষট্টি','69'=>'ঊনসত্তর','70'=>'সত্তর','71'=>'একাত্তর','72'=>'বাহাত্তর','73'=>'তিয়াত্তর','74'=>'চুয়াত্তর','75'=>'পঁচাত্তর','76'=>'ছিয়াত্তর','77'=>'সাতাত্তর','78'=>'আটাত্তর','79'=>'ঊনআশি','80'=>'আশি','81'=>'একাশি','82'=>'বিরাশি','83'=>'তিরাশি','84'=>'চুরাশি','85'=>'পঁচাশি','86'=>'ছিয়াশি','87'=>'সাতাশি','88'=>'আটাশি','89'=>'ঊননব্বই','90'=>'নব্বই','91'=>'একানব্বই','92'=>'বিরানব্বই','93'=>'তিরানব্বই','94'=>'চুরানব্বই','95'=>'পঁচানব্বই','96'=>'ছিয়ানব্বই','97'=>'সাতানব্বই','98'=>'আটানব্বই','99'=>'নিরানব্বই');
    var $num_to_bn_decimal = array('0'=>'শূন্য ','1'=>'এক ','2'=>'দুই ','3'=>'তিন ','4'=>'চার ','5'=>'পাঁচ ','6'=>'ছয় ','7'=>'সাত ','8'=>'আট ', '9'=>'নয় ');
    var $hundred = 'শত';
    var $thousand = 'হাজার';
    var $lakh = 'লক্ষ';
    var $crore = 'কোটি';

    public function engToBn($number){
        $bn_number = strtr($number,$this->eng_to_bn);
        return $bn_number;
    }

    public function numToWord($number){
        if (!is_numeric($number) ) return 'Not a Number';

        if(is_float($number)){
            $dot = explode(".", $number);
            return $this->numberSelector($dot[0]).' দশমিক '.$this->numToBnDecimal($dot[1]);
        }else{
            return $this->numberSelector($number);
        }

    }
    public function numToBn($number){
        $word = strtr($number,$this->num_to_bd);
        return $word;
    }
    public function numToBnDecimal($number){
        $word = strtr($number,$this->num_to_bn_decimal);
        return $word;
    }

    public function numberSelector($number){
        if($number > 9999999){
            return $this->crore($number);
        }elseif($number > 99999){
            return $this->lakh($number);
        }elseif($number > 999){
            return $this->thousand($number);
        }elseif($number > 99){
            return $this->hundred($number);
        }else{
            return $this->underHundred($number);
        }
    }

    public function underHundred($number){
        $number = ($number == 0)?'': $this->numToBn($number);
        return $number;
    }

    public function hundred($number){
        $a = (int)($number/100);
        $b = $number%100;
        $hundred = ($a == 0)?'': $this->numToBn($a).' '.$this->hundred;
        return $hundred.' '.$this->underHundred($b);
    }

    public function thousand($number){
        $a = (int)($number/1000);
        $b = $number%1000;
        $thousand = ($a == 0)?'': $this->numToBn($a).' '.$this->thousand;
        return $thousand.' '.$this->hundred($b);
    }

    public function lakh($number){
        $a = (int)($number/100000);
        $b = $number%100000;
        $lakh = ($a == 0)?'': $this->numToBn($a).' '.$this->lakh;
        return $lakh.' '.$this->thousand($b);
    }

    public function crore($number){
        $a = (int)($number/10000000);
        $b = $number%10000000;
        $more_than_core = ($a>99)?$this->lakh($a):$this->numToBn($a);
        return $more_than_core.' '.$this->crore.' '.$this->lakh($b);
    }
}
?>