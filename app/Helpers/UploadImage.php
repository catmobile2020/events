<?php

namespace App\Helpers;

use App\Image;

trait UploadImage
{

    public function upload($file , $imageable , $type = null,$update=false)
    {
        $destination = public_path('uploads');
        $photo = rand(000,999).str_replace(' ','-',$file->getClientOriginalName());
        $file->move($destination, $photo);
        if ($update)
        {
            $img = $imageable->image()->where('type',$type)->first();
            if ($img)
            {
                if (is_file(public_path($img->url)))
                {
                    @unlink(public_path($img->url));
                }
            }else
            {
                $img = new Image();
            }

        }else
        {
            $img = new Image();
        }
        $img->url = 'uploads/'. $photo;
        $img->type = $type;
        $img->imageable()->associate($imageable)->save();
    }


}
