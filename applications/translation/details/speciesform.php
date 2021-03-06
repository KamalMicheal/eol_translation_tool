<?php
	// Include CKEditor class.
	include_once "../../../classes/modules/ckeditor/ckeditor.php";
	
	//Load current Object info	 
	$EnObj = BLL_data_objects::Select_DataObjects_ByID('slave',$objectID);       
	$ArObj = BLL_a_data_objects::Select_a_data_objects_ByID($objectID);//select latest version of that object at any process

	$object_title='';
	$rights_statement='';
	$rights_holder='';
	$description='';
	$location='';	
	
	//Load data of last data Object
	if($ArObj!=null)
	{
	   	$object_title = $ArObj->object_title;
	   	$rights_statement = $ArObj->rights_statement ;
	 	$rights_holder = $ArObj->rights_holder;
	 	$description = $ArObj->description;
	 	$location = $ArObj->location;
	}
	
	//Calculate condition of the Object	
	$condition = BLL_a_data_objects::Condition($process,$ArObj);	
	$onlyView = 0;
	if($condition==3 || $condition==4)//If finished or locked
		$onlyView = 1;    
?>
    <!-- -------------------------Begin of Data Object Form -------------------- -->

<script type="text/javascript">   

     function validate_form()
     {
    	 	//Reset last Errors
    	 	document.getElementById('t_error').style.display="none";
    	 	document.getElementById('s_error').style.display="none";
    	 	document.getElementById('h_error').style.display="none";
    	 	document.getElementById('d_error').style.display="none";
    	 	document.getElementById('l_error').style.display="none";
         
    		var valid=true;

    		var en_title="<?php echo str_replace("\"","'",TRIM($EnObj->object_title));?>";
    		if(en_title.length>0)
    		{
	    		if (trim(document.getElementById('TXT_title').value)=='')
	     		{       			
	         		document.getElementById('t_error').style.display="block";
	         		valid=false;	         		
	     		}
    		} 

     		var en_rs="<?php echo str_replace("\"","'",TRIM($EnObj->rights_statement));?>";
     		if(en_rs.length>0)
     		{  		
	     		var rs = document.getElementById('cke_contents_RS_editor').getElementsByTagName('iframe');
	     		if (en_rs.length>0 && rs[0].contentWindow.document.body.innerHTML.length<=4)
	         	{       			
	         		document.getElementById('s_error').style.display="block";
	         		valid=false;
	     		}
     		}

     		var en_rh="<?php echo str_replace("\"","'",TRIM($EnObj->rights_holder));?>";
     		if(en_rh.length>0)
     		{   
	            var rh = document.getElementById('cke_contents_RH_editor').getElementsByTagName('iframe');
	            if (rh[0].contentWindow.document.body.innerHTML.length<=4)
	     		{       			
	         		document.getElementById('h_error').style.display="block";
	         		valid=false;
	     		}
     		}
     		
    		var en_loc="<?php echo str_replace("\"","'",TRIM($EnObj->location));?>";
     		if(en_loc.length>0)
     		{  		
	     		var loc = document.getElementById('cke_contents_LOC_editor').getElementsByTagName('iframe');
	     		if (en_loc.length>0 && loc[0].contentWindow.document.body.innerHTML.length<=4)
	         	{       			
	         		document.getElementById('l_error').style.display="block";
	         		valid=false;
	     		}
     		}
     		
     		var en_description="<?php echo strlen($EnObj->description);?>";    
            if(en_description>0)
            {
	     		var d = document.getElementById('cke_contents_D_editor').getElementsByTagName('iframe');
	            if (d[0].contentWindow.document.body.innerHTML=='' || d[0].contentWindow.document.body.innerHTML=='<p><br></p>' || d[0].contentWindow.document.body.innerHTML=='<br>' || d[0].contentWindow.document.body.innerHTML=='<P>&nbsp;</P>')
	     		{       			
	         		document.getElementById('d_error').style.display="block";
	         		valid=false;
	     		}
            }
            
     		if(valid==false)
         		alert('Please fill in the all fields');
     		
     		return valid;
     }
          
   </script>  
 
    <form name="frm" id="frm"  method="post" action="species.php?tid=<?=$taxonID?>&oid=<?=$objectID?><?=$otherparam?>" >
    
        <div class="form">
          <h2>
          	<span style="float:left">
          		Species Form   <span style="font-color:#666666;font-size:12px;font-weight: none;"> &nbsp;&nbsp;&nbsp;&nbsp;(<?php echo 'Form ID='.$EnObj->id?>)</span>
          	</span>	
          	<span style="float:right">
          		<a href="../list/mylist.php?<?=$otherparam?>"><< Back to Species List</a>
          	</span>
          	<br/>          	
          	<?			    
          		if($ArObj!=null){
          	?>
          		<span style="font-size:10px; font-color:#666666; font-family: Arial,Helvetica,sans-serif; font-weight: none; text-transform:none;">
          		<b>Last modified by</b>: <i><?echo BLL_users::get_user_name($ArObj->user_id)?></i>, <b>on </b><?echo $ArObj->modified_at?><i> (
          			<?
          				if($ArObj->locked==0)//Problem
          					echo BLL_status::Select_Status_ByID($ArObj->process_id-1).' Finished, '. 'Pending '.BLL_status::Select_Status_ByID($ArObj->process_id);
          				else
          					echo 'Pending '.BLL_status::Select_Status_ByID($ArObj->process_id);
          			?>
          		)</i>
          	<? }?>
          	
          	</span>
          </h2>      
         
           <div style="border:1px solid #C6C6C6; border-top:none;">
            <table  border="0" cellpadding="10" cellspacing="0" width="100%">
            <?php if($onlyView==0 && TRIM($EnObj->object_title)=='' && TRIM($EnObj->description)=='' && TRIM($EnObj->location)=='') $display="block"; else $display="none";?>
            	<tr style="display:<?=$display?>">
                	<td colspan="2" style="width:660px;text-align:center" align="center">
                		<b>This object has no fields that require translation. Please click on "Save &amp; Finish" Button.</b>
                </td>
              	</tr>
			<?php if(TRIM($EnObj->object_title)=='') $display="none"; else $display="block"; ?>
				<tr style="display:<?=$display?>">
                	<td class="odd_left" width="108">Title (En):</td>
                	<td class="odd" style="width:531px"><?=$EnObj->object_title?></td>
              	</tr>
              	<tr style="display:<?=$display?>">
                	<td class="even_left" width="108">Title (Ar):</td>
                	<td class="even_border" style=" text-align:right; width:531px">
                	<?php 
			          //If only view so do not display buttons
          				if($onlyView==1)
          				{
          					echo $object_title.'&nbsp;';
          				}else{
          				?>
                		<input id="TXT_title" type="text" name="SP_title"  style="width:525px; direction: rtl"  value="<?=$object_title?>"  />
                		<span id="t_error" class="error">Please fill in the Arabic title</span>
                	<?php }?>
                		
                </td>
              </tr>
              <?php 
             	$display="block";
             	if(TRIM($EnObj->location)=='') 
             		$display="none"; 
             	else 
             	{             		
           			$template = BLL_templates::Select_templates_ByEnName($EnObj->location);
           			if($template!=null)
           			{     
           				$display="none";
           			}             				 
             	}
             	?>
             	
              <tr style="display:<?=$display?>">
                <td class="odd_left"  width="108">Location (En):</td>
                <td class="odd"  style="width:531px"><?=$EnObj->location?></td>
              </tr>
              <tr style="display:<?=$display?>">
                <td class="even_left"  width="108">Location (Ar):</td>
                <td class="even_border" style=" text-align:right; width:531px">                   
                   <?php
						//If only view so do not display buttons
          				if($onlyView==1)
          				{
          					echo $location.'&nbsp;';
          				}
          				else{
							$LOC_CKEditor = new CKEditor();
							$LOC_CKEditor->basePath = '../../../classes/modules/ckeditor/';
							// Configuration that will be used only by the editor.
							$config['toolbar'] = array(
								 array('Source','-','NewPage'),					   
							     array('Link','Unlink'),
							);
							$config['width'] = 530;
							$config['height'] = 30;
		 					$config['toolbarCanCollapse'] = false;
		 					
							// Create second instance.
							echo $LOC_CKEditor->editor("LOC_editor", $location, $config);
          				}
					?>
					<span id="l_error" class="error">Please fill in the Arabic Location</span>
                </td>
              </tr>
             <?php 
             	$display="block";
             	$template = null;
             	if(TRIM($EnObj->rights_statement)=='') 
             		$display="none"; 
             	else 
             	{             		
           			$template = BLL_templates::Select_templates_ByEnName($EnObj->rights_statement);
           			if($template != null)
           			{
           				$rights_statement =$template->name_ar;   
           			}             				 
             	}
              	if($template != null){
              	?>
              		<tr style="display:<?=$display?>">
		                <td class="odd_left"  width="108">Rights Stat. (En):</td>
		                <td class="odd"  style="width:531px"><?=$EnObj->rights_statement?></td>
		              </tr>
		              <tr style="display:<?=$display?>">
		                <td class="even_left"  width="108">Rights Stat. (Ar):<br/><span style="font-size:9px; font-weight:normal;">(Automatically translated)</span></td>
		                <td class="even_border" style="text-align:right; width:531px">                   
		                   <?php
		          				echo $rights_statement.'&nbsp;';
							?>
		                </td>
		              </tr>
		              <tr style="display:none">
		                <td>
		                	<?php 
		                		$RS_CKEditor = new CKEditor();
								$RS_CKEditor->basePath = '../../../classes/modules/ckeditor/';
								// Configuration that will be used only by the editor.
								$config['toolbar'] = array(
									 array('Source','-','NewPage'),					   
								     array('Link','Unlink'),
								);
								$config['width'] = 530;
								$config['height'] = 30;
			 					$config['toolbarCanCollapse'] = false;
								// Create second instance.
								echo $RS_CKEditor->editor("RS_editor", $rights_statement, $config);
		                	?>
		                	<span id="s_error" class="error">Please fill in the Arabic Rights Statement</span>
		                </td>
		              </tr>
              	<?php
              		 
              	}
              	
              	else{
              	?>
              		<tr style="display:<?=$display?>">
		                <td class="odd_left"  width="108">Rights Stat. (En):</td>
		                <td class="odd"  style="width:531px"><?=$EnObj->rights_statement?></td>
		              </tr>
		              <tr style="display:<?=$display?>">
		                <td class="even_left"  width="108">Rights Stat. (Ar):</td>
		                <td class="even_border" style=" text-align:right; width:531px">                   
		                   <?php
								//If only view so do not display buttons
		          				if($onlyView==1)
		          				{
		          					echo $rights_statement.'&nbsp;';
		          				}
		          				else{
									$RS_CKEditor = new CKEditor();
									$RS_CKEditor->basePath = '../../../classes/modules/ckeditor/';
									// Configuration that will be used only by the editor.
									$config['toolbar'] = array(
										 array('Source','-','NewPage'),					   
									     array('Link','Unlink'),
									);
									$config['width'] = 530;
									$config['height'] = 30;
				 					$config['toolbarCanCollapse'] = false;
									// Create second instance.
									echo $RS_CKEditor->editor("RS_editor", $rights_statement, $config);
		          				}
							?>
							<span id="s_error" class="error">Please fill in the Arabic Rights Statement</span>
		                </td>
		              </tr>
              	<?php 	
              	} 
              ?>
               <?php 
                $display="block";
                $template = null;
             	if(TRIM($EnObj->rights_holder)=='') 
             		$display="none"; 
             	else 
             	{
           			$template = BLL_templates::Select_templates_ByEnName($EnObj->rights_holder);
           			if($template!=null)
           			{
           				$rights_holder =$template->name_ar;
           			} 
             	}
				if($template != null){
				?>
					<tr style="display:<?=$display?>">
		                <td class="odd_left" width="108">Rights Holder (En):</td>
		                <td class="odd" style="width:531px"><?=$EnObj->rights_holder?></td>                				   
		              </tr>
		              <tr style="display:<?=$display?>">
		                <td class="even_left"  width="108">Rights Holder (Ar):<br/><span style="font-size:9px; font-weight:normal;">(Automatically translated)</span></td>
		                <td class="even_border" style=" text-align:right; width:531px">
		                    <?php
		                    	echo $rights_holder.'&nbsp;';
							?>
							<span id="h_error" class="error">Please fill in the Arabic Rights Holder</span>
						</td>
					</tr>
					<tr style="display:none">
						<td>
							<?php 
								$RH_CKEditor = new CKEditor();
								$RH_CKEditor->basePath = '../../../classes/modules/ckeditor/';						
								// Create second instance.
								echo $RH_CKEditor->editor("RH_editor", $rights_holder, $config);
							?>
							<span id="s_error" class="error">Please fill in the Arabic Rights Statement</span>
						</td>
					</tr>
				<?php 
					}
					else{
				?>
						<tr style="display:<?=$display?>">
			                <td class="odd_left" width="108">Rights Holder (En):</td>
			                <td class="odd" style="width:531px"><?=$EnObj->rights_holder?></td>                				   
			              </tr>
			              <tr style="display:<?=$display?>">
			                <td class="even_left"  width="108">Rights Holder (Ar):</td>
			                <td class="even_border" style=" text-align:right; width:531px">
			                    <?php                    
									if($onlyView == 1)
			          				{		
			          					echo $rights_holder.'&nbsp;';
			          				}
			          				else{				
										$RH_CKEditor = new CKEditor();
										$RH_CKEditor->basePath = '../../../classes/modules/ckeditor/';						
										// Create second instance.
										echo $RH_CKEditor->editor("RH_editor", $rights_holder, $config);
			          				}
								?>
								<span id="h_error" class="error">Please fill in the Arabic Rights Holder</span>
			                </td>
			              </tr>
				<?php 	
					}
				?>
              <?php if(TRIM($EnObj->description)=='') $display="none"; else $display="block"; ?>
             
              <tr style="display:<?=$display?>">
                <td class="odd_left" width="108">Details (En):</td>
                <td class="odd">
                	<div style="overflow: auto; max-height: 200px; width:531px">
                		<?=$EnObj->description?> 
                	</div>
                </td>
              </tr>
              <tr style="display:<?=$display?>">
                <td class="even_left"  width="108">Details (Ar):</td>
                <td class="even_border" style="text-align:right; width:531px; direction:rtl;">
        	        <?php
						if($onlyView==1)
          				{	
          				?>
          				<div style="overflow: auto; max-height: 200px; width:531px"">
          				<?php echo  $description.'&nbsp;';?>
          				</div>
          			<?php 		          				
          				}
          				else{
							$D_CKEditor = new CKEditor();
							$D_CKEditor->basePath = '../../../classes/modules/ckeditor/';
							// Configuration that will be used only by the editor.
							$config['toolbar'] = array(	
								 array('NewPage'),							 
							     array('Copy','Cut','Paste','PasteFromWord'),		     
							     array('Undo','Redo','-','Find','-','SelectAll' ),
							     array('Link','Unlink','Image','HorizontalRule','Table'),
							     array('Source'),
							     array('Bold','Italic','Underline'),
							     array('NumberedList','BulletedList','-','Outdent','Indent'),
							     array('JustifyLeft','JustifyCenter','JustifyRight','-','BidiLtr', 'BidiRtl'),
							     array('FontSize','TextColor','BGColor')
							);
							$config['width'] = 530;
							$config['height'] = 200;
		 					$config['toolbarCanCollapse'] = false;
							// Create second instance.
							echo $D_CKEditor->editor("D_editor", $description, $config);
          				}
					?>
					<span id="d_error" class="error">Please fill in the Arabic Description</span>
                </td>
              </tr>
            </table>
          </div>
          <div class="Buttons">          
          <input type="hidden" id="actionType" name="actionType" value="" />          
          <?php 
          //If only view so do not display buttons
          if($onlyView==0)
          {
          ?>
          <?php if(TRIM($EnObj->object_title)=='' && TRIM($EnObj->description)=='' && TRIM($EnObj->location)=='') $display="none"; else $display="block";?>
          <div style="display:<?=$display?>" class="btn">
            <div class="link_middle">            	
            	<a href="javascript:void(0);" onclick='location.href=location.href'>Reset</a></div>
          </div>
          <div style="display:<?=$display?>" class="btn">
            <div class="link_middle">
            	<a href="javascript:void(0);" onclick='document.getElementById("actionType").value="0"; if(isConfirmed()) document.frm.submit();'>
            	<img src='../images/pending.png' border='0'/> Save
            	</a>
            </div>
          </div>
         
          <div class="btn">
            <div class="link_middle">
            	<a href="javascript:void(0);" onclick='if(validate_form()){document.getElementById("actionType").value="1"; if(isConfirmed()) document.frm.submit();}'>
            	<img src='../images/finished1.png' border='0'/>	Save & Finish
            	</a>
            </div>
          </div>
          	<?php 
	          //If only view and also linguistic review or final editor process so display the Finish All Button
          	 if($process==3 || $process==5)
          	 {
          	 ?>
	          <div class="btn">
	            <div class="link_middle">
	            	<a href="javascript:void(0);" onclick='document.getElementById("actionType").value="2"; if(isConfirmed()) document.frm.submit();'>
	            	<img src='../images/finished1.png' border='0'/>
	            	<img src='../images/finished1.png' border='0'/>
	            	 Finish All
	            	</a>
	            </div>
	          </div>
    	      <?php 
        	  }//end if process is 4 or 6
           }//end if not only view
           ?>
          </div>
        </div>
    </form>
    
    <script>
    	function isConfirmed() {
        	if(document.getElementById("actionType").value=="2")//finish all
        		return confirm('Are you sure you want to Finish all Species Objects? \r\nBy clicking OK, no more modifications will be allowed on any object of this species.');
        	else if(document.getElementById("actionType").value=="1")//finish one
        		return confirm('Are you sure you want to Finish this Object? \r\nBy clicking OK, no more modifications will be allowed on this object.');
        	else //0 then save
    			return true;
    	}
    </script>
    
       <!-- -------------------------End of Data Object Form-------------------- -->
        
