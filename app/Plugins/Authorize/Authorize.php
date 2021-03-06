<?php
namespace App\Plugins\Authorize;

use App\Http\Requests\Request;

class Authorize
{

    /*
     * 指定当前目录下 显示此数据的视图
     * */
    public $dataSourceView = 'List';
    public $dataSource     = 'getList';

    public function run( $name = null )
    {
        $type = Request()->input( 'type' );

        if ( $type == 'login' )
            return $this->postLogin();
        else if ( $type == 'register' )
            return $this->postRegister();
        else if ( $type == 'logout' )
            return $this->getLogout();
        else if ( $type == 'welcome' )
            return $this->getWelcome();
    }

    protected function postLogin()
    {
        $username = Request()->input( 'username' );
        $password = Request()->input( 'password' );

        $login = \Auth( 'web' )->attempt( [
            'username' => $username,
            'password' => $password,
        ] );

        if ( $login ) {

            return Response()->json( [
                'code'    => 'success',
                'message' => '登录成功!',
                'auth'    => Auth()->user()
            ] );
        } else {
            return Response()->json( [
                'code'    => 'error',
                'message' => '登录失败!',
            ] );
        }
    }

    protected function postRegister()
    {
        $username = Request()->input( 'username' );
        $password = Request()->input( 'password' );
        $email    = Request()->input( 'email' );
        $nickname = Request()->input( 'nickname' );
        $phone    = Request()->input( 'phone' );

        $v = Validator( Request()->all(), [
            'username' => 'required|unique:users',
            'password' => 'required|min:6|confirmed',
            'email'    => 'required|unique:users|email',
            'phone'    => 'required',
        ], [
            'required'  => '必填写内容',
            'unique'    => '信息已经存在了',
            'confirmed' => '密码不同'
        ] );

        if ( !$v->fails() ) {
            $user           = new \App\Models\User;
            $user->username = $username;
            $user->password = \Hash::make( $password );
            $user->email    = $email;
            $user->nickname = $nickname;
            $user->phone    = $phone;

            if ( $user->save() ) {
                Auth( 'web' )->login( $user, true );

                return Response()->json( [
                    'code'    => 'success',
                    'message' => '注册成功!'
                ] );
            } else {
                return Response()->json( [
                    'code'    => 'error',
                    'message' => '注册失败!',
                ] );
            }
        } else {
            return Response()->json( [
                'code'    => 'error',
                'message' => '注册失败!',
            ] );
        }
    }

    protected function getLogout()
    {
        Auth()->logout();

        return Redirect()->to('/');
    }

    protected function getWelcome()
    {
        return compileBlade( template( '会员中心-首页' )->code, null );
    }

    public function getList()
    {
        $users = \App\Models\User::all();

        return \Plugins::view( class_basename( __CLASS__ ), $this->dataSourceView )->with( [
            'users' => $users
        ] );
    }

    public function getListJson()
    {
        $forms = \App\Models\Form::wherePlugin( lcfirst( class_basename( __CLASS__ ) ) )->get();

        return \Plugins::view( class_basename( __CLASS__ ), $this->dataSourceView )->with( [
            'forms' => $forms
        ] );
    }

}