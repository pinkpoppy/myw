
$(document).ready(function() {

	//酒款年份选择
	loadSelectYear($('#select-year'));

	$('#cancle_add').click(function(event) {
		location.href = 'manage_wine.php#';
	});

	// 添加线上渠道 开始
	$('#add_online_chanel').click(function(event) {
		var td_delete = $("<td class='online_data_td'><input class='online_checkbox' type='checkbox' ></td>");
		var td_name = $("<td class='ebusiness_name_td'><input class='ebusiness_name_input' type='text' name='online_channels[]' required></td>");
		var td_link = $("<td class='buy_link_td'><input class='buy_link_input' type='text' name='online_links[]' required></td>");
		var tr = $("<tr></tr>");
		$(tr).append(td_delete);
		$(tr).append(td_name);
		$(tr).append(td_link);
		$('#online').prepend(tr);
		$(window).resize(function(event) {
		});
	});
	// 添加线上渠道 结束

	// 删除线上渠道 开始
	$('#delete_online_chanel').click(function(event) {
		var checktr = $('.online_checkbox:checked').parents('tr');
		var hidden_wine_to_online_ids = checktr.find(".hidden_wine_to_online_ids");
		var wine_to_online_ids = [];
		for (var i = 0; i < hidden_wine_to_online_ids.length; ++i) {
			var hidden_wine_to_online_id = hidden_wine_to_online_ids[i].value;
			wine_to_online_ids.push(hidden_wine_to_online_id);
		}
		$.ajax({
			url: 'delete_wine_to_online.php',
			type: 'POST',
			dataType: 'json',
			timeout:20000,
			data: {
				wine_to_online_ids:wine_to_online_ids
			},
			success:function() {
			}
		})
		.done(function() {

		})
		.fail(function() {
		})
		.always(function() {
		});
		checktr.remove();
	});
	// 删除线上渠道 结束

	// 添加线下渠道 开始
	$('#add_offline_chanel').click(function(event) {
		var td_delete = $("<td class='offline_data_td delete'><input type='checkbox' class='offline_checkbox'></td>");
		var td_shop = $("<td class='shop'><input class='offline_shop_input' name='shops[]' type='text' required></td>");
		var td_city = $("<td class='city'><input class='offline_city_input' name='cities[]' type='text' required></td>");
		var td_phone = $("<td class='phone'><input class='offline_phone_input' name='phones[]' type='text' required></td>");
		var td_address = $("<td class='address'><input class='offline_address_input' name='addresses[]' type='text' required></td>");
		var td_offline_id = $("<input name='offline_ids[]' type='hidden' value='-1'>");

		var tr = $("<tr></tr>");
		$(tr).append(td_delete);
		$(tr).append(td_shop);
		$(tr).append(td_city);
		$(tr).append(td_phone);
		$(tr).append(td_address);
		$(tr).append(td_offline_id);
		$('#offline').prepend(tr);
	});
	// 添加线下渠道 结束

	//选择线下渠道 开始
	$('#get_offline_chanel').click(function(event) {
		$.ajax({
			url: '../offline/load_offline.php',
			type: 'POST',
			dataType: 'json',
			timeout:100000,
			data: {
			},
			success:function(receiveArr) {
				$('#choose_offline_address').empty();
				for(var i = 0; i < receiveArr.length;i++) {
					var tr = $("<tr data-id="  + receiveArr[i]['id'] +  "></tr>");
					$(tr).append("<td> <input type='checkbox' class='offline_choose_checkbox'></td>");
					$(tr).append("<td class='offline_choose_shop'>" + receiveArr[i]['shop'] + "</td>");
					$(tr).append("<td class='offline_choose_city'>" + receiveArr[i]['city'] + "</td>");
					$(tr).append("<td class='offline_choose_phone'>" + receiveArr[i]['phone'] + "</td>");
					$(tr).append("<td class='offline_choose_address'>" + receiveArr[i]['address'] + "</td>");
					//TODO: add offline id
					$('#choose_offline_address').append(tr);
				}
				$('.address_wrap').show();
				$('body').attr('opacity', '0.5');
			}
		})
		.done(function() {

		})
		.fail(function() {
		})
		.always(function() {
		});

	});
	//选择线下渠道 结束

	// 删除线下渠道 开始
	$('#delete_offline_chanel').click(function(event) {
		var checkedtr = $('.offline_checkbox:checked').parents('tr');
		var hidden_wine_to_offline_ids = checkedtr.find(".hidden_wine_to_offline_ids");
		var wine_to_offline_ids = [];
		for (var i = 0; i < hidden_wine_to_offline_ids.length; ++i) {
			var hidden_wine_to_offline_id = hidden_wine_to_offline_ids[i].value;
			wine_to_offline_ids.push(hidden_wine_to_offline_id);
		}
		$.ajax({
			url: 'delete_wine_to_offline.php',
			type: 'POST',
			dataType: 'json',
			timeout:20000,
			data: {
				wine_to_offline_ids:wine_to_offline_ids
			},
			success:function() {
			}
		})
		.done(function() {

		})
		.fail(function() {
		})
		.always(function() {
		});
		checkedtr.remove();
	});
	// 删除线下渠道 结束

	$('#choose_offline').click(function(event) {
		var choosen_offline = $('.offline_choose_checkbox:checked').parents('tr');
		for (var i = 0; i < choosen_offline.length; ++i) {
			var offline_id = choosen_offline[i].dataset["id"];
			if (isOfflineIdExist(offline_id)) {
				continue;
			}
			var shop = choosen_offline[i].childNodes[1].innerText;
			var city = choosen_offline[i].childNodes[2].innerText;
			var phone = choosen_offline[i].childNodes[3].innerText;
			var address = choosen_offline[i].childNodes[4].innerText;

			var td_delete = $("<td class='offline_data_td delete'><input type='checkbox' class='offline_checkbox'></td>");
			var td_shop = $("<td class='shopclick'><input class='offline_shop_input' type='text' value=\'" + shop + "\' disabled required></td>");
			var td_city = $("<td class='city'><input class='offline_city_input' type='text' value=\'" + city + "\' disabled required></td>");
			var td_phone = $("<td class='phone'><input class='offline_phone_input' type='text' value=\'" + phone + "\' disabled required></td>");
			var td_address = $("<td class='address'><input class='offline_address_input' type='text' value=\'" + address + "\' disabled required></td>");

			var hd_shop = $("<input name='shops[]' type='hidden' value='" + shop + "'>");
			var hd_city = $("<input name='cities[]' type='hidden' value='" + city + "'>");
			var hd_phone = $("<input name='phones[]' type='hidden' value='" + phone + "'>");
			var hd_address = $("<input name='addresses[]' type='hidden' value='" + address + "'>");
			var td_offline_id = $("<input name='offline_ids[]' type='hidden' value='" + offline_id + "'>");

			var tr = $("<tr data-id=" + offline_id + "></tr>");
			$(tr).append(td_delete);
			$(tr).append(td_shop);
			$(tr).append(td_city);
			$(tr).append(td_phone);
			$(tr).append(td_address);
			$(tr).append(hd_shop);
			$(tr).append(hd_city);
			$(tr).append(hd_phone);
			$(tr).append(hd_address);
			$(tr).append(td_offline_id);
			$('#offline').prepend(tr);
		}

		$('.address_wrap').hide();
	});

	$('#cancle_choose').click(function(event) {
		$('.address_wrap').hide();
	});

});


function isOfflineIdExist(offline_id) {
	var trs = $('.offline_checkbox').parents('tr');
	for (var i = 0; i < trs.length; ++i) {
		if (trs[i].dataset["id"] == offline_id) {
			return true;
		}
	}
	return false;
}

$("#submit_all_wines").click(function(event) {
	if (!invalidInput()) {
		$("#wine_info").submit();
	}
});


// check form 
function invalidInput() {
	if ($('#result')[0].innerText != "已选择") {
		alert("没有添加图片");
		return true;
	}
	if (invalidWineInfo()) {
		alert("酒款信息不完整");
		return true;
	}
	if (invalidOnlineInfo()) {
		alert("线上渠道信息不完整");
		return true;
	}
	if (invalidOfflineInfo()) {
		alert("线下渠道信息不完整");
		return true;
	}
	return false;
}

function invalidWineInfo() {
	if ($('#zh_wine_name').val() != 0 &&
		$('#zh_country_name').val() != 0 &&
		$('#zh_place_name').val() != 0 &&
		$('#en_place_name').val() != 0 &&
		$('#zh_chateau_name').val() != 0 &&
		$('#en_chateau_name').val() != 0 &&
		$('#zh_wine_type_name').val() != 0 &&
		$('#en_wine_type_name').val() != 0 &&
		$('#zh_grape_name').val() != 0 &&
		$('#en_grape_name').val() != 0 &&
		$('#wine_volume').val() != 0 &&
		$('#wine_year').val() != 0 &&
		$('#wine_price').val() != 0) {
		return false;
	}
	return true;
}

function invalidOnlineInfo() {
	var companies = $('.ebusiness_name_input');
	var links = $('.buy_link_input');
	for (var i = 0; i < companies.length; ++i) {
		if (companies[i].value == '') {
			return true;
		}
		if (links[i].value == '') {
			return true;
		}
	}
	return false;
}

function invalidOfflineInfo() {
	var shops = $('.offline_shop_input');
	var cities = $('.offline_city_input');
	var phones = $('.offline_phone_input');
	var addresses = $('.offline_address_input');
	for (var i = 0; i < shops.length; ++i) {
		if (shops[i].value == '') {
			return true;
		}
		if (cities[i].value == '') {
			return true;
		}
		if (phones[i].value == '') {
			return true;
		}
		if (addresses[i].value == '') {
			return true;
		}
	}
	return false;
}

function loadSelectYear(parent) {
	var thisYear = new Date().getFullYear();
	var select = $("<select id='select' name='wine_year'></select>");
	$('<option>',{value:'N.V.',text:'N.V.'}).appendTo(select);
	$('<option>',{value:'no year',text:'no year'}).appendTo(select);
	for (var i=0; i <= 100; i++) {
		var year = thisYear - i;
		$('<option>',{value:year,text:year}).appendTo(select);
	}
	if (wineYear != 0) {
		select.val(wineYear);
	}
	select.appendTo(parent);
	
}
