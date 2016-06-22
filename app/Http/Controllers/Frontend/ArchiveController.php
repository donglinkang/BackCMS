<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class ArchiveController extends Controller
{
    public function getIndex()
    {

    }

    public function getList( $id )
    {
        $archiveField = \App\ArchiveField::with( 'getArchive' )->whereId( $id )->first();

        $args = [
            'archiveField' => $archiveField,
        ];

        return compileBlade( $archiveField->getListTemplate->code, $args );
    }

    public function getShow( $id )
    {
        $archive  = \App\Archive::find( $id );
        $args     = json_decode( $archive->body, true );

        return compileBlade( $archive->getArchiveField->getShowTemplate->code, $args );
    }
}
