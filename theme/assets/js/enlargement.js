$(function() {
	$('#border-space')
	.hover(
		function(){
			$(this).stop().animate({
				'width':'570px',//拡大で表示させておくサイズ
				'height':'370px',
				'marginTop':'-10px'//トップのマージンをマイナスで指定す事で底辺を起点としています
			},'fast');
		},
		function () {
			$(this).stop().animate({
				'width':'550px',//デフォルトで表示させておくサイズ
				'height':'352px',
				'marginTop':'0px'
			},'fast');
		}
	);
});