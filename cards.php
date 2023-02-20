<?php
class Card 
{public $number;
protected $validity;
protected $issuer;

const MASTERCARD = '/^(5[1-5]{1}|62|67)/';
const VISA = '/^(4[0-9]{1}|14)/';

function __construct ($number)
{$this->number = $number;
$this->issuer = 'undefined issuer';}
public function validate ()
{$controlSum = 0;
for ($i=1; $i<=strlen($this->number); $i++) {
    $digit = intval($this->number[-$i]);
    if (($i % 2) == 1) {
        $controlSum = $controlSum + $digit;
    } else {
        if ($digit * 2 <= 9) {
            $controlSum = $controlSum + ($digit * 2);
        } else {
            $controlSum = $controlSum + (($digit * 2) - 9);
        }   }
}
if (($controlSum % 10) == 0) {
    $this->validity = 'valid';
} else {
    $this->validity = 'invalid';
}

if ($this->validity == 'valid') {
if (preg_match(Card::MASTERCARD, $this->number) == 1) {
    $this->issuer = 'mastercard';
} 
if (preg_match (Card::VISA, $this->number) == 1) {
    $this->issuer = 'visa';
}}
echo ($this->validity . ', issued by ' . $this->issuer . PHP_EOL);}
}

do {
$input = (string)readline('Enter card number: ');
if ($input == 'stop') {continue;}
$card = new Card ($number = preg_replace('/[^0-9]/', '', $input));
$card->validate ();
} while ($input != 'stop');

// Test:
// 4750657776370372 - валидная, VISA
// 4023 9019 5678 9014 - валидная, VISA
// 5569191777864116 - валидная, MasterCard
// 725163728819929 - невалидная
?>
 