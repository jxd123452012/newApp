<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title></title>
		<style type="text/css">
			#xinxi{
				width: 500px;
				height: 500px;
				float: right;
				margin-right: 400px;
				margin-top:50px
			}
			label{
				margin-left: 10px;
				
			}
			#user,#cz{
				margin-top:50px;
			}
			h3{
				text-align:center;
			}
		</style>
	</head>
	<body style="background-image: url(../../img/QQ图片20170606205835.png);">
				<a href="../../houtaiguanli.php">返回</a>	
		<div style="width:1024px;height:700px;border:1px solid #cccccc; margin: auto;">
		<form action="http://localhost/xiangmu/index.php" method="get">
			<h3>查找会员</h3>
			<div style="margin: auto; width: 300px;">
			<label style="margin-left: 40px;">
				<input type="text" name="username" id="user" placeholder="请输入用户名">
			</label>
			<input type="button" value="查找" id="cz"/>
			</div>
			<div id="xinxi" style="margin-left: 100px;width: 300px;">
				<label>
					序号：<span></span>
				</label>
				<br>
				<label>
					用户名：<span></span>
				</label>
				<br>
				<label>
					密码：<span></span>
				</label>				
				<br>
				<label>
					真实姓名：<span></span>
				</label>
				<br>
				<label>
					住址：<span></span>
				</label>
				<br>
				<label>
					电话：<span></span>
				</label>
				<br>
				<label>
					email：<span></span>
				</label>
				<br>
				<label>
					信用卡号：<span></span>
				</label>
				<br>
				<label>
					注册时间：<span></span>
				</label>
				<br>
				<label>
					会员卡序号：<span></span>
				</label>
				<br>
				<label>
					积分：<span></span>
				</label>
				<br>
				<label>
					账户余额：<span></span>
				</label>
				<br>
				<label>
					会员积分：<span></span>
				</label>
				<br>
				<label>
					等级序号：<span></span>
				</label>
				<br>
				<label>
					用户号：<span></span>
				</label>
				<br>
				<label>
					会员等级：<span></span>
				</label>
			</div>
		</form>
		</div>
	</body>
	<script src="../../js/jquery-1.7.1.js"  type="text/javascript"  charset="utf-8"></script>
	<script type="text/javascript">
		$("#cz").click(function(){
			var aa=$("#user").val();
			$.ajax({
				type:"get",
				url:"http://localhost/xiangmu/index.php?class=admin&action=chazhao&username="+aa+"",
				success:function(res){
					res=eval(res);
					for(var i=0;i>=0;i++){
						if(res[0][i]===undefined){
							break;
						}
						$("span").eq(i).append(res[0][i]);
						
					}

				}
			});
		})
	</script>

<html>
