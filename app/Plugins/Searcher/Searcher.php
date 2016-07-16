<?php
namespace App\Plugins\Searcher;

use App\Http\Requests\Request;

class Searcher
{

    /*
     * 指定当前目录下 显示此数据的视图
     * */
    public $dataSource = false;

    public function run( $name = null )
    {
        $wd = Request()->input( 'wd' );

        return $this->getQuery( $wd );
    }

    protected function getQuery( $wd )
    {
        $archives = \App\Models\Archive::select( [ 'id', 'title', 'body' ] )->where( 'title', 'like', "%$wd%" )->get();

        $args = [
            'archives' => $archives,
            'wd'       => $wd
        ];

        return compileBlade( template( '搜索' )->code, $args );
    }

}