<?php
class __SMARTLIB_EXT{

	 static public $ext_admin_object;
   static public $project;

	static function init($smart_lib_project){

			self::$project = $smart_lib_project;


		//assign extend admin object (Smart_Extend_Project_Admin) through Smart_Project_Base and Smart_Project_Admin_Utils class
		self::$ext_admin_object = self::$project->obj_admin_utils->extend_project_admin;

	}
	static function extended_user_social_fields(){

		 self::$ext_admin_object = self::$project->obj_admin_utils->extend_project_admin;
     return self::$ext_admin_object->extened_user_social_fields();
  }
}
