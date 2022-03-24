<?php

namespace App\Model;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Pet extends Model
{
    use Sluggable;
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }
    protected $fillable = [
        'name', 'type_id', 'breed_id', 'birthday', 'gender', 'weight', 'height', 'status', 'price', 'description'
    ];
    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function reservation()
    {
        return $this->hasOne(Reservation::class);
    }
    public function breed()
    {
        return $this->belongsTo(Breed::class);
    }
    public function type()
    {
        return $this->belongsTo(Type::class);
    }
    public function getAge()
    {
        $years = Carbon::parse($this->birthday)->age;
        if ($years == 0) {
            $age = Carbon::createFromDate($this->birthday)->diff(Carbon::now())->format('%m months');
        } else {
            $age = Carbon::createFromDate($this->birthday)->diff(Carbon::now())->format('%y years and %m months');
        }
        return $age;
    }
    public function saveImages($images)
    {
        $image_names = [];
        foreach ($images as $image) {
            $imageName = Str::random(10) . '_' .  $image->getClientOriginalName();
            $image->storeAs('images/pets', $imageName, 'public');
            $image_names[] = $imageName;
        }
        return $image_names;
    }
    public function deleteImages($images)
    {
        if ($images) {
            $images = json_decode($images);
            foreach ($images as $image) {
                Storage::delete('/public/images/pets/' . $image);
            }
        }
        return;
    }
    //save description image in database and return path
    public function getDescription($description, $slug)
    {
        if ($description == null) {
            return null;
        }

        $path = 'storage/images/pets/' . $slug;
        if (!file_exists($path)) {
            $files = new Filesystem;
            $files->makeDirectory($path);
        }
        //Prepare HTML & ignore HTML errors
        $dom = new \domdocument();
        $dom->loadHtml($description, LIBXML_NOWARNING | LIBXML_NOERROR);

        //identify img element
        $images = $dom->getelementsbytagname('img');
        $image_names = [];
        //loop over img elements, decode their base64 source data (src) and save them to folder,
        //and then replace base64 src with stored image URL.
        foreach ($images as $k => $img) {

            //collect img source data
            $data = $img->getattribute('src');

            //checking if img source data is image by detecting 'data:image' in string
            if (strpos($data, 'data:image') !== false) {
                list($type, $data) = explode(';', $data);
                list(, $data)      = explode(',', $data);

                //decode base64
                $data = base64_decode($data);

                //naming image file
                $image_name = time() . rand(000, 999) . $k . '.png';
                // image path (path) to use upload file to
                $image_path = $path . '/' . $image_name;
                //image path (path2) to save to DB so that summernote can display image in edit mode (When editing summernote content) NB: the difference btwn path and path2 is the forward slash "/" in path2
                $path2 = '/storage/images/pets/' .  $slug . '/' . $image_name;
                $image_names[] = $path2;
                file_put_contents($image_path, $data);
                // modify image source data in summernote content before upload to DB
                $img->removeattribute('src');
                $img->setattribute('src', $path2);
            } else {
                $image_names[] = $data; //if not data:image, just save the image source data to array // expected to be the image path of previous upload
            }
        }

        // to delete images on update if not in summernote content
        if ($image_names) {
            $saved_images = glob($path . '/*'); // get all file names saved in specified folder
            // remove the first / in image names to match the image path in storage
            foreach ($image_names as $key => $image_name) {
                $image_names[$key] = substr($image_name, 1);
            }
            // compare the file names in specified folder and the file names in summernote content
            $result = array_diff($saved_images, $image_names);
            foreach ($result as $image) {
                // delete the file if not in summernote content or  has been deleted in summernote content
                unlink($image);
            }
        } else {
            $this->deleteDescriptionImages($slug);
        }
        // final variable to store in DB
        $description = $dom->savehtml();
        return $description;
    }


    public function deleteDescriptionImages($slug)
    {
        $path = 'storage/images/pets/' . $slug;
        if (file_exists($path)) {
            $files = new Filesystem;
            $files->deleteDirectory($path);
        }
    }
}
