<?php
trait MoControllerMin{
protected $PAR = [
        'view_varname' => 'param', // ezen a néven kapják meg a view-ek a $PAR-t
        'get_key' => '', //pl.:'wrtime' Láncnál ezzel az előtaggal azonosítja  a controller a rávonatkozó get tagokat
        'routes' => ['base'=>''],
        'view' => '',
        'crudview' => 'crudbase_4', //A view ek keret twemplétjei. Ha tudnak majd formot és táblát generálni ez lesz a view
        'cim' => '', //a crud templétben megjelenő cím
        'getT' => [],
        'search' => true, // ha false kikapcsolja az index táblázat kereső mezőjét
        'task'=>'index', //mocontroller construktor beállítja
    ];
    protected $TPAR = [];
    protected $BASE = [
        'viewfunc'=>'mo_view', //ha nincs megadva a laravel viewet használja, a A PAR[view] nem lehet tömb!
        'redirfunc'=>'mo_redirect', //ha nincs megadva a laravel redir használja, a A PAR[routes][base]-el
        'perpage' => 50, //táblázat ennyi elemet listáz
        'search_column' => '',
        'get' => [],
        'get_post' => [], //ugyanaz mint a 'get' csak  ha van ilyen kulcs a postban azzal felülírja
        'obname' => '', //lehet tömb is ha ha a setobArray trait-et  hívjuk be
        'ob' => null,
        'request', //construktor másolja ide az aktuális requestet
        'data' => [], // az aktuális viewnek átadott adatok
       // 'func' => [ // a constructor által lefuttatni kívánt funkciók
            // construktor alapértelmezés: [set_ob,set_baseparam]
        // 'set_baseparam', //hogy ne kelljen  a set base felülírnii
         //   'set_task', //\App\Handler\trt\SetController
          //  'set_getT', //\App\Handler\trt\SetController
         //   'set_redir',
         //   'set_routes',
         //   'set_ob', //$this, a fő objektumot állítja elő az 'ob'-ba az 'obname' alapján
      //  ],
        'orm'=>[],// with,where,orwhere,
    ];

    protected $TBASE = [];

   // protected $val = []; //pl.:['wroleunit_id' => 'required|integer','end' => 'date_format:H:i','note' => 'string|max:200|nullable']
   
   // protected $val_update = [];
}

