<?php

function compileBlade( $content, $args = null )
{
    \Plugins::register( 'template', 'App\Plugins\Template\Template' );

    $templateString = \Plugins::call( 'template' )->getCompile( $content );
    $blade          = app( 'view' )->getEngineResolver()->resolve( 'blade' )->getCompiler();
    $phpString      = $blade->compileString( $templateString );

    if ( !is_null( $args ) ) extract( $args, EXTR_SKIP );
    ob_start();
    eval( '?> ' . $phpString . ' <?php ' );
    $outHtml = ob_get_clean();

    return $outHtml;
}

function version()
{
    return '1.0.0';
}

function helloWorld()
{
    return 'Hello World';
}