<?
$file = file_get_contents(__DIR__."/list.txt");
$list = explode(PHP_EOL, $file);
sort($list);

$icons = [];
$lines = [];
$index = 1;

ob_start();?>
%%FONTLAB ENCODING: 1; Icon Famous
%%GROUP: Famous Internet Solutions
%%Source: FontLab
%%Release: <?=date("Y-m-d").PHP_EOL?>
%
<?
$header = ob_get_contents();
ob_end_clean();


// remove comments, format names
foreach($list as $icon){
  $line = trim($icon);
  $split = explode(".",$line);
  $line = $split[0];
  $line = strtolower($line);
  $name = str_replace(' ', '-', $line);
  if(!empty($name)){
    $icons[] = $name;
    $lines[] = $name . " " . $index;
    $index++;
  }
}


$data = implode(PHP_EOL, $lines);
echo str_replace(PHP_EOL, "<br>", $header.$data);
file_put_contents("iconfamous.enc", $header.$data);
