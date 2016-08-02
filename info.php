<?php
$info = getdate();
$date = $info['mday'];
$month = $info['mon'];
$year = $info['year'];
$hour = $info['hours'];
$min = $info['minutes'];
$sec = $info['seconds'];

echo $current_date = "$date/$month/$year == $hour:$min:$sec";
echo "คืออะไร";
?>
