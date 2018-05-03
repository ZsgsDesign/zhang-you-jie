<?php

/*if(arg("TIMESTAMP") && arg("SECURE_VALUE")){
	if(sha1(md5(arg("TIMESTAMP")).getConfig('INFINI_SALT'))!=arg("SECURE_VALUE")) ERR::Catcher(1001);
}else{
	ERR::Catcher(1003);
}*/

class ApiController extends BaseController {
	

	function actionAccountLogin() {
		if(arg("email") && arg("password")){
			//$ext = explode('@', arg("email"))[1];
			//if($ext!=getConfig('TOAST_EMAIL_DOMAIN')) ERR::Catcher(2006);
			$db=new Model("user");
			$OPENID=sha1(strtolower(arg("email")).getConfig('INFINI_SALT').arg("password"));
			$result=$db->find(array("OPENID=:OPENID",":OPENID"=>$OPENID)); //In case of identical hash value 
			if($result) {
				$output=array(
					 'ret' => 200,
					'desc' => "Succeed",
					'data' => $result
				);
			} else {
				ERR::Catcher(2002);
			}
		} else {
			ERR::Catcher(1003);
		}
		echo json_encode($output); 
	}
	
	function actionVerifyLogin() {
		if(arg("OPENID")){
			$db=new Model("user");
			$result=$db->find(array("OPENID=:OPENID",":OPENID"=>arg("OPENID")));
			if($result) {
				$output=array(
					 'ret' => 200,
					'desc' => "Succeed",
					'data' => $result
				);
			} else {
				ERR::Catcher(2007);
			}
		} else {
			ERR::Catcher(1003);
		}
		echo json_encode($output); 
	}
	
	function actionGetFriendInfo() {
		if(arg("OPENID")){
			$db=new Model("user");
			$bind_id=$db->find(array("OPENID=:OPENID",":OPENID"=>arg("OPENID")));
			$bind_id=$bind_id["bind_uid"];
			if($bind_id) {
			    $result=$db->find(array("uid=:bind_id",":bind_id"=>$bind_id));
				$output=array(
					 'ret' => 200,
					'desc' => "Succeed",
					'data' => $result
				);
			} else {
				ERR::Catcher(1002);
			}
		} else {
			ERR::Catcher(1003);
		}
		echo json_encode($output); 
	}

	function actionAccountRegister() {
		if(arg("email") && arg("password")){
			$db=new Model("user");
			$result=$db->find(array("email=:email",":email"=>arg("email")));
			if($result) {
				ERR::Catcher(2003);
			} else {
				$newrow = array(
					'email' => strtolower(arg("email")),
					'OPENID' => sha1(strtolower(arg("email")).getConfig('INFINI_SALT').arg("password")),
				);
				$result=$db->create($newrow);  
				if($result) {
					$result=$db->find(array("email=:email",":email"=>arg("email")));
					$output=array(
						 'ret' => 200,
						'desc' => "Succeed",
						'data' => $result
					);					
				} else {
					ERR::Catcher(1002); 
				}
			}
		} else {
			ERR::Catcher(1003);
		}
		echo json_encode($output); 
	}

	function actionAccountChangePassword() {
		if(arg("OPENID") && arg("password")) {
			$db=new Model("user");
			$email=$db->find(array("OPENID=:OPENID",":OPENID"=>arg("OPENID")));
			$email=strtolower($email['email']);
			if($email) {
				$result=$db->update(array("OPENID=:OPENID",":OPENID"=>arg("OPENID")), array('OPENID'=>sha1(strtolower($email.getConfig('INFINI_SALT').arg("password")))));
				if($result) {
					$output=array(
						'ret' => 200,
						'desc' => "Succeed",
						'data' => array(
							'result'=>$result
						)
					);
				} else {
					ERR::Catcher(1002);
				}
			} else {
				ERR::Catcher(1002);
			}
		} else {
			ERR::Catcher(1003);
		}
		echo json_encode($output); 
	}
	
	function actionAccountUpdate() {
		if(arg("OPENID") && arg("gender") && arg("real_name")) {
			$db=new Model("user");
			$result=$db->update(array("OPENID=:OPENID",":OPENID"=>arg("OPENID")), array('gender'=>arg("gender"),'real_name'=>arg("real_name")));
			if($result) {
				$output=array(
					'ret' => 200,
					'desc' => "Succeed",
					'data' => array(
						'result'=>$result
					)
				);
			} else {
				ERR::Catcher(1002);
			}
		} else {
			ERR::Catcher(1003);
		}
		echo json_encode($output); 
	}

	function actionGetDiaries() {
		if(arg("uid") && arg("pages")>=0){
			$db=new Model("diary");
			$result=$db->findAll(array("uid=:uid",":uid"=>arg("uid")), " timestamp DESC  ", "*", intval(arg("pages"))." , 10 ");
			if($result) {
				$output=array(
					'ret' => 200,
				   'desc' => "Succeed",
				   'data' => $result
				);
				//No pagination here, futher development is required
			} else {  
				ERR::Catcher(3001);
			}
		} else {
			ERR::Catcher(1003);
		}
		echo json_encode($output); 
	}
	
	function actionGetDiaryDetail() {
		if(arg("uid") && arg("did")){
			$db=new Model("diary");
			$result=$db->find(array("did=:did",":did"=>arg("did")));
			if($result) {
				$output=array(
					'ret' => 200,
				   'desc' => "Succeed",
				   'data' => $result
				);
				//Hurry up
			} else {  
				ERR::Catcher(3001);
			}
		} else {
			ERR::Catcher(1003);
		}
		echo json_encode($output); 
	}

	function actionAccountDogeMode() {
		if(arg("OPENID")) {
			$db=new Model("user");
			$result=$db->update(array("OPENID=:OPENID",":OPENID"=>arg("OPENID")), array('bind_uid'=>2,'bind_date'=>date('Y-m-d H:i:s')));
			if($result) {
				$output=array(
					'ret' => 200,
					'desc' => "Succeed",
					'data' => array(
						'result'=>$result
					)
				);
			} else {
				ERR::Catcher(1002);
			}
		} else {
			ERR::Catcher(1003);
		}
		echo json_encode($output); 
	}
	
	function actionAccounBind() {
		if(arg("OPENID") && arg("uid") && arg("secure_bind")) {
		    
			$db=new Model("user");
			$minStamp=intval(intval(time())/60);
			
			$hash=md5($minStamp."0".arg("uid"));
			if($hash==arg("secure_bind")){
			    $myuid=$db->find(array("OPENID=:OPENID",":OPENID"=>arg("OPENID")));
			    $myuid=$myuid["uid"];
    			$result=$db->update(array("uid=:uid",":uid"=>$myuid), array('bind_uid'=>arg("uid"),'bind_date'=>date('Y-m-d H:i:s')));
    			$result=$db->update(array("uid=:uid",":uid"=>arg("uid")), array('bind_uid'=>$myuid,'bind_date'=>date('Y-m-d H:i:s')));
    			//这块逻辑还不完整，千万不要尝试这部分功能！
    			if($result) {
    				$output=array(
    					'ret' => 200,
    					'desc' => "Succeed",
    					'data' => array(
    						'result'=>$result
    					)
    				);
    			} else {
    				ERR::Catcher(1002);
    			}
			}else{
			    ERR::Catcher(1003);
			}
			
		} else {
			ERR::Catcher(1003);
		}
		echo json_encode($output); 
	}
	
	function actionGetBindCode() {
		if(arg("OPENID") && arg("minStamp")) {
			$db=new Model("user");
			$result=$db->find(array("OPENID=:OPENID",":OPENID"=>arg("OPENID")));
			if($result) {
				$output=array(
					'ret' => 200,
					'desc' => "Succeed",
					'data' => array(
						'code'=>"infini://".sha1($result["uid"].minStamp)."|".$result["uid"]
					)
				);
			} else {
				ERR::Catcher(1002);
			}
		} else {
			ERR::Catcher(1003);
		}
		echo json_encode($output); 
	}

}

