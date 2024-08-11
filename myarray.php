<?php
$myarray=array(
    array("ankit","ram","shyam"),
    array("unnao","trichy","kanpur")
);
echo "<pre>";
print_r($myarray);
echo"</pre>";
$people =[
    'joe'=> '22',
    'adam'=> '25',
    'david'=> '30',
];
foreach ($people as $name => $age) {
    echo "my name is $name, and age is $age".'<br>';
}
$data=[
    'game of thrones'=>['jaime lannister','catelyne stark','carsei lannister'],
    'black mirror' =>['nanette cole','selma taise','karin parke']
];
echo '<h1>famous tv series and actors';
foreach( $data as $series=>$actors ){
    echo"<h2>$series</h2>";
    foreach($actors as $actor){
    echo "<div>$actor</div>";
    }
}
?>