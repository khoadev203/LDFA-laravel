<?php
libxml_use_internal_errors(true);
$html=file_get_contents('https://www.apmex.com/silver-price');
$dom = new DOMDocument;
$dom->loadHTML($html);
foreach($dom->getElementsByTagName('p') as $ptag)
{
    // var_dump($ptag);
    if($ptag->getAttribute('class')=="price")
    {
        echo "<h6>".$ptag->nodeValue."</h6>";
        break;
    }
}