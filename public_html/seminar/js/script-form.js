$(function(){


	$('#btn-seminar-inquiry-1').click(function(){
		$('#area-seminar-inquiry-form').toggle('slide', {direction:'up'});
	});


	$('#inquiry-type').change(function(){
		if ($('#inquiry-type').val() == 1) {
			var textarea_text = "・参加希望のセミナー名・日程\n・参加希望の会場\n・当日連絡の付く電話番号\n・興味のある国\n・出発予定時期";
		} else {
			var textarea_text = "";
		}

		$('#area-textarea').val(textarea_text);
	});



	$("#btn-submit").click(function(){

		var error_message = '';

		var inquiry_type = $('#inquiry-type').val();
		var inquiry_detail = $('#area-textarea').val();
		var your_name = $('#your-name').val();
		var your_email = $('#your-email').val();

		if ((inquiry_type == '') || (inquiry_type == 0)) {
			error_message += 'お問い合わせ内容を選択してください。<br />';
		}

		if (inquiry_detail == '') {
			error_message += 'お問い合わせ詳細を入力してください。<br />';
		}

		if (your_name == '') {
			error_message += 'お名前を入力してください。<br />';
		}

		if (your_email != '') {
			if(!your_email.match(/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/)){
				error_message += 'メールアドレスを正しく入力してください。<br />';
			}
		} else {
			error_message += 'メールアドレスを入力してください。<br />';
		}


		if (error_message != '') {
			$("#area-form-message").html(error_message);
		} else {
			$.ajax({
				type: "POST",
				url: "/seminar/seminar-submit.php",

				data: {
					inquiry_type:inquiry_type,
					inquiry_detail:inquiry_detail,
					your_name:your_name,
					your_email:your_email
				},

				success: function(result) {
					//$("#area-form-message").html(result);

					$(".link-qa-sp").remove();

					var successHtml = '<div class="success-message">';
					successHtml += '<p class="success-message-title">送信が完了いたしました。</p>';
					successHtml += '<p>ご入力いただいたメールアドレスに受付完了のメールをお送りいたしました。</p>';
					successHtml += '<p>メールが届かない場合は受付が正式に完了していない可能性がございますので、<br />メールアドレスに間違いがないか、また迷惑メールとして分類されていないかご確認のうえ、恐れ入りますが再度お問い合わせください。</p>';
					successHtml += '<p>3営業日以内にはご返答差し上げますので、<br />今しばらくお待ちいただきますようお願いいたします。</p>';
					successHtml += '</div>';

					$("#area-seminar-inquiry-form").html(successHtml);

					var backPosition = $(".area-seminar-inquiry-form-sp").offset().top;
					$('html,body').scrollTop(backPosition);

				},

				error: function(XMLHttpRequest, textStatus, errorThrown) {
					alert('Error : ' + errorThrown);
				}
			});
		}

	});





});
