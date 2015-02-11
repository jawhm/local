
    <div data-role="page" id="step2" class="jquery">
    
        <div id="header-box">
            <h1>メンバー登録</h1>
        </div><!-- /header -->
        
        <div data-role="content" data-theme="b">
         	<h2>STEP 2</h2>
            <h3>入力頂いた内容を確認の上、よろしければ「次へ」をクリックしてください。</h3>
             
			 <?php //echo debug_array($final_array);	?>	
             
             
            <div data-role="fieldcontain" >
                    <span class="listing-title">メールアドレス</span>
                    <p><?php echo $final_array['email'] ?></p>
            </div>
            <div data-role="fieldcontain" >
                    <span class="listing-title">お名前</span>
                    <p><?php echo $final_array['name'].'&nbsp;&nbsp;'.$final_array['firstname'] ?></p>
            </div>
            <div data-role="fieldcontain" >
                    <span class="listing-title">フリガナ</span>
                    <p><?php echo $final_array['phonetic_name'].'&nbsp;&nbsp;'.$final_array['phonetic_firstname'] ?></p>
            </div>
            <div data-role="fieldcontain" >
                    <span class="listing-title">性別</span>
                    <p>
					<?php 
						if ($final_array['gender'] == 'm')
							echo '男性';
						else
						  	echo '女性';
						 ?>
                    </p>
            </div>
            <div data-role="fieldcontain">
                    <span class="listing-title">生年月日</span>
                    <p><?php echo $final_array['select-choice-year'].'年&nbsp;'. $final_array['select-choice-month'].'月&nbsp;'. $final_array['select-choice-day'].'日'; ?></p>
            </div>

            <div data-role="fieldcontain">
                    <span class="listing-title">メールアドレス</span>
                    <table cellspacing="10" border="0">
                    	<tr>
                        	<td>郵便番号</td><td><?php echo $final_array['postcode'] ?></td>
                        </tr>
                    	<tr>
                        	<td>都道府県</td><td><?php echo $final_array['province']?></td>
                        </tr>	
                    	<tr>
                        	<td>市区町村</td><td><?php echo $final_array['municipality'] ?></td>
                        </tr>	
                    	<tr>
                        	<td>番地・建物名</td><td><?php echo $final_array['address']?></td>
                        </tr>	
                    </table>
            </div>
            <div data-role="fieldcontain" class="div-form">
                    <span class="listing-title">電話番号</span>
                    <p><?php echo $final_array['phonenumber'] ?></p>
            </div>
            <div data-role="fieldcontain" class="div-form">
                    <span class="listing-title">職業</span>
                    <p><?php echo $final_array['occupation'] ?></p>
            </div>
            <div data-role="fieldcontain" class="div-form">
                    <span class="listing-title">渡航予定国</span>
                    <p><?php echo $final_array['country'] ?></p>
            </div>
            <div data-role="fieldcontain" class="div-form">
                    <span class="listing-title">渡航予定国の語学力</span>
                    <p><?php echo $final_array['language-skill'] ?></p>
            </div>
            <div data-role="fieldcontain" class="div-form">
                    <span class="listing-title">渡航目的</span>
                    <p><?php echo $final_array['travel-purpose'] ?></p>
            </div>
            <div data-role="fieldcontain" class="div-form">
                    <span class="listing-title">どこで当協会を知りましたか</span>
                    <p><?php echo $final_array['know-how'] ?></p>
            </div>
            <div data-role="fieldcontain" class="div-form">
                    <span class="listing-title">どこで当協会を知りましたか</span>
                    <p><?php if ($final_array['guide'] == '1')
								echo '受け取る';
							  else
							  	echo '受け取らない';
						 ?>
                    </p>
            </div>
            <div data-role="fieldcontain" class="div-form">
            <form name="step2form" method="post" action="check.php" data-ajax="false">
            
            <?php
				// Serialize the final array to be able to send it through form
				$serialize_array = serialize($final_array);
			?>
            	<input type="hidden" name="step" value="2" />
            	<input type="hidden" name="final_array" value='<?php echo $serialize_array; ?>' />
                <a href="" type="button" data-theme="b" data-icon="back" data-rel="back" data-inline="true" />戻る</a>
                <input type="submit" value="次へ" data-theme="b" data-icon="check" data-inline="true" />
            
            </form>
            </div>
            
            
        </div><!-- /content -->
        
       <?php echo footer(); ?>
         
    </div>