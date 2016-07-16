<?php
namespace App\Plugins\PayCart;

use App\Http\Requests\Request;

class PayCart
{

    /*
     * 指定当前目录下 显示此数据的视图
     * */
    public $dataSourceView = 'List';
    public $dataSource     = 'getListJson';

    public function run( $name = null )
    {
        $type = Request()->input( 'type' );

        if ( $type == 'information' )
            return $this->information( $name );
        else if ( $type == 'pay_submit' )
            return $this->paySubmit();
        else if ( $type == 'pay_notify' )
            return $this->payNotify();
    }

    public function information( $name )
    {
        if ( !Auth()->guest() ) {

            $body = Request()->except( '_token' );

            $body = array_merge( $body, [
                'user_id'       => Auth()->user()->id,
                'payStatus'     => 'pay_wait',
                'disposeStatus' => 'dispose_wait'
            ] );

            $form         = new \App\Models\Form;
            $form->body   = json_encode( $body );
            $form->plugin = $name;
            $form->token  = date( 'Ymdhis' ) . Auth()->user()->id . rand( 11111, 99999 );

            if ( $form->save() ) {
                return Response()->json( [
                    'code'    => 'success',
                    'token'   => $form->token,
                    'message' => '保存信息成功!'
                ] );
            } else {
                return Response()->json( [
                    'code'    => 'error',
                    'message' => '保存信息失败!',
                ] );
            }
        } else {
            return Response()->json( [
                'code'    => 'error',
                'message' => '请先登录网站!',
            ] );
        }
    }

    public function paySubmit()
    {
        if ( !Auth()->guest() ) {
            $token = Request()->input( 'token' );
        }
    }

    public function payNotify()
    {

    }

    public function getListJson()
    {
        $forms = \App\Models\Form::wherePlugin( lcfirst( class_basename( __CLASS__ ) ) )->get();

        return \Plugins::view( class_basename( __CLASS__ ), $this->dataSourceView )->with( [
            'forms' => $forms
        ] );
    }


}