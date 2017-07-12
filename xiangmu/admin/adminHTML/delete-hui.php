<!DOCTYPE html>
<html>

	<head>
		<meta charset="utf-8" />
		<title></title>
		<style type="text/css">
			#btn{
				float: right;
				margin-right: 100px;
				margin-top: 10px;
			}
		</style>
	</head>

	<body style="background-image: url(../../img/QQ图片20170606205835.png);">
		<table width="100%"  border="1px"cellpadding="1"cellspacing="0">
			<thead>
				<tr>
					<td>编号</td>
					<td>姓名</td>
					<td>真实姓名</td>
					<td>地址</td>
					<td>电话号码</td>
					<td>邮箱</td>
					<td>信用卡号</td>
					<td>注册时间</td>
					<td>积分</td>
					<td>账户余额</td>
					<td>会员等级</td>
					<td>操作</td>
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
					for(i=0;i<10;i++){
						if(res[0]["d_id"]==undefined){
								break;
						}
						var id=res[0]["d_id"];
						var btn="<button class='shan' for='"+id+"'>删除</button>";
						$("#data").append("<tr id='bb"+id+"'><td>"+res[i]["d_id"]+"</td><td>"+res[i]["username"]+"</td><td>"+res[i]["name"]+"</td><td>"+res[i]["dizhi"]+"</td><td>"+res[i]["phone"]+"</td><td>"+res[i]["email"]+"</td><td>"+res[i]["kahao"]+"</td><td>"+res[i]["time"]+"</td><td>"+res[i]["jifen"]+"</td><td>"+res[i]["money"]+"</td><td>"+res[i]["dengji"]+"</td><td>"+btn+"</td></tr>");
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
					for(var i=0;i<res.length;i++){
						var id=res[i]["id"];
						var btn="<button class='shan' for='"+id+"'>删除</button>";
						$("#data").append("<tr id='bb"+id+"'><td>"+res[i]["id"]+"</td><td>"+res[i]["username"]+"</td><td>"+res[i]["name"]+"</td><td>"+res[i]["dizhi"]+"</td><td>"+res[i]["phone"]+"</td><td>"
						+res[i]["email"]+"</td><td>"+res[i]["kahao"]+"</td><td>"+res[i]["time"]+"</td><td>"+res[i]["jifen"]+"</td><td>"+res[i]["money"]+"</td><td>"+res[i]["dengji"]+"</td><td>"+btn+"</td></tr>");
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
						res.pop();
						
						var btn="<button class='shan' for='"+id+"'>删除</button>";
						for(var i=0;i<res.length;i++){
							var id=res[i]["id"];
							var btn="<button class='shan' for='"+id+"'>删除</button>";
							$("#data").append("<tr id='bb"+id+"'><td>"+res[i]["id"]+"</td><td>"+res[i]["username"]+"</td><td>"+res[i]["name"]+"</td><td>"+res[i]["dizhi"]+"</td><td>"+res[i]["phone"]+"</td><td>"
							+res[i]["email"]+"</td><td>"+res[i]["kahao"]+"</td><td>"+res[i]["time"]+"</td><td>"+res[i]["jifen"]+"</td><td>"+res[i]["money"]+"</td><td>"+res[i]["dengji"]+"</td><td>"+btn+"</td></tr>");
						}
					}
				});
			}
		})
		
			$(".shan").live("click",function(){
				var id=$(this).attr("for");
				
				$.ajax({
					type:"get",
					data:{"id":id},
					url:"http://localhost/xiangmu/index.php?class=admin&action=shan",
					success:function(res){
						if(res){
							alert("删除成功");
							$("#bb"+id+"").remove();
						}else{
							alert("删除失败");
						}
						
					}
				})
			})
	</script>

</html>