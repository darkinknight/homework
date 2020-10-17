<?php
include('db.php');
$dsn = 'mysql:dbname=funny;host=127.0.0.1';
$pdo = new PDO($dsn,'fun', '321456');
$sql = "SELECT * FROM `pig` ORDER BY id DESC";
$rows = read($pdo, $sql);
?>
<!doctype html>
<html lang="en">

<head lang="zh-cn">
    <!-- Required meta tags -->
    <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Myder留言板</title>
    <style type="text/css">
        *{ padding:0; margin:0; list-style:none; border:0;}
        .all{
            width:1000px;
            height:400px;
            padding:7px;
            border:1px solid #ccc;
            margin:100px auto;
            position:relative;
        }
        .screen{
            width:1000px;
            height:400px;
            overflow:hidden;
            position:relative;
        }
        .screen li{ width:1000px; height:400px; overflow:hidden; float:left;}
        .screen ul{ position:absolute; left:0; top:0px; width:3000px;}
        .all ol{ position:absolute; right:10px; bottom:10px; line-height:20px; text-align:center;}
        .all ol li{ float:left; width:20px; height:20px; background:#fff; border:1px solid #ccc; margin-left:10px; cursor:pointer;}
        .all ol li.current{ background:yellow;}
 
        #arr {display: none;}
        #arr span{ width:40px; height:40px; position:absolute; left:5px; top:50%; margin-top:-20px; background:#000; cursor:pointer; line-height:40px; text-align:center; font-weight:bold; font-family:'黑体'; font-size:30px; color:#fff; opacity:0.3; border:1px solid #fff;}
        #arr #right{right:5px; left:auto;}

    </style>
 
    <script>
        window.onload = function () {
            //需求：无缝滚动。
            //思路：赋值第一张图片放到ul的最后，然后当图片切换到第五张的时候
            //     直接切换第六章，再次从第一张切换到第二张的时候先瞬间切换到
            //     第一张图片，然后滑动到第二张
            //步骤：
            //1.获取事件源及相关元素。（老三步）
            //2.复制第一张图片所在的li,添加到ul的最后面。
            //3.给ol中添加li，ul中的个数-1个，并点亮第一个按钮。
            //4.鼠标放到ol的li上切换图片
            //5.添加定时器
            //6.左右切换图片（鼠标放上去隐藏，移开显示）
            var screen = document.getElementById("screen");
            var ul = screen.children[0];
            var ol = screen.children[1];
            var div = screen.children[2];
            var imgWidth = screen.offsetWidth;
 
            //2
            var tempLi = ul.children[0].cloneNode(true);
            ul.appendChild(tempLi);
            //3
            for(var i = 0; i < ul.children.length - 1; i++) {
                var newOlLi = document.createElement("li");
                newOlLi.innerHTML = i + 1;
                ol.appendChild(newOlLi);
            }
            var olLiArr = ol.children;
            olLiArr[0].className = "current";
            //4
            for(var i = 0, len = olLiArr.length; i < len; i++) {
                olLiArr[i].index = i;
                olLiArr[i].onmouseover = function (ev) {
                    for(var j = 0; j < len; j++) {
                        olLiArr[j].className = "";
                    }
                    this.className = "current";
                    key = square = this.index;
                    animate(ul, -this.index * imgWidth);
                }
            }
            //5
            var key = 0;
            var square = 0;
            var timer = setInterval(autoPlay, 1000);
            screen.onmouseover = function (ev) {
                clearInterval(timer);
                div.style.display = "block";
            }
            screen.onmouseout = function (ev) {
                timer = setInterval(autoPlay, 1000);
                div.style.display = "none";
            }
            //6
            var divArr = div.children;
            divArr[0].onclick = function (ev) {
                key--;
                if(key < 0) {
                    ul.style.left = -(ul.children.length-1) * imgWidth + "px";
                    key = 4;
                }
                animate(ul, -key * imgWidth);
                square--;
                if(square < 0) {
                    square = 4;
                }
                for(var k = 0; k < len; k++) {
                    olLiArr[k].className = "";
                }
                olLiArr[square].className = "current";
            }
            divArr[1].onclick = autoPlay;
            function autoPlay() {
                key++;
                //当不满足下面的条件是时候，轮播图到了最后一个孩子，进入条件中后，瞬移到
                //第一张，继续滚动。
                if(key > ul.children.length - 1) {
                    ul.style.left = 0;
                    key = 1;
                }
                animate(ul, -key * imgWidth);
                square++;
                if(square > 4) {
                    square = 0;
                }
                for(var k = 0; k < len; k++) {
                    olLiArr[k].className = "";
                }
                olLiArr[square].className = "current";
            }
            function animate(ele,target){
                    clearInterval(ele.timer);
                    var speed = target>ele.offsetLeft?10:-10;
                    ele.timer = setInterval(function () {
                        var val = target - ele.offsetLeft;
                        ele.style.left = ele.offsetLeft + speed + "px";
                        if(Math.abs(val)<Math.abs(speed)){
                            ele.style.left = target + "px";
                            clearInterval(ele.timer);
                        }
                    },10)  
            }
 
        }
    </script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
     
</head>
    
<body background="https://pic.52112.com/180531/JPG-180531_342/pZ2BJIfNTD_small.jpg">
<div class="all" id='all'>
    <div class="screen" id="screen">
        <ul id="ul">
            <li><img src="http://www.shufe.edu.cn/_upload/article/images/25/0d/a42c05f1403fa14340d3500042fc/8e696383-b0be-4cb5-ae30-37f8ebba4146.jpg" width="1000" height="400" /></li>
            <li><img src="http://www.shufe.edu.cn/_upload/article/images/fe/be/017824b64da1a9d0cbf770adb2c8/fb5caca1-88ad-45b2-8b43-9ad9d3132b77.jpg" width="1000" height="400" /></li>
            <li><img src="http://www.shufe.edu.cn/_upload/article/images/fc/b3/178968884940aa43ef167f05fd80/e6c5337f-fc42-4a54-b8cd-b1b8da78dec6.jpg" width="1000" height="400" /></li>
            <li><img src="http://www.shufe.edu.cn/_upload/article/images/0e/5e/f9714a3d48a093e710dc6608f05a/b03bbb79-17b6-4f68-8954-7b324b1a7795.jpg" width="1000" height="400" /></li>
            <li><img src="http://www.shufe.edu.cn/_upload/article/images/ae/d5/8e8b7f4e426c88bfdbea347f6cd9/826034b2-eff7-44da-a128-94167d7c6ef1.jpg" width="1000" height="400" /></li>
        </ul>
        <ol>
 
        </ol>
        <div id="arr">
            <span id="left"><</span>
            <span id="right">></span>
        </div>
    </div>
</div>
    <div class="container">
        <div class="jumbotron">
            <h1 class="display-4">Myder留言板</h1>
            <p class="lead">欢迎大家留言，随便啥都行</p>
        </div>
        <form action="save.php" method='POST'>
        <div class='row'>


            <div class='col-12'>
                <div class="form-group">
                    <textarea name='content' class="form-control" rows='4'>留下你想说的话吧，嘟嘟噜~~~</textarea>
                </div>
            </div>
            <div class='col-3'>
                <div class="form-group">
                    <input name='username' class='form-control' type='text'/>
                </div>
            </div>
            <div class='col-9 d-flex'>
                <div class="form-group ml-auto">
                    <input class='btn btn-primary' type='submit' value='提交' />
                </div>
            </div>

        </div>
        </form>

        <div class='row'>
            <div class='col-12'>
            <?php
            foreach($rows as $key=>$pig){ 
            ?>
            <div class="accordion" id="accordionExample">
  <div class="card">
    <div class="card-header" id="headingOne">
      <h2 class="mb-0">
        <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
          我的留言
        </button>
      </h2>
    </div>

    <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
      <div class="card-body">
      <div class='text-primary'>用户:<?php echo $pig['username'];?></div>
                    <div>内容:<?php echo $pig['content'];?></div>
      </div>
    </div>
  </div>
  </div>
            <?php
            }
            ?>
            </div>
        </div>
    </div>
    <a href="#" class="btn btn-primary">Go back</a>
</html> 