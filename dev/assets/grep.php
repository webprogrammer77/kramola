<?php
$path = realpath('.');

function grep($ss, $structure) {
	print '<pre>';
	$count=$found=0;
	asort($structure['files']);
	foreach ($structure['files'] as $file) 
	{ 
			print '<pre>';
		
		$file_content = file_get_contents($file);
		if (preg_match_all('#'.$ss.'#simU', $file_content, $m)) {
			print '<b>'.$file."</b>"/*<ul>";
			foreach (explode("\n", $file_content) as $number=>$line) {
				foreach ($m as $i)
					if (strpos($line, $i[0])!==false) {
						print '<li><b>'.$number.':</b> '.htmlspecialchars(cropText($line, 300, false))."</li>";
					}
			}
			print "</ul>";*/;
			$found++;
		}
		
		$filesize = filesize($file); 
		$sum_filesize = $sum_filesize + $filesize; 
		$count++;
	} 
	echo'<h2>Общее количество файлов: '.$count.'</h2>';
	echo'<h2>Количество файлов с вхождениями: '.$found.'</h2>';
	print '</pre>';
}


function read_all_files($root = '.', $include_ext=array('php', 'htm', 'tpl', 'html', 'js'), $exlude_ext=array('jpg', 'png', 'gif', 'jpeg')){  
  $files  = array('files'=>array(), 'dirs'=>array());  
  $directories  = array();  
  $last_letter  = $root[strlen($root)-1];  
  $root  = ($last_letter == '\\' || $last_letter == '/') ? $root : $root.DIRECTORY_SEPARATOR; 
   
  $directories[]  = $root;  
   
  while (sizeof($directories)) {  
    $dir  = array_pop($directories);  
    if ($handle = opendir($dir)) {  
      while (false !== ($file = readdir($handle))) {  
        if ($file == '.' || $file == '..') {  
          continue;  
        }  
        $file  = $dir.$file;  
        if (is_dir($file)) {  
          $directory_path = $file.DIRECTORY_SEPARATOR;  
          array_push($directories, $directory_path);  
          $files['dirs'][]  = $directory_path;  
        } elseif (is_file($file)) {
			if (($file !== ".") && ($file !== "..") 
							&& (empty($include_ext) || in_array(pathinfo($file, PATHINFO_EXTENSION), $include_ext))
							&& (empty($exlude_ext) || !in_array(pathinfo($file, PATHINFO_EXTENSION), $exlude_ext))){
								$files['files'][]  = $file;  
							}
        }  
      }  
      closedir($handle);  
    }  
  }  
   
  return $files;  
}  

function cropText($text, $length, $seporator_word=true) {
	if (strlen($text) > $length) {
		$text = substr($text, 0, strrpos(substr($text, 0, $length), ' ')) . '...';
	}
	
	return $text;
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<title></title>
	<style type="text/css">
		body {font-family: Tahoma; font-size:12px;}
	</style>
</head>
<body>
	<form action=""><textarea style="font-size:18px;font-family:Monaco, Consolas;" name="ss" rows="3" cols="40"><?=@urldecode($_GET['ss'])?></textarea><br />Не использовать символы решетки(#).<br /><input type="submit" value="Find"></form><hr>
	<?if (!empty($_GET['ss'])) grep($_GET['ss'], read_all_files($path));?>
</body>
</html>