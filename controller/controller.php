<script src="http://cdn.jquerytools.org/1.2.7/full/jquery.tools.min.js"></script>
<?php
session_start();
ini_set("display_errors", "1");

$route = array();

class MyClass {
	
	public function selectLanguage(){
		//echo $_REQUEST['value'];die;
	  $_SESSION['lang'] = $_REQUEST['value'];
	 
	}
	
	public function checkcaptcha(){
           $original=$_SESSION["captcha"];
           $received=md5($_REQUEST["captchaval"]);
           if($original==$received){
           $_SESSION['captchaerror']=0;}
           else {
               $_SESSION['captchaerror']=1;
               echo 1;
           }
       }
	
    
    /* -----------------------------------------------------
         Function to add FAQ called from faq.php
       -----------------------------------------------------
    */
    
	public function question ()
	{
		$id=$_REQUEST['id'];
	        require_once("../model/gettersettermodel.php");
	        $find=new Register();
           	$fetch = $find->Question($_REQUEST['id']);
           	require_once("../View/showresult.php");
           	$this->fetchcomment("0", $id);
		    
	}
	
	
	
	public function savereply ()
	{
		
		require_once("../model/gettersettermodel.php");
		$find=new Register();
		
		$find->setName($_POST['name']);
		$find->setEmail($_POST['email']);
		$find->setComment($_POST['comment']);
		$fetch = $find->saveReply($_REQUEST['id']);
		$result=explode(",", $fetch);
		
		if($result[0] == "1")
		{
			$id=$_REQUEST['id'];
			$this->fetchlatestcomment($result[1] , $id);
			//require_once("../View/commentshow.php");
		}
	
	}
	public function rereply ()
	{
		
		require_once("../model/gettersettermodel.php");
		$find=new Register();
		
		$find->setName($_REQUEST['name']);
		$find->setEmail($_REQUEST['email']);
		$find->setComment($_REQUEST['comment']);
		$fetch = $find->saveReply($_REQUEST['id'],$_REQUEST['parentid']);
		$result=explode(",", $fetch);
	
		if($result[0] == "1")
		{
			$id=$_REQUEST['id'];
			$this->fetchlatestcomment($result[1] , $id);
			//require_once("../View/commentshow.php");
		}
	
	}
	public function fetchcomment ($parent , $id)
	{
		
	
		require_once("../model/gettersettermodel.php");
		$find=new Register();
		$result = $find->fetchComment($parent , $id);
		//echo "<pre>";
		//print_r($result);die;
		require_once("../View/showcomment.php");
	}
	
	public function fetchlatestcomment ($parent , $id)
	{
	
	
		require_once("../model/gettersettermodel.php");
		$find=new Register();
		$result = $find->fetchLatestcomment($parent , $id);
		//echo "<pre>";
		//print_r($result);die;
		require_once("../View/showcomment.php");
	}
	
	public function handlelikes ()
	{
		require_once("../model/gettersettermodel.php");
		$find=new Register();
		$find->setReplyid($_REQUEST['replyid']);
		$find->setPageid($_REQUEST['id']);
		$result = $find->handleLikes();
		if($result == "1")
		{
			die("1");
		}
		//echo "<pre>";
		//print_r($result);die;
		//require_once("../View/showcomment.php");
	}
	public function handleunlike ()
	{
		require_once("../model/gettersettermodel.php");
		$find=new Register();
		$find->setReplyid($_REQUEST['replyid']);
		$find->setPageid($_REQUEST['id']);
		$result = $find->handleUnlikes();
		if($result == "1")
		{
			die("1");
		}
		//echo "<pre>";
		//print_r($result);die;
		//require_once("../View/showcomment.php");
	}
	
	public function findusers ()
	{
	
		require_once("../model/model.php");
		$find=new MyModel();
		$fetch = $find->findUser();
		echo "Select User:<select name='rolename' id='user' onchange='setuser()' >";
		echo "<option value='-1'>---Select---</option>";
		for($i =0 ; $i < count($fetch) ; $i++)
		{
		echo "<option value='" . $fetch[$i]['id'] ."'>" . ucfirst($fetch[$i]['name']) ."</option>";
		}
		echo "</select>";
				echo "<br />";
					echo "<br />";
					echo "<input type='button' value='Submit' onclick='submituser()'/>";
					echo "<input type='button' value='Fetch Roles' onclick='fetchrole()'/>";
	}
	
	public function findscreen ()
	{
	
		require_once("../model/model.php");
		$find=new MyModel();
		$fetch = $find->findScreen();
		
		echo "<form id='frmid' method='post' action='assign.php'>";
		echo "<table border='1'>";
		
		echo "<tr>";
		echo "<td>Screen Name</td>";
		echo "<td><input type='checkbox'  id='selectall' class='case' onclick='abc()'/>ADD</td>";
		echo "<td><input type='checkbox'  id='edit'/>EDIT</td>";
		echo "<td><input type='checkbox'  id='delete'/>DELETE</td>";
		echo "<td><input type='checkbox'  id='view'/>VIEW</td>";
		echo "</tr>";
		echo "<input type='hidden' value='".$_REQUEST['role']."' name='role' />";
		$j=0;
		 for($i =0 ; $i < count($fetch['screens']) ; $i++)
		{
			$k=0;
			if(isset($fetch['permission'][$i]))
			{
			$permission=explode(",", $fetch['permission'][$i]['permit']);
			
			
			}
			else 
			{
				$permission = array('','','','');
			}
			echo "<br/>";
			$j++;
			echo "<tr>";
			echo "<td>".$fetch['screens'][$i]['name']."</td>";
			if($permission[$k]=="1")
			{
				echo "<td><input type='checkbox' name='add[".$i."]' value=".$j." class='case' checked='checked'/></td>";
				$k++;		
			}
			else
			{
				if(isset($permission[$k]))
				{
					echo "<td><input type='checkbox' name='add[".$i."]' value=".$j." class='case' /></td>";
				}
				$k++;
			}
			if($permission[$k]=="1")
			{
				echo "<td><input type='checkbox' name='edit[".$i."]' value=".$j."  checked='checked'/></td>";
				$k++;
			}
			else
			{
				if(isset($permission[$k]))
				{
				echo "<td><input type='checkbox' name='edit[".$i."]' value=".$j."  /></td>";
				}
				$k++;
			}
			if($permission[$k]=="1")
			{
				echo "<td><input type='checkbox' name='delete[".$i."]' value=".$j."  checked='checked'/></td>";
				$k++;
			}
			else
			{
				if(isset($permission[$k]))
				{
					echo "<td><input type='checkbox' name='delete[".$i."]' value=".$j." /></td>";
				}
				$k++;
			}
			if($permission[$k]=="1")
			{
				
				echo "<td><input type='checkbox' name='view[".$i."]' value=".$j."  checked='checked'/></td>";
				$k++;
			}
			else 
			{
				if(isset($permission[$k]))
				{
				echo "<td><input type='checkbox' name='view[".$i."]' value=".$j."  /></td>";
				}
				$k++;
			}
				echo "</tr>";
		} 
		echo "<br/>";
		echo "<br/>";
		echo "<input type='button' value='Assign' onclick='assign()' />";
		echo "</form>";
		
		
		echo "</table>";
		
		
	}
	
	public function assignselection ()
	{
		
		
		require_once("../model/model.php");
		
		$find=new MyModel();
		$fetch = $find->assignRole($_REQUEST);
		/* echo "Select Role:<select name='rolename' id='role' onchange='findscreens()'>";
		echo "<option value='-1'>---Select---</option>";
		for($i =0 ; $i < count($fetch) ; $i++)
		{
		echo "<option value='" . $fetch[$i]['role'] ."'>" . $fetch[$i]['role'] ."</option>";
		    }
				echo "</select>";
				echo "<br />";
				echo "<br />"; */
				//echo "<input type='button' value='".$lang->ASSIGN."' onclick='assign()'/>"; */
	}
	
	
	public function adduser ()
	{
		
		require_once("../model/model.php");
		$find=new MyModel();
		$fetch = $find->addUser();
		if($fetch=="updated")
		{
			echo $fetch;
			
		}
	}
	
	public function fetchroles ()
	{
	
		
		require_once("../model/model.php");
		$find=new MyModel();
		$fetch = $find->fetchRoles();
		
		echo "<form id='frmid' method='post' action='assign.php'>";
		echo "<table border='1'>";
		
		echo "<tr>";
		echo "<td>Screen Name</td>";
		echo "<td><input type='checkbox'  id='selectall' class='case' onclick='abc()'/>ADD</td>";
		echo "<td><input type='checkbox'  id='edit'/>EDIT</td>";
		echo "<td><input type='checkbox'  id='delete'/>DELETE</td>";
		echo "<td><input type='checkbox'  id='view'/>VIEW</td>";
		echo "</tr>";
		echo "<input type='hidden' value='".$_REQUEST['role']."' name='role' />";
		$j=0;
		 for($i =0 ; $i < count($fetch['screens']) ; $i++)
		{
			$k=0;
			if(isset($fetch['permission'][$i]))
			{
			$permission=explode(",", $fetch['permission'][$i]['permit']);
			
			
			}
			else 
			{
				$permission = array('','','','');
			}
			echo "<br/>";
			$j++;
			echo "<tr>";
			echo "<td>".$fetch['screens'][$i]['name']."</td>";
			if($permission[$k]=="1")
			{
				echo "<td><input type='checkbox' name='add[".$i."]' value=".$j." class='case' checked='checked'/></td>";
				$k++;		
			}
			else
			{
				if(isset($permission[$k]))
				{
					echo "<td><input type='checkbox' name='add[".$i."]' value=".$j." class='case' /></td>";
				}
				$k++;
			}
			if($permission[$k]=="1")
			{
				echo "<td><input type='checkbox' name='edit[".$i."]' value=".$j."  checked='checked'/></td>";
				$k++;
			}
			else
			{
				if(isset($permission[$k]))
				{
				echo "<td><input type='checkbox' name='edit[".$i."]' value=".$j."  /></td>";
				}
				$k++;
			}
			if($permission[$k]=="1")
			{
				echo "<td><input type='checkbox' name='delete[".$i."]' value=".$j."  checked='checked'/></td>";
				$k++;
			}
			else
			{
				if(isset($permission[$k]))
				{
					echo "<td><input type='checkbox' name='delete[".$i."]' value=".$j." /></td>";
				}
				$k++;
			}
			if($permission[$k]=="1")
			{
				
				echo "<td><input type='checkbox' name='view[".$i."]' value=".$j."  checked='checked'/></td>";
				$k++;
			}
			else 
			{
				if(isset($permission[$k]))
				{
				echo "<td><input type='checkbox' name='view[".$i."]' value=".$j."  /></td>";
				}
				$k++;
			}
				echo "</tr>";
		} 
		echo "<br/>";
		echo "<br/>";
		echo "<input type='button' value='Assign' onclick='assign()' />";
		echo "</form>";
		
		
		echo "</table>";
	}
	public function response (){
		if(isset($_SESSION['uname'])){
		require_once("../model/classes.faq.php");
		$postResponse=new faqResponse();
		$postResponse->setUsername($_SESSION['uname']);
		$postResponse->setResponse($_REQUEST['message']);
		$postResponse->setFaqid($_REQUEST['faqId']);
		if($postResponse->postResponse()){
			header("location:controller.php?method=faq");
		}
		else{
			echo '<script type="text/javascript">alert("Sorry Try Again"); </script>';
		}
	}
	else{
		  header("location:../view/register.php");
	     }
	}
    
    public function viewResultTeacher(){
        if(isset($_SESSION['uname'])){
            require_once("../model/classes.viewResult.php");
		$result = new result();
                $result->setUserName($_SESSION['uname']);
                $fetchResult = $result->viewTestId();
                if($fetchResult){
                    include("../view/viewResultTeacher.php");
                }
                else{
                    echo "No student has appeared for the test";
                }
        }
    }
    
    
    public function viewResult(){
        if(isset($_SESSION['uname'])){
            require_once("../model/classes.viewResult.php");
		$result = new result();
                $result->setUserName($_SESSION['uname']);
                $fetchResult = $result->viewResultStudent();
                if($fetchResult){
                 include("../view/viewResults.php");
                    
                }
                else{
                    echo "No marks available";
                }
        }
    }
    
    
    
      
        /* -----------------------------------------------------
	     Function called in case of forget password
	   -----------------------------------------------------
	*/
     public function check(){
         require_once ("../model/classes.login.php");
         $forgotPassword = new logIn();
         $forgotPassword->setUserType($_POST['utype']);
         $forgotPassword->setUserName($_POST['uname']);
         $found = $forgotPassword->checkUser();
         if($found){
             require("../model/class.phpmailer.php");
             $mail = new PHPMailer();
			
             
             $data=mysql_fetch_assoc($found);
             $password = ($data['password']);
             $to = ($data['email']);
             
             $message = '';
	     $message .= "Check your password" . "<br/>";
	     $message .= "Password For User Id :";
             $message .= $password;
	     	     	 
	     $mail->IsSMTP();
	     $mail->Mailer = "smtp";
	     $mail->Host = "ssl://smtp.gmail.com";
	     $mail->Port = 465;
	     $mail->SMTPAuth = true;
	     $mail->Username = "debanshuk@gmail.com";
	     $mail->Password = "1234debanshu";
			
	     $mail->From     = "Administrator";
	     $mail->AddAddress("kar.debanshu@gmail.com");
			
	     $mail->Subject  = "Check out your Password";
	     $mail->Body     = $message;
			
			
	     if(!$mail->Send()) {
		echo 'Message was not sent.';
                echo 'Mailer error: ' . $mail->ErrorInfo;
             }
             else {
		header("location:../index.php");
		}
         }   
         else{
             echo "Wrong Username";
         }
     }
    
    
        /* -----------------------------------------------------
	     Function for all questions
	   -----------------------------------------------------
	*/
    
	public function fetchAll(){
            if($_SESSION['uname']){
		//session_start();
                
		if($_SESSION['fetch']){
                    
                    	require_once("../model/classes.sampleTest.php");
			$sampletest = new sampleTest();
			$sampletest->setUserName($_SESSION['fetch'][0]['teacher_name']);
                        $get = $sampletest->getAll();
                        if($get){
                        	$_SESSION['get']=$get;
                            include("/var/www/Open/trunk/mvc/view/giveTest.php");
			}
                        
		}
            }
        else{
            header("location:../register");
        }
        }
	
	/* -----------------------------------------------------
	     Function for Set test
	   -----------------------------------------------------
	*/
	
	public function settest(){
		 
		if(isset($_POST) > 0){
			require_once("../model/classes.settest.php");
                        require_once("../model/classes.validation.php");
			$validate=new validate();
			$settest = new settest();
                        $max=$_REQUEST['noq'];
                        $negative=$_POST['negative'];
                        if($negative==0)
                        {
                            $negative=1;
                        }
                        //echo $max;
	if($validate->is_validInt($_POST['noofques'],1,$max) && $validate->is_validInt($_POST['time'],1,300) && $validate->is_validFloat($negative,0,1) && ($_POST ["email"]=$validate->is_validEmail($_POST ["email"]))){
			$settest->setTeacher_name($_SESSION['uname']);
			$settest->setTesttype($_POST['test']);
			$settest->setNo_of_questions($_POST['noofques']);
			$settest->setTime($_POST['time']);
			$settest->setNegativeMarking($_POST['negative']);
			$settest->setCategory_id($_POST['cat']);
			$settest->teacherId();
			$settest->saveTest();
			
			$link = $settest->generateLink();
			if ($link == TRUE) {
				$message = '';
				$message .= "Check Out The Link" . "<br/>";
				$message .= $link;
				$to = $_POST ["email"];
			
				require("../model/class.phpmailer.php");
				$mail = new PHPMailer();
				 
				$mail->IsSMTP();
				$mail->Mailer = "smtp";
				$mail->Host = "ssl://smtp.gmail.com";
				$mail->Port = 465;
				$mail->SMTPAuth = true;
				$mail->Username = "debanshuk@gmail.com";
				$mail->Password = "1234debanshu";
			
				$mail->From     = "Administrator";
				$mail->AddAddress($to);
			
				$mail->Subject  = "The Generated Link For The Test";
				$mail->Body     = $message;
			
			
				if(!$mail->Send()) {
					echo 'Message was not sent.';
					echo 'Mailer error: ' . $mail->ErrorInfo;
				}
				else {
					//echo '<script type="text/javascript">alert("Link send successfully"); </script>';
				    header('location:http://localhost/Open/trunk/mvc/view/view.php?flag=2&msg="succesful"');
				}
			}
			
			}
                        else{
                            header('location:http://localhost/Open/trunk/mvc/view/selecttest.php?cat=2&noq=4');
                        }
}
	}
	

	/* -----------------------------------------------------
	      Function for View Faq
	   -----------------------------------------------------
	*/
	
	public function faqResponse(){
		if(isset($_POST) > 0){
	        require_once("../model/classes.faq.php");
		 $faqResponse=new faqResponse();
		 //$faqResponse->$this->setUsername($_SESSION['uname']);
		 $question=$faqResponse->viewFaq();
		 if($question){
		 	include("../view/faq_response.php");
		 	}
		 
		 else{
		 	echo "No view available";
		 }
	}
	}
	
	/* -----------------------------------------------------
	    Function for category
	   -----------------------------------------------------
	*/
	public function faq(){
		if(isset($_POST) > 0){
			require_once("../model/classes.sampleTest.php");
			$sampletest = new sampleTest();
			$get=$sampletest->category();
			if($get){
				include("../view/faq.php");
			}
			
				
		}
	}
	
       /* -----------------------------------------------------
	    Function for Sample Paper
	  --------------------------------------------------------
	*/
	
	public function fetchPaper(){
		if(isset($_POST) > 0){
			require_once("../model/classes.sampleTest.php");
			$sampletest = new sampleTest();
            $sampletest->setCategory($_REQUEST['cid']);
			$fetch=$sampletest->retrieveQuestion();
                        if($fetch){
				include("/var/www/Open/trunk/mvc/view/samplepaper.php");
			}
		}
	}
	
	/* -----------------------------------------------------
	     Function for Teacher name
	   -----------------------------------------------------
	*/
	
	public function fetchTeacher(){
		
		if(isset($_POST) > 0){
			require_once("../model/classes.sampleTest.php");
			$sampletest = new sampleTest();
			$fetch=$sampletest->retrieveTeacher();
 			if($fetch){
 				include("/var/www/Open/trunk/mvc/view/paper.php");
 			}
 			else{
 				echo "No paper Available";
 			}
 		}
	}
	
	/* -----------------------------------------------------
	    Function for viewing Sample Test
	   -----------------------------------------------------
	*/
	
	public function sampleTest(){
		if(isset($_POST) > 0){
			require_once("../model/classes.sampleTest.php");
			$sampletest = new sampleTest();
			$view=$sampletest->category();
			if($view){
				include("../view/sample.php");
			}
			else{
			  echo "No category available";
			}
		}
	}
	
	/* -----------------------------------------------------
	      Function for Viewing Uploaded paper by teacher
	   -----------------------------------------------------
	*/    
    
	public function findpaper(){
	if(isset($_POST) > 0){
	    require_once("../model/classes.uploadpaper.php");
	    $upload = new upload();
        $upload->setUserName($_SESSION['uname']);
	    $get = $upload->viewUploadPaper();
       
        if ($get) {
		include("../view/settest.php");
	    }
	    else{
		echo "No View Available";
	    }
	}
    }
    
    
    /* --------------------------------------------------
          Function for Uploading Paper by teacher
       --------------------------------------------------
    */    
    
    public function upload(){
    	
	     if(isset($_POST) > 0){
			require_once("../model/classes.uploadpaper.php");
			$upload = new upload();
			    
			
			///////////////////////
			if($_FILES['userfile']['type'] == "text/csv"){
				$count = 0;
				if(isset($_POST['upload']) && $_FILES['userfile']['size'] > 0)
				{
					$fileName = $_FILES['userfile']['name'];
					$tmpName  = $_FILES['userfile']['tmp_name'];
					$fileSize = $_FILES['userfile']['size'];
					$fileType = $_FILES['userfile']['type'];
					$chk_ext = explode(",",$fileName);
						
					$handle = fopen($tmpName, "r");
			
					if(!$handle){
						die ('Cannot open file for reading');
							
					}
					while (($data = fgetcsv($handle, 10000, ",")) !== FALSE){
						$upload->setQuestionName($data[0]);
						$upload->setQuessetid($nQuesSetId);
						$upload->setOption( array ($data[1],$data[2],$data[3],$data[4]) );
						$upload->setAnswer($data[5]);
						$count ++;
					}
			
				}
			}
			echo $count;
			////////////////////////////////////
			
			
			if($count+1 == $_REQUEST['numbers']){
			
				if ($nQuesSetId!="0"){
				if($_FILES['userfile']['type'] == "text/csv"){
		        if(isset($_POST['upload']) && $_FILES['userfile']['size'] > 0)
                       {
                        $fileName = $_FILES['userfile']['name'];
                        $tmpName  = $_FILES['userfile']['tmp_name'];
                        $fileSize = $_FILES['userfile']['size'];
                        $fileType = $_FILES['userfile']['type'];
                        $chk_ext = explode(",",$fileName);
                       
                       $handle = fopen($tmpName, "r");
                       
                         if(!$handle){
                          die ('Cannot open file for reading');
                        }      
                  while (($data = fgetcsv($handle, 10000, ",")) !== FALSE){
				    $upload->setQuestionName($data[0]);
				    $upload->setQuessetid($nQuesSetId);
				    $upload->setOption( array ($data[1],$data[2],$data[3],$data[4]) );
				    $upload->setAnswer($data[5]);
				    
				    			   			    
				    if($upload->uploadQuestionAnswer())
				    {
			               	    	    
				    }
				    else{
				    header("location:../view/view.php?flag=2&error='sorry'");
			       }
			       
				
			    }
			    header("location:../view/view.php?flag=2&msg='Uploaded'");
              
                        fclose($handle);                  
                    }
			   }
			   else{
			   	header("location:../view/view.php?flag=2&error='Sorry'");
			   }
			}
			else{
		         header("location:../view/view.php?flag=2&error='sorry'");
			}
			
			}
			else{
				header("location:../view/view.php?flag=2&upload=1&error='sorry'");
			}
		    }
        }

    

/* -------------------------------------------------------------------------------
    Function for viewing profile called from header_student.php/header_teacher.php
   -------------------------------------------------------------------------------
 */
    
    public function update() {
        if (isset($_POST) > 0) {
            require_once("../model/classes.profileupdate.php");
            $obj = new ProfileUpdate();

        
            $obj->setUserName($_SESSION['uname']);
            
            $get = $obj->RetrieveInformation();
            if ($get) {
                include ( "../view/profile.php" );
            } 
            
            
    }
    }

    
/* ------------------------------------------------------------
    Function for updateprofile called from profile.php 
   ------------------------------------------------------------
*/
    
    public function updateprofile() {
    	if(isset ($_POST['submit'])){
            
            require_once("../model/classes.validation.php");
    		require_once("../model/classes.profileupdate.php");
    		$obj = new ProfileUpdate();
    		
                $Validation = new validate();
                //session_unset("msgErrors");
                $_SESSION["msgErrors"] = array();
                
                
        if($Validation->is_validName($_POST["f_name"]) && $Validation->is_validEmail($_POST["email"]) && $Validation->is_validPhone($_POST["phone"])){  
            
        	$obj->setUserName($_SESSION['uname']);
    		$obj->setFirstName($_REQUEST['f_name']);
    		$obj->setLastName ($_REQUEST['l_name']);
    		$obj->setAddress ($Validation->is_validAddress($_POST["address"]));
            $obj->setPhoneNo ($_REQUEST['phone']);
    		$obj->setEmail ($_REQUEST['email']);
    		$obj->setCollegeOrCompanyName($_REQUEST['cname']);
    		
    		$get = ($obj->UpdateProfile());
    		
    		if ($get) {
    			header("location:controller.php?method=update");
    		}
            }
                else {
                  header("location:controller.php?method=update");
    		}
    	}
    }

    
/* ------------------------------------------------------------
    Function for change password called from changepassword.php 
   ------------------------------------------------------------
*/
    
    public function changePassword() {
        if(isset ($_SESSION['uname'])) {
        	
            require_once("../model/classes.validation.php");
            require_once("../model/classes.changepassword.php");
            
            $Validation = new validate();
            //session_unset("msgErrors");
            $_SESSION["msgErrors"] = array();
            
            $changePassword = new ChangePassword();
            
            $changePassword->setPassword($_POST["pwd"]);
            $changePassword->setUserName($_SESSION['uname']);
            $get = $changePassword->CheckCurrentPassword();
            if ($get) {
            	
              if($Validation->is_validPassword($_POST["new_pwd"])){

                 $changePassword->setPassword($_POST["new_pwd"]);
                 if ($changePassword->UpdatePassword()) {
                     header("location:http://localhost/Open/trunk/mvc/user/changepassword/msg1/'Password Changed'");
                 }
              }
               else{
               	header("location:http://localhost/Open/trunk/mvc/view/changepassword.php");
               }
            }
            else{
                //echo "hi";die;
            	header("location:http://localhost/Open/trunk/mvc/user/changepassword/msg/'Wrong Entry'");
            }
        } 
        
    }
    

/* ----------------------------------------------------------
    Function for sending feedback called from ** index.php **
   ----------------------------------------------------------
*/

public function feedback() {
       if (isset($_POST)) {
           
       	   require_once("../model/classes.validation.php");
           require_once("../model/classes.feedback.php");
           $feedback = new feedback();
           $Validation = new validate();
           
           session_unset("msgErrors");
           $_SESSION["msgErrors"] = array();
           if($Validation->is_validName($_POST["name"]) && $Validation->is_validEmail($_POST["email"])){
           
           $feedback->setFeedback($_POST["message"]);
           $feedback->setEmail($_POST["email"]);
           $feedback->setName($_POST["name"]);
         
           if (($feedback->AddFeedback())) {
              header("location:..?msg='Inserted'");
               }
           }
           else{
            header("location:..");
           }
       }
   }
   
    
/* -----------------------
    Function for login
   -----------------------
 */
 public function login() {
      

        if (isset($_POST) && count($_POST) > 0) {
            
            require_once ("../model/classes.login.php");
            $login = new logIn();
            $login->setUserName($_POST ["u_name"]);
            $login->setPassword($_POST ["pwd"]);
            $find = $login->FindUsers();
           
            if ($find) {
              
                $result = array();
                $result = $find;
              
            
              
                if ($result [0]['user_type'] == 2 && $_POST ['user_type'] == "teacher") {
                     $_SESSION ['uname'] = $_POST ["u_name"];
                  header("location:http://localhost/Open/trunk/mvc/user/2");
                  }
                else if ($result [0]['user_type'] == 3 && $_POST ['user_type'] == "student") {
                     $_SESSION ['uname'] = $_POST ["u_name"];
                    header("location:http://localhost/Open/trunk/mvc/user/3");
                   
                }
                else if ($result [0]['user_type'] == 3 && $_POST ['type'] == "test") {
                     $_SESSION ['uname'] = $_POST ["u_name"];
                    header("location:../view/testInstructions.php");
                }
                else {
                    if($_POST ['user_type'] == "student"){
                   header ( "location:http://localhost/Open/trunk/mvc/studentlogin" );}
                  
                   else if($_POST ['user_type'] == "teacher"){
                       
                     header ( "location:http://localhost/Open/trunk/mvc/teacherlogin" );}
           
                   }
           
                }
           
        else {
            if ($_POST ['type'] == "test") {

                      $url=$_REQUEST['url'];
            header("location:".$url);
   
                     }
                     else
            header ("location:http://localhost/Open/trunk/mvc/mainpage.php" );
        }
        }
        else{
            if($_POST ['type'] == "test"){
            $url=$_REQUEST['url'];
            header("location:".$url);
            }
           
        }
    }
/* --------------------------------------------------------------
    Function to check whether a username exixts or not
   --------------------------------------------------------------
 */
   
    public function checkUser() {
    	
        if (isset($_POST) && count($_POST) > 0) {
        	require_once("../model/gettersettermodel.php");
            $check = new Register();
            $check->setUserName($_POST ["u_name"]);
            $get=$check->checkUnique();
           
            if($get){
                echo "User name already exists";
            }
            else{
                echo "<img src='http://localhost/Open/trunk/mvc/images/check.jpg' height='30px' width='30px'>";
            }
        
       }
   }
 
    
    
/* --------------------------------------------------------------
    Function for registering a new user called from register.html
   --------------------------------------------------------------
 */
   
    public function user_register() {
        if (isset($_POST) && count($_POST)) {
            
           require_once("../model/classes.validation.php");
           require_once("../model/gettersettermodel.php");
            $Validation = new validate();
            session_unset("msgErrors");
            
            $obj = new Register();
            $token = mt_rand();
            $_SESSION["msgErrors"] = array();
           
           if($Validation->is_validName($_POST["last"]) && $Validation->is_validName($_POST["first"]) && $Validation->is_validEmail($_POST["email"]) && $Validation->is_validPhone($_POST["phone"])){
            $obj->setUserName($_POST ["u_name"]);
            $obj->setPassword($token);
            $obj->setFirstName($_POST ["first"]);
            $obj->setLastName($_POST ["last"]);
            $obj->setAddress($_POST ["address"]);
            $obj->setEmail($_POST ["email"]);
            $obj->setPhoneNo($_POST ["phone"]);
            $obj->setName($_POST ["cname"]);
            $obj->setGender($_POST ["gender"]);
            $obj->setUserType($_POST ["utype"]);
          
            if ($obj->RegisterUser() == TRUE) {
                $message = '';
                $message .= "Thank you for registering here is your userid and password" . "<br/>";
                $message .= "UserId :" .$_POST ["u_name"]."<br/>";
                $message .= "Password :" .$token;
                $to = $_POST ["email"];
                
                require("../model/class.phpmailer.php");
                $mail = new PHPMailer();  
                 
                $mail->IsSMTP();
                $mail->Mailer = "smtp";
                $mail->Host = "ssl://smtp.gmail.com";
                $mail->Port = 465;
                $mail->SMTPAuth = true;
                $mail->Username = "debanshuk@gmail.com";
                $mail->Password = "1234debanshu"; 
 
                $mail->From     = "Administrator";
                $mail->AddAddress($to);  
 
                $mail->Subject  = "Login Id and Password";
                $mail->Body     = $message;
  
 
                if($mail->Send()){
                   header("location:../index.php");
                 }
                 else{
                     echo "mail cant be send";
                 }
                 }
                 else{
                     header("location:../view/register.php?msg='Matching User Name'");
                 }
               
             }
                else{
                    header("location:../view/register.php");                   
                } 
             } 
        }    
    
    /* ------------------------------------
        Function to start test
       ------------------------------------
    */
    
        
    public function startTest(){
    	  
    	  require_once("../model/classes.starttest.php");
    	  $startTest=new starttest();
    	  $startTest->setTestId(base64_decode($_REQUEST['testid']));
    	 $b= $startTest->fetchTestInfo();
          
    	  $a=$startTest->sample_question();
          $_SESSION['test']=$a;
          $_SESSION['test1']=$b;
       
          $start=0;
    	  include('../view/studentInfo.php');
    	  
    }
    
    
       public function result(){
    	require_once("../model/classes.result.php");
    	if(isset($_SESSION['uname'])){
    	$result=new result();
    	$a=$_SESSION['test1'];
        $result->setTest_id($_SESSION['test1']['id']);
        $result->setNoOfQuestions($_SESSION['test1']['no_of_questions']);
        $result->setStudent_id($_SESSION['uname']);
    
        $correctAnswers=array();
        $a=$_SESSION['test'];
     
foreach($a as $key=>$values)
    $correctAnswers[]=$a[$key]['answer'];
$result->setCorrectAns($correctAnswers);

if(!empty ($_POST['result']))
$chosenAnswers=explode(',', $_POST['result']);
else
    $chosenAnswers=array();
$result->setChosenAns($chosenAnswers);
$negativeMarking=$_SESSION['test1']['negative_marking'];
$result->calculatemarks($negativeMarking);
$result->saveResult();
include("../view/result.php");
    }else{
       	header ('location:http://localhost/Open/trunk/mvc/mainpage.php');
       }
       }


}

$request = "";
if (isset($_GET["method"])) {

    $request = $_GET["method"];
}

$obj = new MyClass();

if (!empty($request)) {
    $obj->$request();
}
?>
