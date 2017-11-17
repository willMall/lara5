<!DOCTYPE html>
<html lang="zh-CN">
    <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title>修改密码</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="/css/admin.css">
    <script src="https://cdn.bootcss.com/jquery/1.11.2/jquery.min.js"></script>
    <script src="https://cdn.bootcss.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <style>
        .form-control,.control-label {margin-bottom: 15px;}
    </style>
    </head>
    <body>
@include('dashboard.top')
        <div class="container">
            <div class="row">
                <div class="col-md-12">
@if (session('msg'))
    <div class="alert alert-success alert-dismissible fade in" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        {{ session('msg') }}
    </div>
@endif
@if (count($errors) > 0)
                    <div class="alert alert-danger alert-dismissible fade in" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="关闭"><span aria-hidden="true">&times;</span></button>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
@endif
                    <form class="form-horizontal" method="post" action="/dashboard/password">
                        <input type="hidden" name="_token" value="{{csrf_token()}}">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title"><span class="glyphicon glyphicon-user" aria-hidden="true"></span> 修改密码</h3>
                            </div>
                            <div class="panel-body">
                                <div class="form-group">
                                    <label for="oldpassword" class="col-sm-2 control-label">原密码</label>
                                    <div class="col-sm-10">
                                        <input type="password" name="oldpassword" class="form-control" id="oldpassword" placeholder="原始密码">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="password" class="col-sm-2 control-label">新密码</label>
                                    <div class="col-sm-10">
                                        <input type="password" name="password" class="form-control" id="password" placeholder="新密码">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="password_confirmation" class="col-sm-2 control-label">再次输入</label>
                                    <div class="col-sm-10">
                                        <input type="password" name="password_confirmation" class="form-control"  style="margin-bottom: 0;" id="password_confirmation" placeholder="再次输入新密码">
                                    </div>
                                </div>
                            </div>
                            <div class="panel-footer">
                                <button type="submit" class="btn btn-primary">保存</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <script src="/static/js/jquery-1.11.2.min.js"></script>
        <script src="/static/js/bootstrap.min.js"></script>
    </body>
</html>
