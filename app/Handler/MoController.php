<?php

namespace App\Handler;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
/*
CRUD lánc késztíés:
 a  crud hívó linkjébe beletesszük a hívott crud viszarérő route azonosítóját 
 pl hívó crud: 'Wrole' azonosítója(PAR['get_key']): 'wr' base routja: 'manager/wrole'
  hívott crud: 'Wroleunit' azonosítója: 'wrunit'
  a crud hívó linkbe (közvtlenül vagy a getT-el) be kell tenni a 'wrunit_redir=wr' értéket
  a hívott crud PAR['routes'] tömbjébe be kell állítani a 'wr'=>'manager/wrole' értéket
  valamint ha a lánc foltatódik akkor a hívott crud PAR['get']-be: 'wrunit_redir'=>null hogy tovább tudja adni
  és így tovább...
  -----------------------------
  minden hívó crud-nak ell kkell küldenie GET-ben aa saját redir route azonosítóját. Ami hagyományosan a PAR['get_key'];
  a GET kulcs a hívott crud azonosítójából és a '_redir' stringből áll
 ----------------------------
  minden hívott crudnak tovább kell adnia az összes elző crud redir azonosítóját. 
  valamint tartalmaznia kell a PAR['routes'] tömbben azon crud-ok routjait
  amik őt hívhatják a redir azonosítójuk kulcsával.
*/

class MoController extends Controller
{
//  use  App\Handler\trt\crud\Crud; vagy App\Handler\trt\crud\CrudWithSetfunc
// use  \App\Handler\trt\SetController;

/***
 * minden view-el megosztott adatok
 */
protected $PAR= [ 
    'view_varname'=>'param', // ezen a néven kapják meg a view-ek a $PAR-t
    'get_key'=>'', //pl.:'wrtime' Láncnál ezzel az előtaggal azonosítja  a controller a rávonatkozó get tagokat
    'routes'=>[],
    //pl.:['base'=>'manager/wroletimes','wru'=>'manager/wroleunits']
    //Láncnál a _GET ben érkező ['get_key'].'_redir'  értéket fordítja le routra 
    //pl.: a writme 'get_key'-el rendelkező conroller esetén, a fenti példa routes-el
    //ha a 'getT'-ben: wrtime_redir=wru szrepel, a base_redirect()  a manager/wroleunits -ra irányít
    'view'=>'', 
    //pl.:'manager.wrunit_times'
    //innen csatolják be a taskok a vieweket lényegében form és tabla. A crudview-et egészítik ki
    'crudview'=>'crudbase_3', //A view ek keret twemplétjei. Ha tudnak majd formot és táblát generálni ez lesz a view
    'cim'=>'',  //a templétben megjelenő cím
    'getT'=>[], 
    //pl.: ['wru'=>'0']
    // A templéttel megosztott get tömb.A $this->url()  ebből generálja az url get paramétereit (MoHandF::url()-t használja)
    'search'=>true,  // ha false kikapcsolja az index táblázat kereső mezőjét
    
];
/**
 * taskok PAR értékei, a Handler\trt\SetController->set_task() az aktuális task kulcsa alatt szereplő értékekkel felül írja a $PAR értékeit
 */
protected $TPAR= [];

/**
 * a controller által használt alap adatok, paraméterek 
 */
protected $BASE= [
    'perpage'=>50, //táblázat ennyi elemet listáz
    'search_column'=>'',
    //pl.:'daytype_id,datum,managernote,usernote'
    // ha a search be van kapcsolva ezekben a mezőkben keres
    'get'=>['wru_redir'=>null],
    //pl.:['wru_id'=>'0','wru_redir'=>null,'wrole_id'=>null,'wrole_ret'=>null,'worker_id'=>null], //többszörös lánc!
    //a trait setController->set_getT() ez alapján tölti fel a PAR['getT']-t.
    //Ha az aktuális url get paraméterei Között szerepel a tömb kulcsai közül valamelyik, akor azt  az url ben szereplő értékkell, bemásolja a PAR['getT']-be.
    //Ha az url-ben nem szerepel  akkor az itt szereplő értékkel kerül be a PAR['getT']-be
    //Ha az url-ben nem szerepel és az érték null nem kerül bea PAR['getT']-be.
    'get_post'=>[],//ugyanaz mint a 'get' csak  ha van ilyen kulcs a postban azzal felülírja
    'obname'=>'\App\Wroletime',
     //a $this->set_ob() funkció ( acontroller tartalmazza csak a 'func'-tömbbe szerepelnie kell) 
     //ez alapján készíti el az aktuális objektumot aZ 'ob' kulcsra
    'ob'=>null,
    'request',  //construktor másolja ide az aktuális requestet
    'data'=>[], // az aktuális viewnek átadott adatok
    'func'=>[ // a constructor által lefuttatni kívánt funkciók  
    'set_baseparam',  //hogy ne kelljen  a set base felülírnii
    'set_task', //\App\Handler\trt\SetController
    'set_getT', //\App\Handler\trt\SetController
    'set_redir',
    'set_routes',
    //'getT_honosit', //\App\Handler\trt\SetController, eltávolítja a 'getT' kulcsai elől 
    'set_ob',   //$this, a fő objektumot állítja elő az 'ob'-ba az 'obname' alapján 
],
];
/**
 * taskok base értékei, a Handler\trt\SetController->set_task() az aktuális task kulcsa alatt szereplő értékekkel felül írja a $BASE értékeit
 */
protected $TBASE= [
/* 'index'=> [  
    'task_func'=>['index_base','index_set']//az aktuális task (index) által lefuttatni kívánt funkciók 
    'base_func' =>['with',' where_or_search','order_by'],//index_base hívja meg
    ], 
 
    'create'=> ['task_func'=>['create_set']],
    'store'=> ['task_func'=>['store_set']],
    'edit'=> ['task_func'=>['edit_set']],
    'update'=> ['task_func'=>['update_set']],
    'destroy'=> ['task_func'=>['destroy_set']],
    'show'=> ['task_func'=>['show_set']],*/
];
/**
 * a create task validációs tömbje
 */
protected $val= [];//pl.:['wroleunit_id' => 'required|integer','end' => 'date_format:H:i','note' => 'string|max:200|nullable']   
/**
 *  az update task validációs tömbje ha üres az update is a $val-t használja 
 */
protected $val_update= [];
public function set_baseparam()
{}
public function set_base()
{
if(isset($this->par)){$this->PAR= array_merge($this->PAR, $this->par);}    
if(isset($this->base)){$this->BASE= array_merge($this->BASE, $this->base);}
if(isset($this->tbase)){$this->TBASE= array_merge($this->TBASE, $this->tbase);}
if(isset($this->tpar)){$this->TPAR= array_merge($this->TPAR, $this->tpar);}
$task=Input::get('task') ?? \Route::getCurrentRoute()->getActionMethod();

if(isset($this->TPAR[$task])){$this->PAR= array_merge($this->PAR, $this->TPAR[$task]);} 
if(isset($this->TBASE[$task])){$this->BASE= array_merge($this->BASE, $this->TBASE[$task]);} 
$this->PAR['task']=$task;
//if($task!= \Route::getCurrentRoute()->getActionMethod()) {return $this->$task();}
}
/**
 * ha a controller azonosítójával redir érték érkezik (PAR['get_key']_redir)
 * létrehozza  $this->PAR['routes']['redir'] értéket
 */
function set_redir(){
     $redirkey=$this->PAR['get_key'].'_redir'; //wru_redir
   //  echo 'redir----------'.$redirkey;
    $redir=$this->PAR['getT'][$redirkey] ?? 'nincs';
   
    if($redir!='nincs')
    {
        $this->PAR['routes']['redir']=$this->PAR['routes'][ $redir];
    }
 //   echo 'redir----------'.$this->PAR['routes']['redir'].'---------------ZZZZ';
}

function set_routes(){
   
  foreach($this->PAR['routes'] as $key=>$rout){
    $routvalT=[];    
    preg_match_all("/\{(\w*)\}/", $rout, $routvalT);
    if(isset($routvalT[1])){
       foreach($routvalT[1] as $routval){ 
           
            if(isset($this->PAR['getT'][$routval]))
            {
                $rout= str_replace('{'.$routval.'}',$this->PAR['getT'][$routval],$rout);
            }
        }   
    }
  $this->PAR['routes'][$key]=$rout;

  }


}
function set_ob(){
    $obname=$this->BASE['obname'];
    $this->BASE['ob']=new $obname();  
}
function call_func($funcT){
        foreach($funcT as $func){
            if(is_callable([$this, $func])) {$this->$func();}  
            else{
                Log::error('Hiányzó controller funkció', ['func' => $func]);
                //error_log('Some message:Hiányzó controller funkció.');
                //$output = new \Symfony\Component\Console\Output\ConsoleOutput(2);
                //$output->writeln('hello');
        }       
}
}

/**
 * ha a $this->PAR['routes']['redir'] érték létezik
 * akkor a routes tömb annak megfelelő kulcsú routjára irányít 
 * ha nincs akkor a $this->BASE['redir']['base'] kulcs alatt lévő routra
 */
public function   base_redirect(){
   $redir=$this->PAR['routes']['redir'] ?? $this->PAR['routes']['base'];
   return  redirect(\MoHandF::url($redir, $this->PAR['getT']));  
 }
/**
 * trait-el felülírható ha pl json kimenetet akarunk
 */
 public function   base_view($task='index'){
    $data=$this->BASE['data'];
    return view($this->PAR['view'].'.'.$task, compact('data')); 
   //return \MoViewF::view( $this->PAR['view'].'.index',$data);

 }
    function __construct(Request $request){

        $this->BASE['request']=$request;
    
        $this->set_base(); //taskok értékeivel felül írja a PAR és A BASE  tömböket.
        // a BASE['func']-ot is. Ezért  kell még a call_func előtt meghívni 
        $this->call_func($this->BASE['func']);       
        $share_param_name=$this->PAR['varname'] ?? 'param';
        View::share($share_param_name,$this->PAR);
        $task=$this->PAR['task'];
        if($task!= \Route::getCurrentRoute()->getActionMethod()) {return $this->$task();}
       }

}