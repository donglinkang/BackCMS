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
            $archiveFields = new \App\Models\ArchiveField;
            foreach ( $name as $where ) {
                if ( !$not )
                    $archiveFields = $archiveFields->whereName( $where );
                else
                    $archiveFields = $archiveFields->where( 'name', '!=', $where );
            }

            $archiveFields = $archiveFields->first()->getArchive;
        } else {
            if ( !$not )
                $archiveFields = \App\Models\ArchiveField::where( 'name', '!=', $name )->first()->getArchive;
            else
                $archiveFields = \App\Models\ArchiveField::where( 'name', '!=', $name )->first()->getArchive;
        }

        if ( !is_null( $limit ) ) {
            $archiveFields = $archiveFields->take( $limit );
        }

        foreach ( $archiveFields as $key => $data ) {
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

function template( $name )
{
    $template = \App\Models\Template::whereName( $name )->first();

    return $template;
}

function selectById( $ids, $not = false )
{
    $archive = new \App\Models\Archive;

    if ( is_array( $ids ) ) {
        if ( $not ) {
            $archive = $archive->whereIn( 'id', $ids );
        } else {
            $archive = $archive->whereNotIn( 'id', $ids );
        }
    } else {
        if ( $not ) {
            $archive = $archive->whereId( 'id', '!=', $ids );
        } else {
            $archive = $archive->whereId( $ids );
        }
    }

    return $archive = $archive->get();

    return $archive;
}

function category( $type, $name, $limit = null, $not = false )
{
    $datas = null;

    $type = strtolower( $type );

    if ( $type == 'archive' ) {
        if ( is_array( $name ) ) {
            $archiveField = new \App\Models\ArchiveField;
            foreach ( $name as $where ) {
                if ( !$not )
                    $archiveField = $archiveField->whereName( $where );
                else
                    $archiveField = $archiveField->where( 'name', '!=', $where );
            }

            $archiveField = $archiveField->get();
        } else {
            if ( !$not )
                $archiveField = \App\Models\ArchiveField::where( 'name', '!=', $name )->get();
            else
                $archiveField = \App\Models\ArchiveField::where( 'name', '!=', $name )->get();
        }

        if ( !is_null( $limit ) ) {
            $archiveField = $archiveField->take( $limit );
        }
    }

    return $archiveField;
}

function breadcrumb()
{
    $home         = '<li><a href="/">首页</a></li>';
    $brehwadcrumb = null;

    list( $controller, $action ) = Request()->segments();

    $breadcrumb = $home . $brehwadcrumb;

    return $breadcrumb;
}

function configures( $type = 'all', $names = null )
{
    $configures = new \App\Models\Configure;

    $configures = $configures->select( [ 'key', 'value', 'name' ] );

    if ( $type == 'system' ) {
        $configures = $configures->whereType( 1 );
    } else if ( $type == 'user' ) {
        $configures = $configures->whereType( 0 );
    }

    if ( !is_null( $names ) && is_array( $names ) ) {
        foreach ( $names as $key => $value ) {
            $configures = $configures->orWhere( 'name', '=', $value );
        }
    }

    $configures = $configures->get();

    return $configures;
}

function loopArray( $str, $delimiter = '|' )
{
    return explode( $delimiter, $str );
}

function version()
{
    return '1.0.0';
}

function helloWorld()
{
    return 'Hello World';
}