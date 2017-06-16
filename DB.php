<?php
class DB {
	  static private $_instance = null;
      static public function getInstance () {
	      	if (!(self::$_instance instanceof self)) {
				self::$_instance = new self();
			}
			return self::$_instance;
      }
      private function __construct () {
              mysql_connect('127.0.0.1','root','');
              mysql_select_db('phpmailer');
              mysql_set_charset('utf-8');

      }
      public function add  ($_tables,Array $_addData) {
      	   $_addFields=array();
      	   $_addValues =array();
      	   foreach ($_addData as $k=>$v) {
                  $_addFields[]=$k;
                  $_addValues[] =$v;
      	   }
      	   $_addFields = implode(',', $_addFields);
		   $_addValues = implode("','", $_addValues);
		   $_sql = "INSERT INTO $_tables ($_addFields) VALUES ('$_addValues')";
		   return mysql_query($_sql) or die('添加数据报错:'.mysql_error());
      }
      public  function update ($_tables,Array $_param,Array $_updateData) {
      	  $_where = $_setData = '';
      	  foreach($_param as $key=>$val){
      	  	    $_where.=$key.'='.$val.' AND';
      	  }
      	  $_where = 'WHERE '.substr($_where, 0, -4);
      	  foreach ($_updateData as $_key=>$_value) {
			$_setData .= "$_key='$_value',";
		 }
		$_setData = substr($_setData, 0, -1);
        $_sql="update $_tables set $_setData $_where";
      	return mysql_query($_sql);
      }
}
?>