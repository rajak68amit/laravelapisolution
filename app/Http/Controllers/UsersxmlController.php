<?php

namespace App\Http\Controllers;

use DB;
use App\Model\Usersxml;
use Illuminate\Http\Request;
use Orchestra\Parser\Xml\Facade as XmlParser;
use Illuminate\Support\Facades\Validator;
use Mtownsend\XmlToArray\XmlToArray;

class UsersxmlController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        return view('xml');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $out = array();
        $dbarray = array();
        $uploads = $request->file('xml');
        $filePath = $uploads->getRealPath();
        $xmlObject = simplexml_load_file($filePath);
        $array = json_decode(json_encode((array) $xmlObject), TRUE);
        $usersxml = new Usersxml();
        foreach ((array) $array as $index => $node) {
            $out[$index] = ( is_object($node) ) ? xml2array($node) : $node;
        }
        foreach ($out as $key => $outIteam) {
            $i = 0;
            foreach ($outIteam as $outIteams) {

                foreach ($outIteams as $key => $gdata) {
                    $dbarray[$i][$key] = $gdata;
                }
                $i++;
            }
        }
        DB::table('userxml')->insert($dbarray);
    }

    public function storeneww(Request $request) {
        $outiteam = array();
        $uploads = $request->file('xml');
        $filePath = $uploads->getRealPath();
        $xmlObject = simplexml_load_file($filePath);
        $array = (array) $xmlObject;
        foreach ($array as $arrayIteam) {
            foreach ($arrayIteam as $key => $arrayIteamget) {
                $outiteam[$key]['name'] = $arrayIteamget->name;
                $outiteam[$key]['address'] = $arrayIteamget->address;
                $outiteam[$key]['gender'] = $arrayIteamget->gender;
            }
        }

        print_r($outiteam);
        die();
    }

    public function storebkup(Request $request) {
        $out = array();
        $uploads = $request->file('xml');
        $filePath = $uploads->getRealPath();
        $xmlObject = simplexml_load_file($filePath);
        //$array = json_decode(json_encode((array) $xmlObject), TRUE);
        $array = (array) $xmlObject;

//        print_r((array) $array);
//        die();
//        $array = (array) $xmlObject;
//        $get = $array['employees'];
//        $arrayo = (array) $get;
//        $hdata = $arrayo['employee'];
//        $hdata1 = (array) $hdata;


        foreach ($array as $arrayIteam) {
            foreach ($arrayIteam as $arrayIteamget) {
                echo $arrayIteamget->name . "<br>";
            }
        }

        die();

        foreach ((array) $array as $index => $node) {
            $out[$index] = ( is_object($node) ) ? xml2array($node) : $node;

            return $out;
        }
        print_r((json_decode($out)));

        die();
        echo "<pre>";
        if (is_array($gt)) {
            foreach ($gt as &$value) {
                foreach ($value as &$getvalue) {
                    print_r($getvalue);
                }
            }
        }
        die();
        $data = $request->xml;
        $path = $request->file->getRealPath();
//        $informationdata = array('file' => $data);
//        $rules = array(
//            'file' => 'required|mimes:xml|Max:10000',
//        );
//        $validator = Validator::make($informationdata, $rules);
//        if ($validator->fails()) {
//            echo 'the file has not the correct extension';
//        } else {
//            XmlParser::load($data->getRealPath());
//        }
//        $xml_object = simplexml_load_file($request->file('xml')->getRealPath());
//        var_dump($xml_object);
        echo $image = time() . '-' . $data->getClientOriginalName();
        //$destinationPath = public_path($folder_path);
        die();
        //dd("before");
        $image = '';
        if ($request->hasFile('xml')) {
            dd("kljdsl;00");
            $photo = $request->file('xml');

            //try {
            $image = time() . '-' . $photo->getClientOriginalName();
            $destinationPath = public_path($folder_path);
            dd($destinationPath);
            //$photo->move($destinationPath, $image);
//            } catch (Exception $e) {
//                Session::flash('error', 'Error Occured while uploading image');
//                return redirect()->route('admin.slider.manage');
//            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Usersxml  $usersxml
     * @return \Illuminate\Http\Response
     */
    public function show(Usersxml $usersxml) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\Usersxml  $usersxml
     * @return \Illuminate\Http\Response
     */
    public function edit(Usersxml $usersxml) {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Usersxml  $usersxml
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Usersxml $usersxml) {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Usersxml  $usersxml
     * @return \Illuminate\Http\Response
     */
    public function destroy(Usersxml $usersxml) {
        //
    }

}
