<?php

namespace App\Services;

use App\Http\Trait\Imageable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class ProfileAuthService
{
    use Imageable;

    public function userProfile($guard)
    {
        return Auth::guard($guard)->user();

    }

    public function update($request, Model $model, $guard,$diskName,$pathImage)
    {
        $instance = $model::whereId(auth($guard)->user()->id)->first();
        $instance->update($request->except('image'));
        $this->updateImage($request,$diskName,$pathImage,$instance);

        return response()->json([
            'message' => __('services.profile_updated'),
            'status' => Response::HTTP_ACCEPTED
        ],Response::HTTP_ACCEPTED);
    }


    public function changePassword($request, Model $model, $guard)
    {
        $instance = $model::find(Auth::guard($guard)->user()->id);
        $instance->update([
            'password' => $request->password
        ]);
        return response()->json([
            'message' => __('services.password_updated'),
            'status' => Response::HTTP_OK
        ]);
    }

    private function updateImage($request, $diskName, $pathImage,$instance)
    {
        if($request->file('image')){
            //remove old Image
            $image = $instance->media()->first();
            if($image){
                $this->deleteImage($diskName,$image);
                $instance->media->delete();

            }
            //insert New Image
            $newImage = $this->insertImage($instance->first_name,$request->image,$pathImage);
            $this->insertImageInMeddiable($instance,$newImage,'media');
        }
    }
}
