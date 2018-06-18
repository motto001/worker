<?php

namespace App\Http\Controllers\Worker;
use Illuminate\Support\MessageBag;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Worker;
use App\User;
use App\Wrole;
use App\Timeframe;
use App\Status;
use App\Workertype;
use App\Workergroup;


class WorkersController extends Controller
{
use  \App\Handler\trt\Show;
    public $BASE=[];

    public function __construct(Request $request) 
    {

        $this->BASE['request'] = $request;
        $this->BASE['userid']=\Auth::id();
    }
    protected $par= [
       // 'info_button_link' => '/root/info/roles/info', // role/controller/viewdir/blade
      //  'create_info_button_link' => '/root/info/roles/infocreate', // role/controller/viewdir/blade
        // 'baseroute'=>'manager/wroletimes', // a routes-be kerüt (base)
     //   'get_key'=>'wworker', //láncnál ezzel az előtaggal azonosítja a rávonatkozó get tagokat
        'routes'=>['base'=>'worker/workers'], //A _GET ben ['get_key']._ret ben érkező értéket fordítja le routra pl.: wrtime_ret=wru esetén a route  manager/wroleunit lesz
      //   'view'=>'crudbase_3.show', //innen csatolják be a taskok a vieweket lényegében form és tabla. A crudview-et egészítik ki
        // 'crudview'=>'crudbase_3', //A view ek keret twemplétjei. Ha tudnak majd formot és táblát generálni ez lesz a view
         'cim'=>'Személyes adatok',
         'show'=>[
             ['colname'=>'id','label'=>'Id'],
             ['colname'=>'fullname','label'=>'név'],
             ['colname'=>'foto','label'=>'Foto','func'=>'image'],
             ['colname'=>'cim','label'=>'Cím'],
             ['colname'=>'birth','label'=>'Születési dátum'],
             ['colname'=>'tel','label'=>'Telefon'],
             ['colname'=>'ado','label'=>'Adószám'],
             ['colname'=>'tb','label'=>'TBszám'],
             ['colname'=>'start','label'=>'Kezdés'],
            ]
        // 'search'=>false,   
     ];



public function index()
    {
    
        $data=Worker::where('user_id','=',$this->BASE['userid'])->first()->toarray();
        $param=$this->par;
        return view('worker.personal.show', compact('data','param')); 
    }

    public function chPasswd()
    {

        return view('worker.personal.edit');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int      $id
     *aaaA@11111
     * @return void
     */
    public function updatePasswd(MessageBag $message_bag)
    {
        $request=$this->BASE['request'];
        $this->validate($request, [
        'oldpassword' => 'required', 
        'password' => 'required|min:6|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{6,}$/',
         'password2' => 'required|same:password']);
        $data['password'] = bcrypt($request->password);
        $oldpasswd=bcrypt($request->oldpassword);
        $user = User::findOrFail($this->BASE['userid']);
        
     //   echo $oldpasswd.'-------'.$user->password;
      //  exit();
            if(Hash::check($request->oldpassword,$user->password)){
                $user->update($data);
              //  Session::flash('flash_message', 'jelszó frissítve!');
                return redirect('worker/personal')->with('flash_message','jelszó frissítve!');
            }
            else{
              //  Session::flash('flash_message', 'Régi jelszó nem emegfelelő');
              $message_bag->add('token', 'Régi jelszó nem megfelelő');
            ///  return redirect('/products')->withErrors($message_bag);
                return redirect('worker/chpasswd')->withErrors($message_bag);
            }   

        
    }

}
