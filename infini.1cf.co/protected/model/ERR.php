<?php

class ERR {
	
	/**
	 * An old-fashioned error catcher mainly to provide error description
	 * existed here only to avoid direct SQL database access
	 * return a hundred present pure string
	 *
	 * @author John Zhang
	 * @param string $ERR_CODE
	 */

	public static function Catcher($ERR_CODE)
	{
		if(($ERR_CODE<1000)) $ERR_CODE=1000;
		$output=array(
			 'ret' => $ERR_CODE,
			'desc' => self::Desc($ERR_CODE),
			'data' => null
		);
		exit(json_encode($output));
	}
	 
	private static function Desc($ERR_CODE)
	{
		$ERR_DESC=array(
			'1000' => "Unspecified Error",
			'1001' => "Internal Sever Error : SECURE_VALUE invalid",
			'1002' => "Internal Database Error : Attemption unsuccessful",
			'1003' => "Internal Sever Error : Param deflection",
			'2000' => "Account-Related Error",
			'2001' => "Wechat account not binded yet",
			'2002' => "Password incorrect",
			'2003' => "Email address already taken",
			'2004' => "Password identical",
			'2005' => "Email profile empty",
			'2006' => "Email Domain illegal",
			'2007' => "Login illegal",
			'3000' => "Project-Related Error",
			'3001' => "No project involved",
			'3002' => "Project Not Found",
			'3003' => "Project Not Authoried",
			'3004' => "Authorization Failure",
			'3005' => "Task Not Found",
			'3006' => "No man involved",
			'3007' => "Already not a participant",
			'3008' => "Already a participant",
		);
		return isset($ERR_DESC[$ERR_CODE])?$ERR_DESC[$ERR_CODE]:$ERR_DESC['1000'];
	}

}
