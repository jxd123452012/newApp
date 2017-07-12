<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title></title>
		<style type="text/css">
			#btn{
				float: right;
				margin-right: 100px;
				margin-top: 10px;
			}
			table{
				text-align: center;
			}
		</style>
	</head>
	<body style="background-image: url(../../img/QQ图片20170606205835.png);">
		<table width="100%"  border="1px" cellpadding="1" cellspacing="0">
			
			<thead>
				<th colspan="4">会员卡管理</th>
				<tr>
					<td>会员卡号</td>
					<td>发卡时间</td>
					<td>会员名称</td>
					<td>类别</td>
				</tr>
			</thead>
			<tbody id="data"></tbody>
		</table>
		<div id="btn">
			<span>一共有&nbsp;<span id="zy"></span> &nbsp;页，</span>
			<button id="btn1">上一页</button>
			<button id="btn2">下一页</button>
		</div>
		<a href="../../houtaiguanli.php">返回</a>
	</body>
	<script src="../../js/jquery-1.7.1.js" type="text/javascript" charset="utf-8"></script>
	<script type="text/javascript">
		var dian=1;
		var zy;
		$(document).ready(function(){
			$.ajax({
				type:"get",
				url:"http://localhost/xiangmu/index.php?class=admin&action=allxinxi&yeshu="+dian+"",
				success:function(res){
					res=eval(res);
					zy=res.pop();
					$("#zy").append(zy);
					for(var i=0;i<10;i++){
						$("#data").append("<tr><td>"+res[i]["d_id"]+"</td><td>"+res[i]["time"]+"</td><td>"+res[i]["username"]+"</td><td>"+res[i]["dengji"]+"</td></tr>");
					}
					
				}
			});
		})
		
		
		$("#btn2").click(function(){
			dian++;
			if(dian>zy){
				alert("已经是最后一页了");
				dian=zy;
				return false;
			}
			$("#data").empty();
			$.ajax({
				type:"get",
				url:"http://localhost/xiangmu/index.php?class=admin&action=fenye&yeshu="+dian+"",
				success:function(res){
					res=eval(res);
					var yeshu=res[res.length-1];
					dian=yeshu[1];
					res.pop();
					console.log(res)
					for(var i=0;i<res.length;i++){
						$("#data").append("<tr><td>"+res[i]["d_id"]+"</td><td>"+res[i]["time"]+"</td><td>"+res[i]["username"]+"</td><td>"+res[i]["dengji"]+"</td></tr>");
					}
				}
			});
		})
		
		$("#btn1").click(function(){
			dian--;
			if(dian ==0){
				alert("已经是第一页")
				dian=1;
			}else{
				$("#data").empty();
				$.ajax({
					type:"get",
					url:"http://localhost/xiangmu/index.php?class=admin&action=fenye&yeshu="+dian+"",
					success:function(res){
						res=eval(res);
						var yeshu=res[res.length-1];
						res.pop();
						
						for(var i=0;i<res.length;i++){
							$("#data").append("<tr><td>"+res[i]["d_id"]+"</td><td>"+res[i]["time"]+"</td><td>"+res[i]["username"]+"</td><td>"+res[i]["dengji"]+"</td></tr>");
						}
					}
				});
			}
		})
		
	</script>
</html>
