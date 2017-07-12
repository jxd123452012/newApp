$.get("http://192.168.2.40/webWork/selData.php", function(res) {
	//	$(function() {
	var tab = "";
	var ftr = "<tr><td><input type='checkbox' value='i' class='quanxuan'>全选</td><td>ID</td><td>任务等级</td><td>任务名称</td><td>时间</td><td>负责人</td><td style='width:200px'>操作</td></tr>";
	$("table").append(ftr);
	for(var i = 0; i < res.length; i++) {
		tab += "<td><input type='checkbox' class='che' name='xuan' value="+i+"></td>";
		for(var j in res[i]) {
			if(res[i][j] == '紧急') {
				tab += "<td style='color:red;'>" + res[i][j] + "</td>";
			} else {
				tab += "<td>" + res[i][j] + "</td>";
			}
		}
		tab += "<td><button class='bianji'>编辑</button> <button class='shanchu'>删除</button> <button class='fuzhi'>复制</button></td>"
		$("table").append("<tr>" + tab + "</tr>");
		tab = "";
	}
	var qx=true;
	$(".quanxuan").click(function(){
		if(qx){
			for(var i=0;i<$(".che").length;i++){
				$(".che").get(i).checked=true;
			}
		}else{
			for(var i=0;i<$(".che").length;i++){
				$(".che").get(i).checked=false;
			}
		}
		qx=!qx;
	})
	//	})
}, "json");

function tianjia() {
	window.location.href = "tianjia.html";
}

function tbbanma() {
	$("tr:first").css("background-color", "grey");
	$("tr:nth-child(odd)").css("background-color", "lightgoldenrodyellow")
}

    