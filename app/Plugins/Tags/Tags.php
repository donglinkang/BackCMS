<?php
namespace App\Plugins\Tags;

class Tags
{

    public function run( $args = [ ] )
    {
        switch ( $args[ 'type' ] ) {
            case 'text':
                return $this->getText( $args );
            case 'html':
                return $this->getHtml( $args );
            case 'markdown':
                return $this->getMarkDown( $args );
            case 'datetime':
                return $this->getDateTime( $args );
            case 'time':
                return $this->getTime( $args );
            case 'select':
                return $this->getSelect( $args );
            case 'boolean':
                return $this->getBoolean( $args );
            default:
        }
    }

    protected function getText( $args )
    {
        return $this->load( 'Text', $args );
    }

    protected function getMarkDown( $args )
    {
        return $this->load( 'MarkDown', $args );
    }

    protected function getDateTime( $args )
    {
        return $this->load( 'DateTime', $args );
    }

    protected function getTime( $args )
    {
        return $this->load( 'Time', $args );
    }

    protected function getSelect( $args )
    {
        return $this->load( 'Select', $args );
    }

    protected function getBoolean( $args )
    {
        return $this->load( 'Boolean', $args );
    }

    protected function getHtml( $args )
    {
        return $this->load( 'Html', $args );
    }

    protected function load( $view, $args = [ ] )
    {
        return \Plugins::view( class_basename( __CLASS__ ), $view )->with( $args )->render();
    }

}