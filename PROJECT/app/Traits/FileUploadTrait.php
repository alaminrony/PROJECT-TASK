<?php

namespace App\Traits;

use App\Models\Upload;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

trait FileUploadTrait
{



    public function uploadFile($image, $path, $image_sizes, $old_upload_id, $image_type = 'image')
    {
        try {
            if ($old_upload_id) {
                $is_delete = $this->deleteFile($old_upload_id, 'update');
                if (!$is_delete['status']) {
                    return ['status' => false, 'message' => $is_delete['message'], 'upload_id' => ''];
                }
            }
            // delete old uploaded images

            if ($image_type == 'file') {
                $file = $image;
                $fileName = $file->getClientOriginalName();
                $fileName = date('Y-m-d') . '-' . strtolower(Str::random(12)) . '-' . $fileName;
                if ($this->saveToStorage('uploads/' . $path . $fileName, File::get($file))) {
                    $upload = $this->saveUpload('uploads/' . $path . $fileName, $fileName, [], $old_upload_id);
                    if ($upload) {
                        return $this->returnResponse(___('alert.File_uploaded_successfully'), true, $upload->id);
                    } else {
                        return $this->returnResponse(___('alert.File_upload_failed'), false, null);
                    }
                } else {
                    return $this->returnResponse(___('alert.File_upload_failed'), false, null);
                }

            } elseif ($image_type == 'video') {

                $file = $image;
                $fileName = $file->getClientOriginalName();
                $fileName = date('Y-m-d') . '-' . strtolower(Str::random(12)) . '-' . $fileName;
                // video upload using s3 bucket or local storage

                if ($this->saveToStorage('uploads/' . $path . $fileName, File::get($file))) {
                    $upload = $this->saveUpload('uploads/' . $path . $fileName, $fileName, [], $old_upload_id);
                    if ($upload) {
                        return $this->returnResponse(___('alert.Video file uploaded successfully'), true, $upload->id);
                    } else {
                        return $this->returnResponse(___('alert.Video_file_upload_failed'), false, null);
                    }
                } else {
                    return $this->returnResponse(___('alert.Video_file_upload_failed'), false, null);
                }
            } else {
                $requestImage = $image;
                $info = getimagesize($image);
                $fileType = strtolower(image_type_to_extension($info[2]));
                $fileType = explode('.', $fileType);
                $fileType = $fileType[1];

                if ($fileType == 'jpg') {
                    $fileType = 'jpeg';
                }

                $convertMethod = 'imagecreatefrom' . $fileType;
                $directory = "uploads/$path";

                // for original images
                $originalImageName = $this->imageName('original', $fileType);
                $originalImageUrl = $directory . $originalImageName;
                $imageSaveToStorage = $this->imageSaveToStorage($convertMethod, $originalImageUrl, $requestImage, 'original', '', '');
                if (!$imageSaveToStorage) {
                    return [
                        'status' => false,
                        'message' => ___('alert.Image_upload_failed'),
                        'upload_id' => null,
                    ];
                }

                $all_url = [];

                foreach ($image_sizes as $key => $image_size) {
                    $imageName = $this->imageName(++$key, 'webp');
                    $imageUrl = $directory . $imageName;
                    $all_url[$image_size[1] . 'x' . $image_size[0]] = $imageUrl;
                    $multipleImageSaveToStorage = $this->imageSaveToStorage($convertMethod, $imageUrl, $requestImage, '', $image_size[1], $image_size[0]);
                    if (!$multipleImageSaveToStorage) {
                        return [
                            'status' => false,
                            'message' => ___('alert.Image_upload_failed'),
                            'upload_id' => null,
                        ];
                    }
                }

                $upload = $this->saveUpload($originalImageUrl, $originalImageName, $all_url, $old_upload_id);
                if ($upload) {
                    return $this->returnResponse(___('alert.Image_uploaded_successfully'), true, $upload->id);
                } else {
                    return $this->returnResponse(___('alert.Image_upload_failed'), false, null);
                }
            }
        } catch (\Exception $e) {
            return [
                'status' => false,
                'message' => ___('alert.File upload failed'),
                'upload_id' => null,
            ];
        }
    }


}
