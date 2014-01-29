<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Contains Commonfunction Model database queries
 
* @Created on October 24, 2012

* @Updated on October 24, 2012

* @Package: Nauction Platinum Version 1.0

* @Author: NDOT Team

* @URL : http://www.ndot.in

 * Query function used are,
 * ** insert
 * ** select_with_onecondition
 * ** select_all
 * ** selectwhere
 * ** login
 * ** update
 */

class Model_Commonfunctions extends Model {

	/**
	* ****__construct()****
	*
	* setting up session variables and request for url redirect
	*/
        public function __construct()
        {	
       		$this->session = Session::instance();	
		$this->url=Request::current();
		$this->getCurrentTimeStamp=Commonfunction::getCurrentTimeStamp();
	}

	/** Common insert function can be used for all **/
	public function insert($table,$arr)
	{
		
			$result=  DB::insert($table,array_keys($arr))->values(array_values($arr))
			     ->execute();
			return $result;
		
	}
	
	public function mod_install($table,$arr)
	{
		$sql="select count(*) as c from $table where typename='$arr[typename]'";
		
		$result1=Db::query(Database::SELECT, $sql)
		        -> execute()
			-> as_array();
		$count=$result1[0]['c'];
		if($count==0)
		{
			$result=  DB::insert($table,array_keys($arr))->values(array_values($arr))
			     ->execute();
			return $result;
		}
		else
		{
			$sql1="update $table set status='A' where typename='$arr[typename]'";
			$result=Db::query(Database::UPDATE,$sql1)
			     ->execute();
			     return $result;
		}
	}

	/** 
	* Create where condition for query, based on parameter $condition
	* Eg: $arr = array(username=>'smith',password='123456')
	* returns  username = 'smith' AND password = '123456'
	**/
	public function split_for_where($arr,$condition="AND")
	{
		//Fetch Keys in array			
		$keys= array_keys($arr);
	
		//Fetch Values in array
		$values=array_values($arr);

		$output="";
		for($i=0; $i< count($keys);$i++)
		{
			// Prints for e.g: Keys = 'values' ,
			$output.= $keys[$i]."="."'".$values[$i]."',";
		}
		return str_replace(","," ".$condition." ",substr($output, 0, -1));
	}

	/** 
	* Select a rows with particular one condition
	* @param $table=tablename, $cond=condition for where query
	* @returns array
	**/
	public function select_with_onecondition($table,$cond="",$need_count=FALSE)
	{
	        $cond = ($cond !="")?$cond:"1=1 ";
		$query=DB::query(Database::SELECT,"select * from ".$table." where ".$cond)->execute();
		if($need_count)
		{
			return count($query);
		}
		else
		{
			return $query;
		}
		
	}
	
	/** 
	* Select a rows with particular one condition
	* @param $table=tablename, $cond=condition for where query
	* @returns array
	**/
	public function select_with_onecondition2($table,$cond="",$need_count=FALSE)
	{
	        $cond = ($cond !="")?$cond:"1=1 ";
		$query=DB::query(Database::SELECT,"select * from ".$table." where ".$cond)->execute()->current();
		if($need_count)
		{
			return count($query);
		}
		else
		{
			return $query;
		}
		
	}
	
	/** 
	* Select all rows 
	* @param $table=tablename
	* @returns array
	**/
	public function select_all($table)
	{
		$query=DB::query(Database::SELECT,"select * from ".$table)->execute();
		return $query;
	}
	
	/** 
	* Select rows with where in query
	* @param $table=tablename
	* @param $arr="field name and values for where in associative array"
	* @param $condition ="AND or OR" (Either one will be used)
	* @param $need_count ="TRUE or FALSE"
	* @returns array when need_count = false
	* @return count values when need_count=true
	**/
	public function selectwhere($table,$arr,$condition="AND",$need_count=FALSE)
	{
		$value= $this->split_for_where($arr,$condition);
		$query=DB::query(Database::SELECT,"select * from ".$table." where ".$value)->execute();
		if($need_count)
		{
			return count($query);
		}
		else
		{
			return $query;
		}
	}
	
	/** 
	* Login function common
	* @param $table=tablename
	* @param $arr="field name and values for where in associative array"
	* @param $rem ="1" ,Default is NULL
	* @returns TRUE or FALSE when query count>0
	**/
	public function login($table,$arr,$rem="")
	{
		$value= $this->split_for_where($arr,"AND");
		$query=DB::query(Database::SELECT, "select id,username,usertype,status from ".$table." where ".$value." AND status!='".DELETED_STATUS."'")->execute();
		if(count($query)>0)
		{
			
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}
	
	/** 
	* Update function common
	* @param $table=tablename
	* @param $arr="field name and values for where in associative array"
	* @param $cond1, $cond2 for where
	* @returns array
	**/
	public function update($table,$arr,$cond1,$cond2)
	{
		$query=DB::update($table)->set($arr)->where($cond1,'=',$cond2)->execute();
		return $query;
	}

        //Delete for User online 
	public function delete_useronline($table,$cond1,$cond2)
	{
		$query=DB::delete($table)->where($cond1,'=',$cond2)->execute();
		return $query;
	}
	
	
	public function delete($table,$cond1,$cond2)
	{
		$query=DB::delete($table)->where($cond1,'=',$cond2)->execute();
		return $query;
	}
	
	public function makeinactive($table,$cond1,$cond2)
	{
		$sql="update $table set status='I' where $cond1=$cond2";
		$result=Db::query(Database::UPDATE, $sql)
			->execute();
			
		return $result;
	}
	
	public function checkactiv($id)
	{
		$sql="select count(*) as active from auction_products where auction_type=$id and startdate<=CURDATE() and enddate>=CURDATE()";
		
		$result=Db::query(Database::SELECT, $sql)
		        -> execute()
			-> as_array();
			
		return $result;	
	}

}//End commonfunctions model
?>
