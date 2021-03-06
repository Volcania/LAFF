<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class postitusController extends Controller
{
    protected $leheküljel=3;


    public function index(\Illuminate\Http\Request $request)
    {

        Session::put('redirectTo', 'postitus');


        $postitusi = DB::select('CALL postituste_arv()'); //mitu postitust on süsteemis
        $postitus = DB::table('postitus_vaade')->paginate($this->leheküljel);

        //See osa siin on vajalik lehekülje osade hilisema laadimise jaoks. Kui pöördutakse ajaxiga, siis laetakse veidikene teine leht
        if ($request->ajax()) {
            return ["postitus"=>view("ajaxStuff.ajax.index", ['postitusi'=>$postitusi])->with('postitus',$postitus)->render(),
                'next_page' =>$postitus->nextPageUrl()
            ];
        }


        return view("postitus", ['postitusi' => $postitusi])->with('postitus', $postitus);
    }

    public function best(\Illuminate\Http\Request $request) {
        Session::put('redirectTo', 'postitus');


        $postitusi = DB::select('CALL postituste_arv()'); //mitu postitust on süsteemis
        $postitus = DB::table('postitus_vaade')->orderBy('reiting', 'desc')->paginate($this->leheküljel);

        //See osa siin on vajalik lehekülje osade hilisema laadimise jaoks. Kui pöördutakse ajaxiga, siis laetakse veidikene teine leht
        if ($request->ajax()) {
            return ["postitus"=>view("ajaxStuff.ajax.index", ['postitusi'=>$postitusi])->with('postitus',$postitus)->render(),
                'next_page' =>$postitus->nextPageUrl()
            ];
        }
        return view("postitus", ['postitusi' => $postitusi])->with('postitus', $postitus);

    }


    public function recent(\Illuminate\Http\Request $request)
    {

        Session::put('redirectTo', 'postitus');


        $postitusi = DB::select('CALL postituste_arv()'); //mitu postitust on süsteemis
        $postitus = DB::table('postitus_vaade')->orderBy('date', 'asc')->paginate($this->leheküljel);

        //See osa siin on vajalik lehekülje osade hilisema laadimise jaoks. Kui pöördutakse ajaxiga, siis laetakse veidikene teine leht
        if ($request->ajax()) {
            return ["postitus"=>view("ajaxStuff.ajax.index", ['postitusi'=>$postitusi])->with('postitus',$postitus)->render(),
                'next_page' =>$postitus->nextPageUrl()
            ];
        }


        return view("postitus", ['postitusi' => $postitusi])->with('postitus', $postitus);
    }

    public function deleteAd($ad_id) {
        $postitus = DB::table('postitus_vaade')->get()->where('id', $ad_id)->first();
        if (auth()->user()->kasutajanimi != $postitus->kasutaja) {
            return redirect()->back();
        }


        DB::select('CALL kustuta_postitus(?)', array($postitus->id));

        Session::put('redirectTo', 'postitus');

        Session::flash('message', 'Ad');

        return redirect(url('postitus'));
    }

    public function deleteAdProfile($ad_id) {
        $postitus = DB::table('postitus_vaade')->get()->where('id', $ad_id)->first();
        if (auth()->user()->kasutajanimi != $postitus->kasutaja) {
                return redirect()->back();
        }
        DB::select('CALL kustuta_postitus(?)', array($postitus->id));
        Session::flash('message', 'Ad');
        return redirect()->back();
    }

    public function search(\Illuminate\Http\Request $request) {
        $this->validate($request, [
            'search' => 'max:100|min:1'
        ]);
        //$post = new Post();*/

        $otsitav=$request->input('search');


        $filtreeritud=DB::select('Call search(?)',array($otsitav));
        return view('search')->with('postitus',$filtreeritud);
    }

    public function update(Request $request) {
        if ($request->ajax()) {
            if (auth()->check()) {
                $id = $request->input('id');
                $title = $request->input('title');
                $payload = $request->input('payload');

                DB::select('CALL uuenda_postitus(?,?,?)', array($id,$title,$payload));
            }
        } else {
            return 'Not ajax request';
        }
    }



    public function deleteOne() {
        DB::select('CALL delete_one(?)',array(auth()->user()->id));
        Session::flash('message', 'Ad');
        return redirect()->back();

    }

    public function deleteAll() {
        DB::select('CALL delete_all(?)', array(auth()->user()->id));
        Session::flash('message', 'Ad');
        return redirect()->back();
    }
}