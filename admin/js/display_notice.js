function display_notice(notice, notice_good_bad) {
	$('.notice').remove();
	

	if ( notice_good_bad != '' ) {
		notice_div = '<div class="alert alert-' + notice_good_bad + '"><button type="button" class="close" data-dismiss="alert">&times;</button>'+ decodeURIComponent(notice) + '</div>';
		console.log(notice_div);
		$('span.notice_here').after(notice_div);
		$('.notice').slideDown('slow');
	}
}