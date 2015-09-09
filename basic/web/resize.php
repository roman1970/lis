<?php

function showImage($filePath)
{
    $fileExtension = preg_replace('/^.+\.(.+)/', '$1', $filePath);
    $fileExtension = strtolower($fileExtension);

    if (file_exists($filePath))
    {
        header('Content-Type: image/'.$fileExtension);
        readfile($filePath);
        exit();
    }
    else
        exit('Not found');
}

function createFolders($filePath)
{
    global $dir;
    $root = $dir;
    $filePath = str_replace($dir, '', $filePath);
    $filePath = trim($filePath, '/');
    $filePath = explode('/', $filePath);

    unset($filePath[count($filePath) - 1]);

    foreach ($filePath as $folder)
    {
        $root .= '/'.$folder;

        if (!is_dir($root))
        {

            mkdir($root, 0777);
            chmod($root, 0777);
        }
    }

    return true;
}

$root = dirname(__FILE__);

$height = $_GET['h'];
$width = $_GET['w'];
$type = $_GET['type'];
$file = trim($_GET['file'], '/');
$file = (!empty($file)) ? '/'.$file : '';

if (!preg_match('/\/.*\.(jpg|jpeg|png|gif|bmp)/i', $file))
    $file = '';

if (empty($file) || !file_exists($root.$file))
    $file = '/noimage.jpg';

$fileRes = '/resize/'.$height.'/'.$width.'/'.$type.$file;

$file = $root.$file;
$fileRes = $root.$fileRes;


if (!file_exists($fileRes))
{
    require_once $root.'/SimpleImage.php';
    $simpleImage = new SimpleImage;
    $simpleImage->load($file);

    switch ($type)
    {
        case 'no':
            $simpleImage->square_crop($height, $width);
            break;
        case 'w':
            $simpleImage->fit_to_width($width);
            break;
        case 'h':
            $simpleImage->fit_to_height($height);
            break;
        case 's':
            $simpleImage->resize($height, $width);
            break;
    }

    createFolders($fileRes);
    $simpleImage->save($fileRes);
}

