<?php
// Flickr API Test

// include the foto class
include 'libraries/fotos.php';

$fotos = new Fotos('1eff0206acbb3b36124af322e86772db');

$group_params = array(
    'method' => 'flickr.groups.pools.getPhotos',
    'group_id' => '46299879@N00',
    'per_page' => '30',
    'format' => 'json',
    'nojsoncallback' => '1'
);

$data = json_decode($fotos->getData($group_params));
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>flickr api test</title>
</head>

<body>
<?php foreach ($data->photos->photo as $p): ?>
   <div class="foto">
       <a href="<?php echo $fotos->getMediumPhotoSrc($p)?>">
           <img src="<?php echo $fotos->getSquarePhotoSrc($p);?>" />
       </a>
   </div>
<?php endforeach; ?>
</body>
</html>