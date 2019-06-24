<?
$file = file_get_contents(__DIR__."/list.txt");
$list = explode(PHP_EOL, $file);
natcasesort($list);

$icons = [];
$enc_lines = [];
$nam_lines = [];
$index = 1;

ob_start();?>
%%FONTLAB ENCODING: 1; Icon Famous
%%GROUP: Famous Internet Solutions
%%Source: FontLab
%%Release: <?=date("Y-m-d").PHP_EOL?>
%
<?
$enc_header = ob_get_contents();
ob_end_clean();

ob_start();?>
%%FONTLAB NAMETABLE: Icon Famous

<?
$nam_header = ob_get_contents();
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
    $enc_lines[] = $name . " " . $index;
    $nam_lines[] = "0x" . sprintf('%04d', $index) . " " . $name;
    $index++;
  }
}


$enc_data = implode(PHP_EOL, $enc_lines);
//echo str_replace(PHP_EOL, "<br>", $enc_header.$enc_data);
file_put_contents("iconfamous.enc", $enc_header.$enc_data);

$nam_data = implode(PHP_EOL, $nam_lines);
echo str_replace(PHP_EOL, "<br>", $nam_header.$nam_data);
file_put_contents("iconfamous.nam", $nam_header.$nam_data);
