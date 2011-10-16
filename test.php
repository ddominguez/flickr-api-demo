<?php
// Flickr API Test

// include the foto class
include 'libraries/fotos.php';

$fotos = new Fotos('FLICKR_API_KEY');

$group_params = array(
    'method' => 'flickr.groups.pools.getPhotos',
    'group_id' => '46299879@N00',
    'per_page' => '30',
    'format' => 'json',
    'nojsoncallback' => '1'
);

$data = json_decode($fotos->getData($group_params));
//print_r($data); exit;
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>flickr api test</title>
    <link rel="stylesheet" href="css/styles.css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.min.js"></script>
    <script src="js/scripts.js"></script>
</head>

<body>

<div id="container">
<?php foreach ($data->photos->photo as $p): ?>
   <div class="foto">
       <a href="<?php echo $fotos->getMediumPhotoSrc($p)?>">
           <img src="<?php echo $fotos->getSquarePhotoSrc($p);?>" />
       </a>
   </div>
<?php endforeach; ?>

<div class="foto_popup"></div>
</div>
</body>
</html>