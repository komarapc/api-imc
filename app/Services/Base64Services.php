<?php

namespace App\Services;

use Hidehalo\Nanoid\Client;

class Base64Services
{
  /**
   * Upload image from base64 string
   * @param string $base64String
   * @param string $path
   * @return object
   */
  public function uploadImage(string $base64String, string $path)
  {
    $extension = self::getBase64FileExtension($base64String);
    $image = base64_decode($base64String);
    $nanoid = new Client();
    $imageName =  time() . '_' . $nanoid->generateId(21) . '.' . $extension;
    $uploadPath = public_path() . $path . $imageName;
    file_put_contents($uploadPath, $image);
    $file_url = url($path . $imageName);
    return (object)[
      'file_name' => $imageName,
      'file_url' => $file_url,
      'file_path' => $uploadPath
    ];
  }
  public function getBase64FileExtension($base64)
  {
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mime = finfo_buffer($finfo, base64_decode($base64));
    finfo_close($finfo);

    $extension = '';

    switch ($mime) {
      case 'image/jpeg':
        $extension = 'jpg';
        break;
      case 'image/png':
        $extension = 'png';
        break;
    }

    return $extension;
  }

  public function deleteFileContent(string $path_file)
  {
    // unlink file
    if (file_exists($path_file)) {
      unlink($path_file);
    }
  }

  public function validateBase64(string $base64String)
  {
    $base64String = str_replace(' ', '+', $base64String);
    $data = explode(',', $base64String);
    $file = base64_decode($data[1]);
    $f = finfo_open();
    $mime_type = finfo_buffer($f, $file, FILEINFO_MIME_TYPE);
    $mime_type = explode('/', $mime_type);
    if ($mime_type[0] == 'image') {
      return true;
    } else {
      return false;
    }
  }

  public function base64Size(string $base64String)
  {
    $base64String = str_replace(' ', '+', $base64String);
    $data = explode(',', $base64String);
    $file = base64_decode($data[1]);
    $size = strlen($file);
    $size = $size / 1024;
    return $size;
  }

  public function base64StringOnly(string $base64String)
  {
    $imageBase64 = preg_replace('/^data:image\/(\w+);base64,/', '', $base64String);
    $imageBase64 = str_replace(' ', '+', $imageBase64);
    return $imageBase64;
  }
}
