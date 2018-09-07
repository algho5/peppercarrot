<?php
if(array_key_exists('HTTP_REFERER', $_SERVER) && (! preg_match('/^https?:\/\/(?:www\.)?peppercarrot.com(?:$|\/)/i', $_SERVER['HTTP_REFERER']))){
  header('HTTP/1.0 403 Forbidden');
  header("Content-type: image/png");
  $data = "iVBORw0KGgoAAAANSUhEUgAAAGQAAABkBAMAAACCzIhnAAAAGFBMVEUREREuLi5OTk5vb2+Pj4+wsLDQ0ND+/v6gQ/Z8AAAFY0lEQVRYw9WYS3eqPBSGd0A90wRbmeJ9amuPTK22MsVWy1TqJdMqJPvvf+HmFdSOzvpcXasReJKd7HdfEPDXH/ifIh+/R+rer5E5z0Y+v4WoB8Z8P1SfoX2JcAyyiWwMGmsKneSpF3RkG93uJdLHRVfUB4h/wxI+EwbQLqFUMzVlO3hE17xEKF+YLlQRjVCTVkP71DcaPmEDmXhY1ND9k4PUFiYdETVYwZoNjHUZCfY49WiosW7uKhbxKwSpGjCYky82L0ngvS9qwgo0jos8w4CVNbQ4WgDvbMPmeoTYoMMMKoihk7OKRR5IhPSqMKBrNjcQvGGHUBgDeLmutD6gRnmdKw9Q25oZX5oEZ2gqpK9ZpVykt7Eq1oBETrNsl2ioVtHcijaFhu4TJ6hdIp98bf9Eh7z0RnZAW/iMAPUa20Ffl/XHnZ4vGFlvR//WHo5t3OCUzpyx7K/buGrJzX2y3OxVJv9xVIrZ2BifhJW8gQjleWCDfZBIlC3JulcRqhDjr3r2MZq+s3V2LwujddWw9QjK0gl4QHBnh7pvPnes2o3tSyiLP37XB2erBcQvVx2LeKc7ukRKouSaLqn8QANc0sRPWrlxyAoBWnl61X/UtlxQVn2QW4guACrWK/zoEaKUFcJNRMKixJRRZUsh4IymwK8jvRKy75KxYa7ajVuyHmkUxleR7zZuRPsNV58dUV92hDdif28YJr1MJRzX8YWn2i9lKV244v15HtIjA78QkVaVXxA75ZnAKULCN6pdMDRyjFmEfDshaBeLOMhlIfLk4QrOTmdYxjeO5SLEUFYlnl6PG43mPBapE6gi81iASIM/q+xaRjlmlDJmtDj6Wlxgi5CwioHBQ3hTxYgww6Ckynsd2b2O4LSDQyBGdcRVaK4oIc4uMrRdgAQPCjPkx8vH1yTwhBPId8banxgnggIkuvFa9TD0bOEIbxdyKUdxFBchO3VD9qNcatvSVhljFl2dKk+FhYg6/WXs/fkEuwGK97SExpPlG1bCXeJIMcHJEkVS9X3gftH2w5Kkif7kBDezrDhKq6LOsWAVY1vadxebdwyz62AVaUwQa7LvTcTkOGIKZUn1o+Q8OIy3YBchwyOTxXFUncn7CLH4WdLI6oyv5SIhSv0svKYsnUOc5j7YN3VBGkjPqX3yYZlt2+ryHGTb8ZPuKWDp5DtTPqQ3F+VODrJjaSfodr+TyX1bdWPpTZKHCJ0ku61zkUhqyqO/ZGXSvUTCAZvtA62RZA9lbXrUzy3nEhFkmCwSqPle48mbyqDUh1+rGb80zILEnKWaz49plYl3mT1hPWcvQ6rFi0cRE8RIO3VofBQk75D1fnw/VIiIrTjuMRrVPO8TjxcWDPFdydMYrV0pMr6ZhyxOtNc41buV246Kk6iox18+B5kL8sVvHed3kbwgpG88Cz0f2cL5/kVtmxh02vkcZf6LAwjNRDGnEjuOSv9omRWPxbOIt/RkFJbXo5boOZo+mMQZJDQGhUV8cVimFZkSjr1ppNJmcUOi2rds2DFjJErHYXVwpbtwSeab9wgRLxhUsXG2yCkSEiO9vYzYsMUDNmWDq73lK0klGwlaFQK+iyrmjT6ZPRye+HnELWGdG934irLqPoNH73nQvNnzj1UBb0w2m/V6NlZyGBLnJiI/KEQtOTBGwTzVamHXN2YRoRZj0MXzHrmg61v3yLhh9PvvPfteBK00Fw8dBPMuRGQlaMiR2nchu6w2qnwH9yHT7GBVvoQ/dyHDLDm0lY2lu5C6dqjlhNyF0IeDtMvA70HYocsJbXDuQCQ7ZBrJLfsexDhOTq55j2HN44m3dyHyeMfCvktj5z/7/JPfx/4D4kznTAH34rwAAAAASUVORK5CYII=";
  echo base64_decode($data);
  exit;
}

function build_cat($seed=''){
    // init random seed
    if($seed) srand( hexdec(substr(md5($seed),0,6)) );

    // throw the dice for body parts
    $parts = array(
        'body' => rand(1,15),
        'fur' => rand(1,10),
        'eyes' => rand(1,15),
        'mouth' => rand(1,10),
        'accessorie' => rand(1,20)
    );

    // create backgound
    $cat = @imagecreatetruecolor(70, 70)
        or die("GD image create failed");
    $white = imagecolorallocate($cat, 255, 255, 255);
    imagefill($cat,0,0,$white);

    // add parts
    foreach($parts as $part => $num){
        $file = dirname(__FILE__).'/avatars/'.$part.'_'.$num.'.png';

        $im = @imagecreatefrompng($file);
        if(!$im) die('Failed to load '.$file);
        imageSaveAlpha($im, true);
        imagecopy($cat,$im,0,0,0,0,70,70);
        imagedestroy($im);
    }

    // restore random seed
    if($seed) srand();

    header('Pragma: public');
    header('Cache-Control: max-age=86400');
    header('Expires: '. gmdate('D, d M Y H:i:s \G\M\T', time() + 86400));
    header('Content-Type: image/jpg');
    header('Etag: W/"' . md5($_GET["seed"]) . '"');
    imagejpeg($cat, NULL, 90);
    imagedestroy($cat);
}


$imageurl = $_GET["seed"];
$imageurl = preg_replace('/[^A-Za-z0-9\._-]/', '', $imageurl); 
$imageurl = substr($imageurl,0,35).'';
$cachefile = '../../tmp/cache/cat-avatar-generator/'.$imageurl.'.jpg';
$cachetime = 5184000; # = 2 monthes | 604800 = 1 week | 86400 = 1 day

// Serve from the cache if it is younger than $cachetime
if (file_exists($cachefile) && time() - $cachetime < filemtime($cachefile)) {
  header('Pragma: public');
  header('Cache-Control: max-age=86400');
  header('Expires: '. gmdate('D, d M Y H:i:s \G\M\T', time() + 86400));
  header('Content-Type: image/jpg');
  header('Etag: W/"' . md5($_GET["seed"]) . '"');
  readfile($cachefile);
  exit;
}

// ...Or start generation
ob_start(); 

// render the picture:
build_cat($_REQUEST['seed']);

// Save/cache the output to a file
$savedfile = fopen($cachefile, 'w+'); # w+ to be at start of the file, write mode, and attempt to create if not existing.
fwrite($savedfile, ob_get_contents());
fclose($savedfile);
chmod($savedfile, 0755);
ob_end_flush();
?>


