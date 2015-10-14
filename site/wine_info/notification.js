var kInProcess = 1;
var kAll = -1;
var kPassed = 0;
var kFailed = 2;
var currentPage;

var pageNumber;
$(document).ready(function() {
	currentPage = 0;
	hideNotify();
	fetchNotifications(currentPage);
});

function hideNotify() {
	var parentWindow = window.parent;
	var parentDocument = parentWindow.document;
	var notify = parentDocument.getElementById('notify');
	notify.style.display = 'none';
}
function fetchNotifications(currentPage) {
	$.ajax({
		url: 'load_notifications.php',
		type: 'POST',
		dataType: 'json',
		timeout:20000,
		data: {
			currentPage:currentPage
		},
		success:function(response) {
			pageNumber = response['pageNumber'];
			var notificationsArr = response['notificationsArr'];

			$("#page_num").text(pageNumber);
			$("#current_page").val(currentPage + 1);
			$("#notifications_tbody").empty();

			for (var i = 0; i < notificationsArr.length; i++) {
				var spanWrap = $("<div class='span_wrap_div'></div>");
				var contentTd = $("<td class='content_td'></td>");

				if (notificationsArr[i]['is_read']==1) {
					var tr = $("<tr class='not_read' data-id="+notificationsArr[i]['id']+"></tr>");
					var img = $("<img class='margin_right' src='../icon/notification/not_read.png'>");
				} else {
					var img = $("<img class='margin_right' src='../icon/notification/had_read.png'>");
					var tr = $("<tr class='had_read' data-id="+notificationsArr[i]['id']+"></tr>");
				}
				var titleSpan = $("<span class='light_span line_height'>编号为</span>");
				
				var idSpan = $("<span class='id_span line_height'>"+notificationsArr[i]['content_id']+"</span>");
				
				if (notificationsArr[i]['content_type']==1) {
					var typeSpan = $("<span class='type_span line_height'>的线下地址</span>");
				} else {
					var typeSpan = $("<span class='type_span line_height'>的酒款</span>");
				}

				var timeSpan = $("<span class='notify_time'>"+getShortTime(notificationsArr[i]['create_time'])+"</span>");

				var timeTd = $("<td class='time_td'></td>")

				if (notificationsArr[i]['pass_flag']==1) {
					var resultSpan = $("<span class='line_height'>审核失败</span>");
					var detailButton = $("<span class='detail_button failed_button line_height'>失败原因</span>");
				} else {
					var resultSpan = $("<span class='line_height'>审核通过</span>");
					var detailButton = $("<span class='detail_button successed_button line_height'>查看详情</span>");
				}

				spanWrap.append(img);
				spanWrap.append(titleSpan);
				spanWrap.append(idSpan);				
				spanWrap.append(typeSpan);
				spanWrap.append(resultSpan);
				spanWrap.append(detailButton);
				contentTd.append(spanWrap);

				timeTd.append(timeSpan);

				tr.append(contentTd);
				tr.append(timeTd);

				$("#notifications_tbody").append(tr);
			}


			$('.detail_button').click(function(event){

				var notification_id = $(this).parents('tr').data('id');
				$.ajax({
					url: 'change_notification_state.php',
					type: 'POST',
					data: {message_id: notification_id},
				})
				post("detail_notification.php", {'id':notification_id}, "get");
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


$("#next_page").click(function(event) {
	if (currentPage + 1 < pageNumber) {
		currentPage ++;
		fetchNotifications(currentPage);
	}
});

$("#prev_page").click(function(event) {
	if (currentPage >= 1) {
		currentPage --;
		fetchNotifications(currentPage);
	}
});

$("#goto_page").click(function(event) {
	var gotoPage = $("#current_page").val();
	if (gotoPage >= 1 && gotoPage <= pageNumber) {
		currentPage = gotoPage - 1;
		fetchNotifications(currentPage);
	}
});