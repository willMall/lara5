<!DOCTYPE html>
<html lang="zh-CN">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>查看公告</title>
    <link href="https://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="/css/admin.css">
    <script src="https://cdn.bootcss.com/jquery/1.11.2/jquery.min.js"></script>
    <script src="https://cdn.bootcss.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>
@include('dashboard.top')
    <div class="container">
        <div class="row">
            <div class="col-md-2">
              @include('dashboard.sidebar')
            </div>
            <div class="col-md-10">
             <div class="form-horizontal">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">查看公告</h3>
                    </div>
                    <div class="panel-body">
                       <div class="form-group">
                            <label class="col-sm-2 control-label">发布者</label>
                             <div class="col-sm-10">
                             <p class="form-control-static">{{$data->user->name}}</p>
                           </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">标题</label>
                             <div class="col-sm-10">
                             <p class="form-control-static">{{$data->title}}</p>
                           </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">详情</label>
                             <div class="col-sm-10"  style="overflow:auto;">
                                <div class="form-control-static">
                                    {!!$data->details!!}
                                </div>
                           </div>
                        </div>
                            <div class="col-md-12">
                                 <div class="form-group" style="text-align: center;">
                 <a href="javascript:history.back();" class="btn btn-default">返回</a>
								</div>
							</div>
                        </div>
                </div>
            </div>
            </div>
        </div>
    </div>
</body>
</html>