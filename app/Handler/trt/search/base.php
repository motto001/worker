<?php

namespace App\Handler\trt\search;

//use Session;
//use Illuminate\Support\Facades\Input;
//use Illuminate\Support\Facades\Image;
trait Base
{
    public function get_searchT($keyword, $resmod = 'all')
    {
        $res = [];
        if (isset($this->BASE['search_column'])) {
            if (!is_array($this->BASE['search_column'])) {$this->BASE['search_column'] = explode(',', $this->BASE['search_column']);}
            foreach ($this->BASE['search_column'] as $key) {
                $res[] = [$key, 'LIKE', "%$keyword%"];
            }
            if ($resmod = 'firstno') {unset($res[0]);} else if ($resmod = 'first') {$res = $res[0];}
        }
        if (empty($res)) {$res[] = ['id', '>', "0"];}
        return $res;
    }

    public function search()
    {
        $search_columnT=$this->get_searchT($keyword);
        $ob =$this->BASE['ob_res'] ?? $this->BASE['ob']; 
        $ob = $ob->where('id', '<', "1");
            foreach($search_columnT as $col)
            {
                $ob=$ob->orwhere('name', 'LIKE', "%$keyword%");
            }
			return $ob->paginate($perPage);

    }
}
