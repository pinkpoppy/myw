$(document).ready(function() {
	$('#add_offline').click(function(event) {
		var current_time = getCurrentTime();
		var tr = $("<tr data-id=''></tr>");
		var checkbox = $("<td class='checkbox_td'><input type='checkbox'></td>");
		var shop = $("<td class='shop_td'><input type='text'></td>");
		var city = $("<td class='city_td'><input type='text'></td>");
		var address = $("<td class='address_td'><input type='text'></td>");
		var phone = $("<td class='phone_td'><input type='text'></td>");
		var wine_num = $("<td class='wine_num_td'>0</td>");
		var create_time = $("<td class='time_td'>"+current_time+"</td>");
		var operate = $("<td class='operate_td'><input type='button' value='添加' class='offline_edit'></td>");
		var state = $("<td class='state_td'>审核中</td>");

		$(tr).append(checkbox);
		$(tr).append(shop);
		$(tr).append(city);
		$(tr).append(address);
		$(tr).append(phone);
		$(tr).append(wine_num);
		$(tr).append(create_time);
		$(tr).append(operate);
		$(tr).append(state);

		$('#offline_infos_body').prepend(tr);

		$('.offline_edit').click(function(event) {
			update_offline($(this));
		});
	});
});


function update_offline(thisButton) {
	if (thisButton.val() == "编辑") {
		thisButton.val('确定');
		thisButton.parents("tr").find(":disabled").removeAttr('disabled');
	} else {
		var tr = thisButton.parents("tr");

		var shop = tr.find(".shop_td input").val();
		var city = tr.find(".city_td input").val();
		var address = tr.find(".address_td input").val();
		var phone = tr.find(".phone_td input").val();
		if (shop.length == 0 || city.length == 0 || address.length == 0 || phone.length == 0) {
			alert("信息不完整");
			return;
		}

		if (thisButton.val() == "添加") {
			var current_time = tr.find(".time_td").text();
			$.ajax({
				url: 'insert_offline.php',
				type: 'POST',
				dataType: 'json',
				timeout:20000,
				data: {
					shop: shop,
					city: city,
					address: address,
					phone: phone,
					create_time: current_time
				},
				success:function(id) {
					tr.attr("data-id", id);
				}
			})
			.done(function() {
			})
			.fail(function() {
			})
			.always(function() {
			});
		} else {
			var current_time = getCurrentTime();
			tr.find(".time_td").text(current_time);
			var id = tr.data("id");
			$.ajax({
				url: 'update_offline.php',
				type: 'POST',
				dataType: 'json',
				timeout:20000,
				data: {
					id: id,
					shop: shop,
					city: city,
					address: address,
					phone: phone,
					create_time: current_time
				},
				success:function(response) {
				}
			})
			.done(function() {
			})
			.fail(function() {
			})
			.always(function() {
			});
		}


		thisButton.val("编辑");
		tr.find(".shop_td input, .city_td input, .address_td input, .phone_td input").attr('disabled','disabled');
	}
}
