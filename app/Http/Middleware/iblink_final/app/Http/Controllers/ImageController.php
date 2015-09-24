<?php namespace App\Http\Controllers;

use Illuminate\Foundation\Validation\ValidatesRequests;
use Input;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use Validator;

class ImageController extends Base\BaseController  {

    use ValidatesRequests;

    protected $request;

    public function __construct(Request $request) {
        $this->request = $request;
    }

    public function upload() {

        $data = [
            'image'     => ($uploadedImage = Input::file('image')),
            'extension' => $uploadedImage ? strtolower($uploadedImage->getClientOriginalExtension()) : '',
        ];

        $validator = Validator::make($data, [
            'image'     => 'required|image',
            'extension' => 'in:jpg,png,bmp,gif',
        ], [
            'image.required' => 'Nu ați selectat un fișier',
            'image.image'    => 'Nu ați selectat o imagine validă',
            'extension.in'  => 'Nu ați selectat o imagine validă',
        ]);

        if ($validator->fails()) {
            $this->throwValidationException($this->request, $validator);
        }

        $unique   = uniqid();
        $filename = "orig_{$unique}.{$data['extension']}";
        $thumb    = "thumb_{$unique}.{$data['extension']}";
        $dir      = '/uploads/';

        Image::make($uploadedImage)
             ->save(public_path($dir . $filename))
             ->fit(180, 180)
             ->save(public_path($dir . $thumb));

        return [
            'thumb' => asset($dir . $thumb),
            'file'  => $dir . $thumb,
        ];
    }
}
