<?


	if ($_POST['Type_question_ID'] == 3) {
		$Data['QA']= [];
		if($_POST['true_txt']==1){
			$Data['QA'][0]["A"] = 1;
		}else{
			$Data['QA'][0]["A"] = 0;

		}
								//   = 		$Data['txt_Degree']           = $this->input->post('bankId');;
				}
			if ($_POST['Type_question_ID'] == 2 || $_POST['Type_question_ID'] == 1) {
			$Data['bankId'] =2;

				$Data['QA']= [];
					foreach ($_POST['txt_multi_Choices'] as $key => &$Choice) {

					$Data['QA'][$key]["A"] = $Choice;
					if ($_POST['slct_Correct_Answer1'][$key] == 1) {
						$Data['QA'][$key]["Q"] = 1;
					} else {
						$Data['QA'][$key]["Q"] = '';
					}
					
				}
				
			
			}elseif($_POST['Type_question_ID'] == 7){
				$Data['QA']= [];
				// dd($_POST['txt_match_question']);
				
				foreach ($_POST['txt_match_question'] as $key => &$question) {
					// if ($question == 'undefined') {
					// 	break;
					//   }
					$Data['QA'][$key]["Q"] = $question;
					$Data['QA'][$key]["A"] = $_POST['txt_match_answer'][$key];

				}

			// print_r($Data);die;
				
			
			}
			
			if ($this->input->post('Type_question_ID') == 4) {
				$Data['QA'] = $this->input->post('txt_answer');;
			}
			$url = 'https://chat.lms.esol.com.sa/apikey/bank/question';
			// print_r($_POST );
			// die;
			$data = http_build_query($Data);
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 3);
			curl_setopt($ch, CURLOPT_TIMEOUT, 20);
			$response = curl_exec($ch);
			
			curl_close($ch);
			// dd($response);
			
			?>