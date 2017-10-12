$(document).ready(function () {
	$(function(){
			$("#slideshow4 > div:gt(0)").hide();
			setInterval(function() {
			  $('#slideshow4 > div:first')
				.fadeOut(3000)
				.next()
				.fadeIn(3000)
				.end()
				.appendTo('#slideshow4');
			}, 6000);
	});
	$(function(){
			$("#slideshow5 > div:gt(0)").hide();
			setInterval(function() {
			  $('#slideshow5 > div:first')
				.fadeOut(2000)
				.next()
				.fadeIn(2000)
				.end()
				.appendTo('#slideshow5');
			}, 3000);
	});
	$(function(){
			$("#slideshow6 > div:gt(0)").hide();
			setInterval(function() {
			  $('#slideshow6 > div:first')
				.fadeOut(2000)
				.next()
				.fadeIn(2000)
				.end()
				.appendTo('#slideshow6');
			}, 2000);
	});
});
	