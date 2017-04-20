<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class commentsController extends Controller
{

    //Loeb sisse kommentaarid, mis seotud antud id'ga postitusega ja tagastab vaate selle postitusega
    public function index($id) {
        $postitus = DB::table('postitus_vaade')->get()->where('id',$id);
        $posts=DB::table('kommentaar')->get()->where('postitus_id',$id);
        return view('kommentaar',['kommentaarid' => $posts])->with('data',$postitus );
        //return $id;
    }


    //Kommentaari lisamine läbi protseduuri
    public function postCreatePost(Request $request, $id)
    {

        $this->validate($request, [
            'body' => 'required|max:1000'
        ]);
        //$post = new Post();*/

        $teema=$request->input('body');
        $kasutaja = auth()->user()->kasutajanimi;

        //$name = $request->imelik;
        DB::select('CALL lisa_kommentaar (?,?,?)',array($teema, $kasutaja, $id));
        return redirect()->back();

    }

    //Kommentaari eemaldamine läbi protseduuri
    public function getDeletePost($post_id)
    {
        $post = DB::table('kommentaar')->get()->where('id', $post_id)->first();
        if (auth()->user()->kasutajanimi != $post->kasutaja_nimi) {
            return redirect()->back();
        }
        DB::select('CALL kustuta_kommentaar(?)', array($post->id));
        //return redirect()->route('dashboard')->with(['message' => 'Successfully deleted!']);
        return redirect()->back();
    }


    //TODO Kommentaaride muutmine, pole realiseeritud. midagi on katki
    public function postEditPost(Request $request)
    {
        $this->validate($request, [
            'body' => 'required'
        ]);
        $post = Post::find($request['postId']);
        if (Auth::user() != $post->user) {
            return redirect()->back();
        }
        $post->body = $request['body'];
        $post->update();
        return response()->json(['new_body' => $post->body], 200);
    }
}