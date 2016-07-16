<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>充值订单 - {{ $config['web_name'] }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0"/>
    <link rel="icon" href="/assets/images/favicon.ico" type="image/x-icon">

    <script src="{{ asset('statics/js/app.base.js') }}" type="text/javascript"></script>
    <link href="{{ asset('statics/css/app.base.css') }}" type="text/css" rel="stylesheet"/>

    <script src="//cdn.bootcss.com/vue/1.0.24/vue.js"></script>
    <script src="//cdn.bootcss.com/vue-resource/0.7.2/vue-resource.min.js"></script>
</head>
<body>

@include('Backend.Common.Nav')

<div class="app-main">
    <div class="app-wrapper">

        <div>
            <nav class="uk-navbar uk-margin-large-bottom">
                <span class="uk-hidden-small uk-navbar-brand">表单组件</span>

                <div class="uk-hidden-small uk-navbar-content">
                    <form class="uk-form uk-margin-remove uk-display-inline-block">
                        <div class="uk-form-icon">
                            <i class="uk-icon-filter"></i>
                            <input type="text" placeholder="搜索表单名字">
                        </div>
                    </form>
                </div>
                <ul class="uk-navbar-nav">
                    <li><a href="{{ Action('Backend\FormController@getCreate') }}" title="添加表单"
                           data-uk-tooltip="{pos:'right'}"><i class="uk-icon-plus-circle"></i></a></li>
                </ul>
            </nav>

            <div class="app-panel">
                <table class="uk-table uk-table-striped" multiple-select="{model:forms}">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>会员</th>
                        <th>订单号</th>
                        <th>商品</th>
                        <th>属性</th>
                        <th>创建时间</th>
                        <th>支付状态</th>
                        <th>处理状态</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach( $forms as $form )
                        <tr class="js-multiple-select">
                            <td>
                                {{ $form->id }}
                            </td>
                            <td></td>
                            <td>{{ $form->token }}</td>
                            <td>{{ \App\Models\Archive::find( $form->getField()->archive_id )->title }}</td>
                            <td>
                                @foreach( $carts = json_decode($form->getField()->carts) as $index => $cart )
                                    <span class="uk-badge">{{ $cart->name . ' * ' . $cart->count }}</span>
                                @endforeach
                            </td>
                            <td>{{ $form->created_at }}</td>
                            <td>
                                @if ( $form->getField()->payStatus == 'pay_wait' )
                                    <div class="uk-badge uk-badge-warning">等待支付</div>
                                @elseif ( $form->getField()->payStatus == 'pay_success' )
                                    <div class="uk-badge uk-badge-success">支付成功</div>
                                @elseif ( $form->getField()->payStatus == 'pay_error' )
                                    <div class="uk-badge uk-badge-danger">支付出错</div>
                                @endif
                            </td>
                            <td>
                                @if ( $form->getField()->disposeStatus == 'dispose_wait' )
                                    <div class="uk-badge uk-badge-warning">未处理</div>
                                @elseif ( $form->getField()->disposeStatus == 'dispose_success' )
                                    <div class="uk-badge uk-badge-success">已处理</div>
                                @endif
                            </td>
                            <td>
                                <div class="uk-link uk-float-right" data-uk-dropdown>
                                    <i class="uk-icon-bars"></i>
                                    <div class="uk-dropdown">
                                        <ul class="uk-nav uk-nav-dropdown uk-nav-parent-icon">
                                            <li class="uk-danger"><a href="#" @click="delete({{ $form->id }},$event)"><i class="uk-icon-minus-circle"></i> 删除数据</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>

</body>
</html>
