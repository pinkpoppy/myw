var kInProcess = 1;
var kAll = -1;
var kPassed = 0;
var kFailed = 2;
var currentPage;
var seller;
var state;
var pageNumber;

$(document).ready(function() {
	state = $( "#state_select option:selected" ).data("id");
	currentPage = 0;
	fetchWineInfo(seller_id, state, currentPage);


	$('#state_select').change(function() {
		state = $( "#state_select option:selected" ).data("id");
		currentPage = 0;
		fetchWineInfo(seller_id, state, currentPage);
	});
});


function fetchWineInfo(seller_id, state, currentPage) {
	$.ajax({
		url: 'load_wine_infos.php',
		type: 'POST',
		dataType: 'json',
		timeout:20000,
		data: {
			seller_id:seller_id,
			state:state,
			currentPage:currentPage
		},
		success:function(response) {
			pageNumber = response['pageNumber'];
			$("#page_num").text(pageNumber);
			$("#current_page").val(currentPage + 1);
			var wineInfos = response['wineInfos'];
			$("#wine_infos_body").empty();

			for (var i = 0; i < wineInfos.length; i++) {
				
				var tr = $("<tr data-id="+wineInfos[i]['id']+"></tr>");
				//checkbox
				$(tr).append("<td class='wine_delete'> <input type='checkbox' class='wine_checkbox'></td>");

				//酒单号
				$(tr).append("<td class='wine_num'>" + wineInfos[i]['id'] + "</td>");

				//酒款中文名
				$(tr).append("<td class='zh_name'>" + wineInfos[i]['zh_wine_name'] + "</td>");

				//酒款英文名
				$(tr).append("<td class='en_name'>" + wineInfos[i]['en_wine_name'] + "</td>");

				//年份
				$(tr).append("<td class='year'>" + wineInfos[i]['year'] + "</td>");

				//参考价
				$(tr).append("<td class='price'>" + wineInfos[i]['price'] + "</td>");
				
				//操作
				$(tr).append("<td class='edit'> <input value='编辑' class='update_wine_button' type='button'> </td>");

				//状态 TODO change state to chinese
				$(tr).append("<td class='state'>" + wineInfos[i]['state'] + "</td>");

				//更新时间
				$(tr).append("<td class='update_time'>" + getShortTime(wineInfos[i]['create_time']) + "</td>");
				
				
				$("#wine_infos_body").append(tr);
			}

			$(".update_wine_button").click(function(event){
				var wine_id = $(this).parents("tr")[0].dataset["id"];

				post('wine_info.php', {'wine_id': wine_id}, 'get');
			});
		}
	})
	.done(function() {
	})
	.fail(function() {
	})
	.always(function() {
	});
}

$("#delete_wine_infos").click(function(event) {
	var selected_wine_infos = $(".wine_checkbox:checked").parents("tr");
	var ids = [];
	for (var i = 0; i < selected_wine_infos.length; ++i) {
		ids.push(selected_wine_infos[i].dataset["id"]);
	}
	$.ajax({
		url: 'delete_wine_infos.php',
		type: 'POST',
		dataType: 'json',
		timeout:20000,
		data: {
			ids: ids
		},
		success:function(response) {
		}
	})
	.done(function() {
	})
	.fail(function() {
	})
	.always(function() {
		currentPage = 0;
		fetchWineInfo(seller_id, state, currentPage);
	});
});

$("#next_page").click(function(event) {
	if (currentPage + 1 < pageNumber) {
		currentPage ++;
		fetchWineInfo(seller_id, state, currentPage);
	}
});

$("#prev_page").click(function(event) {
	if (currentPage >= 1) {
		currentPage --;
		fetchWineInfo(seller_id, state, currentPage);
	}
});

$("#goto_page").click(function(event) {
	var gotoPage = $("#current_page").val();
	if (gotoPage >= 1 && gotoPage <= pageNumber) {
		currentPage = gotoPage - 1;
		fetchWineInfo(seller_id, state, currentPage);
	}
});