window.onload = function() {
	var check = document.getElementById('check_btn');
	check.addEventListener("click", confirm_value);

}

function confirm_value () {
	var form = document.forms.mainForm;
	var word = form.word.value;
	var conditions = form.conditions.value;
	var classify = form.classify.value;
	var judge = form.judge.value;
	// 全てに値が代入されているとき
	if (word && conditions && classify && judge){
		var result = confirm("これでいい？");
		// alert(result);
		if (result) {
			// alert("d");
			$.ajax({
				type: 'POST',
				url: 'raise_up_search.php',
				data: {'result' : result},
				success: function(data) {
					alert(data);
					console.log(data);
					$('#result').html(data);
				}
			});
		} else {
			alert("もう一度確認よろしく");
		}
		// ajax
	}

	return false;

}

