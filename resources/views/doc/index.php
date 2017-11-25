<?php
/**
 * Created by PhpStorm.
 * User: lingjianhua
 * Date: 2017/4/1
 * Time: 上午10:56
 */
?>
<?php
/**
 * Created by PhpStorm.
 * User: wang
 * Date: 14-10-15
 * Time: 下午2:05
 * bingofresh.com
 */
//读取数据
$data_txt = file_get_contents("doc.data");
$data = json_decode($data_txt, true);

$api_test_host="http://".$_SERVER["HTTP_HOST"].'/api/';

$api_test_create_host = "http://".$_SERVER["HTTP_HOST"]."/doc/create";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>API Documentation</title>
    <script src="../js/template.js"></script>
    <!-- Bootstrap core CSS -->
    <link href="../css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="../css/dashboard.css" rel="stylesheet">

    <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
    <!--[if lt IE 9]>
    <script src="../js/ie8-responsive-file-warning.js"></script><![endif]-->
    <script src="../js/ie-emulation-modes-warning.js"></script>

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <style>
        .panel-body h4 {
            color: #113b5c
        }

        .panel-body ul {
            list-style: none
        }
        .panel-group .panel {margin-bottom: 15px;}
        .returns {
            padding-left: 40px;
            padding-bottom: 10px;
        }

        .panel-body ul, .returns {
            color: #428bca
        }
        .highlight {
            border-bottom-right-radius: 4px;
            border-bottom-left-radius: 4px;
            margin: 0px -15px 0px;
            margin-bottom: -15px;
            padding: 9px 14px;
            background-color: #f7f7f9;
            border-top: 1px solid #e1e1e8;

        }
        .highlight pre {
            padding: 0;
            margin-top: 0;
            margin-bottom: 0;
            word-break: normal;
            white-space: nowrap;
            background-color: transparent;
            border: 0;
        }
        textarea.post_data{
            height: 150px;
        }
        #test_result{width: 100%;height:100%;min-height: 150px;border: none; }
        .param{color:#428bca;width: 150px }
        .param_no{width: 50px;}
        #test_text{display: none}
        #test_result th,td{font-size: 14px;}
        #main_description{color:#428bca;font-size:35px;margin-bottom: 12px;}
    </style>
</head>

<body>

<nav class="navbar navbar-inverse navbar-fixed-top blog-masthead" role="navigation">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar"
                    aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <div class="navbar-header" style="margin-top:5px;margin-right:15px;">
                <img alt="Brand" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACgAAAAoCAMAAAC7IEhfAAAA81BMVEX///9VPnxWPXxWPXxWPXxWPXxWPXxWPXz///9hSYT6+vuFc6BXPn37+vz8+/z9/f2LeqWMe6aOfqiTg6uXiK5bQ4BZQX9iS4VdRYFdRYJfSINuWI5vWY9xXJF0YJR3Y5Z4ZZd5ZZd6Z5h9apq0qcW1qsW1q8a6sMqpnLyrn76tocCvpMGwpMJoUoprVYxeRoJjS4abjLGilLemmbrDutDFvdLPx9nX0eDa1OLb1uPd1+Td2OXe2eXh3Ofj3+nk4Orl4evp5u7u7PLv7fPx7/T08vb08/f19Pf29Pj39vn6+fuEcZ9YP35aQn/8/P1ZQH5fR4PINAOdAAAAB3RSTlMAIWWOw/P002ipnAAAAPhJREFUeF6NldWOhEAUBRvtRsfdfd3d3e3/v2ZPmGSWZNPDqScqqaSBSy4CGJbtSi2ubRkiwXRkBo6ZdJIApeEwoWMIS1JYwuZCW7hc6ApJkgrr+T/eW1V9uKXS5I5GXAjW2VAV9KFfSfgJpk+w4yXhwoqwl5AIGwp4RPgdK3XNHD2ETYiwe6nUa18f5jYSxle4vulw7/EtoCdzvqkPv3bn7M0eYbc7xFPXzqCrRCgH0Hsm/IjgTSb04W0i7EGjz+xw+wR6oZ1MnJ9TWrtToEx+4QfcZJ5X6tnhw+nhvqebdVhZUJX/oFcKvaTotUcvUnY188ue/n38AunzPPE8yg7bAAAAAElFTkSuQmCC">
            </div>
            <a class="navbar-brand" href="#">API Documentation&nbsp;&nbsp;&nbsp;&nbsp;</a>
            <div style="float: left;margin-top: 8px;" class="btn btn btn-warning"  onclick="window.localStorage.clear();">清除全部缓存</div>

            <div style="float: left;margin-top: 8px;margin-left: 10px;" class="btn btn-danger dropdown-toggle"><a style="color:#fff;" href="<?php echo $api_test_create_host;?>" target="_blank">重新生成</a></div>
        </div>
        <div id="navbar" class="navbar-collapse">
            <form class="navbar-form navbar-right">
                <input type="text" class="form-control" placeholder="Search...">
            </form>
        </div>
    </div>
</nav>

<div class="container-fluid">
    <div class="row">
        <div class="col-sm-3 col-md-2 sidebar">
            <ul class="nav nav-sidebar">
                <li class="active" id="Overview"><a href="#">Overview</a></li>
                <?php
                foreach (array_keys($data["all_class_doc"]) as $key_class) {
                    ?>
                    <li id="<?php echo $key_class; ?>">
                        <a href="#"><?php echo $data["all_class_doc"][$key_class]["class"]["description"] . "(" . $key_class . ")"; ?></a>

                    </li>
                    <?php
                }
                ?>
            </ul>
            <ul class="nav nav-sidebar">
                <li><a href="../power" target="_blank">授权</a></li>
                <li><a href="#">Analytics</a></li>
                <li><a href="#">Export</a></li>
            </ul>
        </div>
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
            <div id="main_Overview">
                <h1 class="page-header">简介</h1>
                <div>
                    <p>API接口文档，内部使用，请勿外泄。</p>
<!--                    <h4 class="page-header">关于$bingo_appid</h4>-->
<!--                    <p>-->
<!--                        该参数表示请求来源，bingo_appid由缤果发放给开发者。<br/>-->
<!--                        固定bingo_appid:<br/>-->
<!--                        <code>-->
<!--                            WEB客户端:1<br/>-->
<!--                            IOS客户端:2<br/>-->
<!--                            ANDROID客户端:3<br/>-->
<!--                        </code>-->
<!--                    </p>-->
                    <h4 class="page-header">安全机制</h4>
                    <p>用户登录，服务器会先验证token是否正确
                        <br/>用户退出后token在服务器过期</p>
                    <h4 class="page-header">Api返回</h4>
                    <p>
                        所有接口将返回如下固定格式JSON格式字符串，<br/>
                        <code>
                            {
                            "status": 0,
                            "data": "缺少参数token"
                            }</code>
                        <br/>
                        其中status节点为本次请求状态，只有两个结果，200:成功 <=0:失败;
                        <br/>status为200时
                        data节点为服务器返回业务数据（有可能包含多级），status<=0时
                        data节点内容为错误提示(只有一级，单行字符串)
                    </p>
                    <br/><br/><br/>
                    <p>2016 api.com Dev</p>
                    <?php
                    //echo "<pre/>";
                    //print_r($data);
                    ?>
                </div>
            </div>
            <div id="main" style="display: none;">
                <h1 class="page-header" id="main_title"></h1>

                <div id="main_description"></div>
                <div id="main_content" class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">

                </div>
            </div>


        </div>
    </div>
</div>
<script id="functionTemplate" type="text/html">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4 class="panel-title">
                <a data-toggle="collapse" data-parent="#accordion" href="#collapseFunc{{index}}" aria-expanded="true"
                   aria-controls="collapseOne" class="list-group-item list-group-item-info">
                    #{{index}}{{description}}&nbsp;&nbsp;{{key}}
                </a>
            </h4>
        </div>
        <div id="collapseFunc{{index}}" class="panel-collapse collapse in" role="tabpanel">
            <div class="panel-body">
                <div>
                    <span class="badge">{{author}}</span>
                    <span class="badge">{{lastTime}}</span>
                </div>
                <h4>Parameters</h4>
                <table class="table table-bordered table-hover">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>参数名</th>
                        <th>类型</th>
                        <th>说明</th>
                    </tr>
                    </thead>
                    <tbody>
                    {{each parameters as p index}}
                    <tr><td class="param_no">{{index}}</td><td class="param">
                            {{p.param}}
                        </td><td class="param">{{p.type}}</td><td>{{p.info}}</td></tr>
                    {{/each}}
                    </tbody>

                </table>

                <h4>Return</h4>

                <div class="returns">
                    {{returns}}
                </div>
                {{if (url!=undefined && url!='')}}
                接口地址：<div class="returns">{{url}}</div>
                {{/if}}
                {{if (info!=undefined && info!='')}}
                说明：
                <div class="returns">
                    {{info}}
                </div>
                {{/if}}
                {{if test!='false'}}
                <div class="highlight">
                    <pre>
                        <code>接口地址：<span id="url_{{index}}"><?php echo $api_test_host;?>{{class_name}}/{{key}}</span></code><br/>
                            <div class="form-group">
                                <label for="post_data">测试数据(正常POST请求，数据结构如下)</label>
                                <textarea class="form-control post_data" id="post_data_{{index}}" name="post_data_{{index}}">{{post_data}}</textarea>
                            </div>
                            <button id="test_btn_{{index}}" type="button" onclick="do_test({{index}},'{{class_name}}_{{key}}')" class="btn btn-success dropdown-toggle">测试一下</button>
                            <span id="test_text">通讯中...</span>
                    </pre>
                </div>
                {{/if}}
            </div>
        </div>
    </div>



    <!-- Modal -->
    <div class="modal fade" id="testModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title" id="myModalLabel">API测试结果</h4>
                </div>
                <div class="modal-body" id="">

                    <div id="test_result" style="overflow: auto;height:200px;"></div>
                </div>
                <div class="modal-footer">
                    <a href="http://www.bejson.com" target="_blank">bejson工具</a>&nbsp;&nbsp;&nbsp;&nbsp;
                    <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal end -->
</script>

<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="../js/jquery-2.0.2.min.js"></script>
<script src="../js/bootstrap.min.js"></script>
<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
<script src="../js/ie10-viewport-bug-workaround.js"></script>
<script>
    if(!window.localStorage){
        alert('为了更好体验，请更换更高级浏览器查阅本API');
    }
//    var data = JSON.parse('<?php //echo '['.$data_txt.']';?>//');
    var data = <?php echo $data_txt;?>;
    console.log(data);
    $(function () {
        $("#re_write_doc").on('click',function(){
            var url = $(this).data("url")+"create_doc.php"
            url=url.replace('/Api', '');
            alert(url);
            $.post(url,'',function(ret){
                location.reload();
                alert("成功！");
            });
        });
        $(".nav-sidebar li").on('click', function () {
            var class_name = $(this).attr("id");
            $(".nav-sidebar li").removeClass("active");
            $(this).addClass("active");
            if (class_name == "Overview") {
                $("#main_Overview").show();
                $("#main").hide();
                return false;
            }
            $("#main_Overview").hide();
            $("#main").show();
            var title = data["all_class_doc"][class_name]["class"]["description"] + "(" + class_name + ")";
            var main_description = data["all_class_doc"][class_name]["class"]["long_description"];
            $("#main_title").html(title);
            $("#main_description").html(main_description);
            //生成function内容
            create_function_content(class_name);
        });
    });
    function create_function_content(class_name) {
        //遍历FUNCTION
        var functions = data["all_class_doc"][class_name]["function"];
        //console.log(functions);
        var html = "";
        var i = 1;
        var reg=/\$([\w]*)/;
        var reg2=/([\s\u4E00-\u9FA5]+)/;
        for (var key in functions) {
            var function_data = functions[key];

            //隐藏方法不显示
            if (function_data['hide'] == 'true') {
                continue;
            };

            function_data["class_name"]=class_name;
            function_data["key"]=key;
            function_data["index"] = i;
            //参数
            var param = function_data["param"];
            function_data["returns"] = (function_data["return"] != undefined) ? function_data["return"]["param"] : "";
            function_data["author"] = (function_data["author"] != undefined) ? function_data["author"] : "";
            function_data["lastTime"] = (function_data["lastTime"] != undefined) ? function_data["lastTime"] : "";
            function_data["parameters"] = "";
            function_data["post_data"] ="";

            var tmp_post_data=[];
            var tmp_c=" ";
            function_data["parameters"]=[];
            var tmp = "";
            //console.log(param);
            if (param !== undefined){
                for(var x=0;x<param.length;x++){
                    tmp_post_data.push(('"'+param[x]["param"]).replace(/\$/,"")+'":'+'"'+param[x]["info"]+'"\n');
                    function_data["parameters"].push({'param':param[x]["param"],'type':param[x]["type"],'info':param[x]["info"]});
                    //tmp+='<tr><td class="param_no">'+(x+1)+'</td><td class="param">'+param[x]["param"]+'</td><td class="param">'+param[x]["type"]+'</td><td>'+param[x]["info"]+'</td></tr>';
                }
            }
            //function_data["parameters"]=tmp;
            var post_data="";
            if (tmp_post_data.length>0){
                //tmp_post_data.push("\"token\":\" \"\n");
                post_data="{\n"+tmp_post_data.join(",")+"}";
            }
            function_data["post_data"]=my_storage(class_name+"_"+key,post_data);
            template('tpl/home/main', data)
            var s = template('functionTemplate', function_data);
            console.log(s);
            //$(functionTemplate).parseTemplate(function_data);
            html += s;
            i++;
        }
        //console.log(html);
        $("#main_content").html(html);
        $('.collapse').collapse();
    }
    //缓存
    function my_storage(key,or_data){

        var obj_old_str=window.localStorage.getItem(key);
        if (obj_old_str==undefined || obj_old_str==null){
            return or_data;
        }


        var obj_new=JSON.parse(or_data);
        var keys_new=[];
        for (var a in obj_new){
            keys_new.push(a);
        }
        var keys_old=[];
        var obj_old=JSON.parse(obj_old_str);
        for (var b in obj_old){
            keys_old.push(b);
        }
        if (keys_new.sort().toString()==keys_old.sort().toString()){
            return obj_old_str;
        }else{
            return or_data;
        }
    }


    //测试
    function do_test(id,key){
        $("#test_btn_"+id).hide();
        $("#test_text").show();
        var url=$("#url_"+id).text();
        var data_txt=$("#post_data_"+id).val();
        if (data_txt.length<=0){
            alert("请求数据不能为空");
            return false;
        }
        window.localStorage.setItem(key,data_txt);
        //console.log(key,window.localStorage.getItem(key));
        var data=JSON.parse(data_txt);
        //console.log(data);
        if (data==undefined || data==null){
            alert("请求数据格式错误");
            return false;
        }

        $.post(url,data,function(ret){
            $("#test_btn_"+id).show();
            $("#test_text").hide();
            $("#test_result").html('');
            //console.log(ret);
            $('#testModal').modal('toggle');

            var last_content = "";
            try {
                var data=JSON.parse(ret);
                last_content=JSON.stringify(data, null, '\t');
            } catch(err) {
                last_content=ret;
            } finally{
                $("#test_result").html(last_content);
            }
        });

    }


    function isArray(o) {
        return Object.prototype.toString.call(o) === '[object Array]';
    }
</script>
</body>
</html>
