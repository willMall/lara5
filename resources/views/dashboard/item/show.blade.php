<!DOCTYPE html>
<html lang="zh-CN">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>商品详情</title>
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
                <form class="form-horizontal">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title">商品详情</h3>
                            </div>
                            <div class="panel-body">
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">商品名称</label>
                                     <div class="col-sm-10">
                                     <p class="form-control-static">{{$data->name}}</p>
                                   </div>
                                </div>
                                 <div class="form-group">
                                    <label class="col-sm-2 control-label">所属分类</label>
                                     <div class="col-sm-10">
                                     <p class="form-control-static">
                                     <?php $depth=count($nodes)-1;
                                        if($depth==1) $name=$nodes[1]->name;
                                        else if($depth==2) $name=$nodes[1]->name.'->'.$nodes[2]->name;
                                        else if($depth==3) $name=$nodes[1]->name.'->'.$nodes[2]->name.'->'.$nodes[3]->name;
                                        else $name=="";
                                        echo $name;
                                        ?></p>
                                   </div>
                                </div>
                                 <div class="form-group">
                                    <label class="col-sm-2 control-label">商品价格(元)</label>
                                     <div class="col-sm-10">
                                     <p class="form-control-static">{{$data->price/100}}</p>
                                   </div>
                                </div>
                                 <div class="form-group">
                                    <label class="col-sm-2 control-label">商品库存</label>
                                     <div class="col-sm-10">
                                     <p class="form-control-static">{{$data->stock}}</p>
                                   </div>
                                </div>
                                 <div class="form-group">
                                    <label class="col-sm-2 control-label">商品详情</label>
                                     <div class="col-sm-10" style="overflow:auto;">
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
                 </form>
            </div>
        </div>
    </div>
</body>
</html>