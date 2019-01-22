<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

/**
 * Class ShortenedURL
 * @package App\Http\Controllers
 */
class ShortenedURL extends Controller
{


    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('shortener');
    }


    /**
     * Checks whether the requested ShortName (URL query) is already stored in /../storage/app/shortenedURLs.json
     * @param Request $request
     * @return int [1 = unique ShortName]
     */
    public function nameCheck(Request $request)
    {
        $name = $request->input('short_name');
        $content = Storage::get('shortenedURLs.json');
        $content = json_decode($content);
        foreach ($content as $short_name => $destiny) {
            if ($short_name == $name) {
                return 0;
            }
        }

        return 1;
    }


    /**
     * Insert a custom ShortName and correspondent LongURL in /../storage/app/shortenedURLs.json
     * @param Request $request
     * @return int [1 = insert was successfull]
     */
    public function insert(Request $request)
    {
        $long_url = $request->input('long_url');
        $short_name = $request->input('short_name');
        $newData= [$short_name => $long_url];


        $contents = (array) json_decode(Storage::get('shortenedURLs.json'));
        $contents += $newData;
        $json = json_encode($contents, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
        Storage::put('shortenedURLs.json', $json);
        return 1;
    }


    /**
     * Searches for ShortName's correspondent LongURL and if ShortName is found, then redirects the page to LongURL.
     * If no ShortName is found, then shows shortenerNotFound page.
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function redirect(Request $request)
    {
        $url = $request->url();
        $name = substr($url, strrpos($url, '/') + 1);


        $content = Storage::get('shortenedURLs.json');
        $content = json_decode($content, JSON_UNESCAPED_SLASHES);


        foreach ($content as $short_name => $destiny) {
            if ($short_name == $name){
                return redirect()->away($destiny);
            }
        }


        return view('shortenerNotFound');
    }


}
