<html>
<head>
	<title>Contao image path search and replace</title>
<style type="text/css">
body { font-family: sans-serif; font-size: 0.85rem; }
table { border-collapse: collapse; }
td { border: 1px solid #ccc; padding: 10px; vertical-align: top; }
</style>
</head>
<body>
<h1>Contao image path search and replace</h1>
<table>
<?php

// ----------
$csv_source = 'export.csv';
$search = 'tl_files/content/a/';
$replace = 'tl_files/content/b/';

// ----------


$row = 1;
if (($handle = fopen($csv_source, "r")) !== FALSE) 
{
    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) 
    {
        $num = count($data);
        $row++;
        echo "<tr>";
        for ($c=0; $c < $num; $c++) 
        {
            if ($c==12)
            {
            	echo "<td class='col_" . $c . " original'>" . $data[$c] . "</td>";
            	if ($data[$c])
            	{
	            	unset($images); $images = array();
	            	foreach (unserialize($data[$c]) as $image) 
	            	{
	            		$image = str_replace($search, $replace, $image);	
	            		array_push($images, $image);
	            	}
            	}            	
            	echo "<td class='col_" . $c . "'>";
            	print_r($images);
            	echo "</td>";
            	echo "<td class='col_" . $c . " serialized'>" . serialize($images) . "</td>";

            	$out .='"'.serialize($images).'",';
            }
            else
            {
            	$data_mod = str_replace($search, $replace, $data[$c]);
            	echo "<td class='col_" . $c . "'>" . $data_mod . "</td>";
            	$out .='"'.$data_mod.'",';
            }
        }
        echo "</tr>";
        $out = substr($out, 0, -1).chr(10);
    }
    fclose($handle);
}
?>
</table>
<h2>CSV Output</h2>
<textarea style="width: 100%; height: 500px;"><?php echo $out ?></textarea>
</body>
</html>