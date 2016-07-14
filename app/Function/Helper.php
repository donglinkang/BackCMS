<?php

function compileBlade( $sourceCode, $args = null, $compile = 1 )
{
    \Plugins::register( 'template', 'App\Plugins\Template\Template' );

    $templateString = \Plugins::call( 'template' )->getCompile( $sourceCode );
    $blade          = app( 'view' )->getEngineResolver()->resolve( 'blade' )->getCompiler();
    $phpString      = $blade->compileString( $templateString );

    if ( $compile ) {
        if ( !is_null( $args ) ) extract( $args, EXTR_SKIP );

        ob_start();
        eval( '?> ' . $phpString . ' <?php ' );
        $outHtml = ob_get_clean();

        return $outHtml;
    } else {
        return $phpString;
    }
}

function select( $type, $name, $limit = null, $not = false )
{
    $datas  = null;
    $select = [ ];

    $type = strtolower( $type );

    if ( $type == 'archive' ) {
        if ( is_array( $name ) ) {
            $datas = new \App\Models\ArchiveField;
            foreach ( $name as $where ) {
                if ( !$not )
                    $datas = $datas->whereName( $where );
                else
                    $datas = $datas->where( 'name', '!=', $where );
            }

            $datas = $datas->first()->getArchive;
        } else {
            if ( !$not )
                $datas = \App\Models\ArchiveField::where( 'name', '!=', $name )->first()->getArchive;
            else
                $datas = \App\Models\ArchiveField::where( 'name', '!=', $name )->first()->getArchive;
        }

        if ( !is_null( $limit ) ) {
            $datas = $datas->take( $limit );
        }

        foreach ( $datas as $key => $data ) {
            $select[ $key ][ 'id' ]          = $data->id;
            $select[ $key ][ 'title' ]       = $data->title;
            $select[ $key ][ 'keywords' ]    = $data->keywords;
            $select[ $key ][ 'description' ] = $data->description;
            $select[ $key ][ 'enabled' ]     = $data->enabled;
            $select[ $key ][ 'created_at' ]  = $data->created_at;
            $select[ $key ][ 'updated_at' ]  = $data->updated_at;

            foreach ( json_decode( $data->body, true ) as $field => $value ) {
                $select[ $key ][ $field ] = $value;
            }
        }
    }

    return $select;
}

function category( $type, $name, $limit = null, $not = false )
{
    $datas    = null;
    $category = [ ];

    $type = strtolower( $type );

    if ( $type == 'archive' ) {
        if ( is_array( $name ) ) {
            $datas = new \App\Models\ArchiveField;
            foreach ( $name as $where ) {
                if ( !$not )
                    $datas = $datas->whereName( $where );
                else
                    $datas = $datas->where( 'name', '!=', $where );
            }

            $datas = $datas->get();
        } else {
            if ( !$not )
                $datas = \App\Models\ArchiveField::where( 'name', '!=', $name )->get();
            else
                $datas = \App\Models\ArchiveField::where( 'name', '!=', $name )->get();
        }

        if ( !is_null( $limit ) ) {
            $datas = $datas->take( $limit );
        }
    }

    return $datas;
}

function breadcrumb()
{
    $home       = '<li><a href="/">首页</a></li>';
    $breadcrumb = null;

    list( $controller, $action ) = Request()->segments();

    $breadcrumb = $home .$breadcrumb;

    return $breadcrumb;
}

function version()
{
    return '1.0.0';
}

function helloWorld()
{
    return 'Hello World';
}