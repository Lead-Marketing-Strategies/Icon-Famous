<?
$file = file_get_contents(__DIR__."/list.txt");
$list = explode(PHP_EOL, $file);
natcasesort($list);

$icons = [];
$enc_lines = [];
$nam_lines = [];
$css_lines = [];
$index_lines = [];
$index_2_lines = [];
$index_3_lines = [];
$index_4_lines = [];
$index_spin_lines = [];
$index_pulse_lines = [];
$index = 5000;

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

ob_start();?>
@font-face {
  font-family: 'IconFamous';
  src: url("font/IconFamous.woff2") format("woff2"), url("font/IconFamous.otf") format("opentype");
  font-style: normal;
  font-weight: normal; }

.if {
  font: normal normal normal 14px/1 IconFamous;
  font-size: inherit;
  text-rendering: auto;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  position: relative;
  display: inline-block; }

.if-lg {
  font-size: 1.33333333em;
  line-height: 0.75em;
  vertical-align: -15%; }

.if-2x {
  font-size: 2em; }

.if-3x {
  font-size: 3em; }

.if-4x {
  font-size: 4em; }

.if-5x {
  font-size: 5em; }

.if-spin {
  -webkit-animation: spin 2s infinite linear;
  animation: spin 2s infinite linear; }

.if-pulse {
  -webkit-animation: spin 1s infinite steps(8);
  animation: spin 1s infinite steps(8); }

@-webkit-keyframes spin {
  0% {
    -webkit-transform: rotate(0deg);
    transform: rotate(0deg); }
  100% {
    -webkit-transform: rotate(359deg);
    transform: rotate(359deg); } }

@keyframes spin {
  0% {
    -webkit-transform: rotate(0deg);
    transform: rotate(0deg); }
  100% {
    -webkit-transform: rotate(359deg);
    transform: rotate(359deg); } }

<?
$css_header = ob_get_contents();
ob_end_clean();

ob_start();?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html lang="en" xml:lang="en" xmlns="http://www.w3.org/1999/xhtml">

<head>
  <meta content="text/html; charset=utf-8" http-equiv="content-type" />
  <meta content="en-us" http-equiv="Content-Language" />
  <title>Famous Icons Regular - Web Font Specimen</title>
  <link rel="stylesheet" type="text/css" href="dist/css/iconfamous.css" />
</head>

<body>
<?
$index_header = ob_get_contents();
ob_end_clean();


ob_start();?>
</body>
</html>
<?
$index_footer = ob_get_contents();
ob_end_clean();

$break_lines = [
  '<br />',
  '<br />'
];

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
    $index_lines[] = '<i class="if if-' . $name . '"></i>';
    $index_2_lines[] = '<i class="if if-2x if-' . $name . '"></i>';
    $index_3_lines[] = '<i class="if if-3x if-' . $name . '"></i>';
    $index_4_lines[] = '<i class="if if-4x if-' . $name . '"></i>';
    $index_spin_lines[] = '<i class="if if-spin if-' . $name . '"></i>';
    $index_pulse_lines[] = '<i class="if if-pulse if-' . $name . '"></i>';

    ob_start();?>
    .if-<?=$name?>:before {
      content: "\<?=sprintf('%04d', $index)?>";
    }

    <?
    $css_lines[] = ob_get_contents();
    ob_end_clean();

    $index++;
  }
}


$enc_data = implode(PHP_EOL, $enc_lines);
//echo str_replace(PHP_EOL, "<br>", $enc_header.$enc_data);
file_put_contents("iconfamous.enc", $enc_header.$enc_data);

$css_data = implode(PHP_EOL, $css_lines);
file_put_contents("css/iconfamous.css", $css_header.$css_data);

$nam_data = implode(PHP_EOL, $nam_lines);
echo str_replace(PHP_EOL, "<br>", $nam_header.$nam_data);
file_put_contents("iconfamous.nam", $nam_header.$nam_data);

$index_data = implode(PHP_EOL,
array_merge(
  $index_lines,
  $break_lines,
  $index_2_lines,
  $break_lines,
  $index_3_lines,
  $break_lines,
  $index_spin_lines,
  $break_lines,
  $index_pulse_lines
));
file_put_contents("index.html", $index_header.$index_data.$index_footer);
