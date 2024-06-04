<?php
namespace App\Http\Trait;

use Illuminate\Support\Facades\Storage;

trait Imageable
{
    public function insertImage($title, $image, $dir)
    {
        $newImage  = $title . '_' . date('Y-m-d-H-i-s') . '.' . $image->getClientOriginalExtension();
        $image->move(public_path($dir), $newImage);
        return $newImage;
    }

    public function insertImageInMeddiable(
    $model,
    $newImage,
    $relation='mediaFirst')
    {
        $model->$relation()->create([
            'file_name'  => $newImage,
            'file_sort' => 1,
            'file_status' => 1,
        ]);
    }

    public function insertMultipleImage($imageFound, $slug, $model,$dir)
    {
        $sort_image = 0;
        foreach ($imageFound as $image) {
            $data =  $this->generationImageName($image, $slug, $sort_image);
            $image->move(public_path($dir), $data['file_name']);
            $this->saveImage($model, $data);
            $sort_image++;
        }
    }

    public  function generationImageName($imageNew, $slug, $sort_image)
    {
        $data['file_name'] = $slug . $sort_image . '_' . date('Y-m-d-H-i-s') . '.' . $imageNew->getClientOriginalExtension();
        $data['file_sort'] = $sort_image;

        return $data;
    }

    public function saveImage($model, $data)
    {
        $model->media()->create([
            'file_name'  => $data['file_name'],
            'file_sort' => $data['file_sort'],
            'file_status' => 1,
        ]);
    }

    public function deleteIMageFromLoaclStorage($diskName,$old_images)
    {
        foreach ($old_images as $image) {
            Storage::disk($diskName)->delete($image->file_name);
        }
    }

    public function deleteImage($diskName,$old_image)
    {
        Storage::disk($diskName)->delete($old_image->file_name);
    }
}
