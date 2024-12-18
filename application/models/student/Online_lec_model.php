<?php
class Online_lec_Model extends CI_Model{
	
	private $Date            = '' ;
	private $Encryptkey      = '' ;
	private $Token      	 = '' ;
	
	function __construct()
	{
		parent::__construct();
		$this->Date       = date('Y-m-d H:i:s');
		$this->Encryptkey = $this->config->item('encryption_key');
		$this->Token      = $this->get_token();
	}

	////////get_token
	private function get_token()
	{
		$this->Token            = md5($this->Encryptkey.uniqid(mt_rand()).microtime()) ;
		return	$this->Token ; 
	}

	////////get_token
	public function get_Deps()
	{
		$this->db->select('*');
		$this->db->from('online_lec_deps');
		$this->db->order_by('RoleNum', 'desc');

		$ResultDeps = $this->db->get();
		$NumRowResultDeps  = $ResultDeps->num_rows() ;
		if($NumRowResultDeps != 0)
		{
			$ReturnDeps = $ResultDeps ->result() ;
			return $ReturnDeps ;
		}
		else
		{
			return $NumRowResultDeps ;
		}
	}
////////get_token
	public function get_Deps_emp($EmpID = 0 )
	{
		$query = $this->db->query("SELECT * FROM online_lec_deps	 WHERE RowLevelID = 0 OR RowLevelID IN(SELECT RowLevelID FROM class_table WHERE EmpID = '".$EmpID."' )AND IsActive = 1  GROUP BY ID   ")->result();
		if(sizeof($query)>0){return $query ;}else{return FALSE ; }
	}

	public function check_emp_per($EmpID = 0  , $DepID = 0 )
	{
		$query = $this->db->query("SELECT ID FROM online_lec_dep_admin  WHERE AdminID = '".$EmpID."' AND DepID = '".$DepID."' ")->num_rows();
		return $query ;
	}
	public function get_Deps_student($StudentID = 0 )
	{
		$query = $this->db->query("SELECT * FROM online_lec_deps	 WHERE RowLevelID = 0 OR RowLevelID = (SELECT R_L_ID FROM student WHERE Contact_ID = '".$StudentID."' ) AND IsActive = 1   GROUP BY ID  ")->result();
		if(sizeof($query)>0){return $query ;}else{return FALSE ; }
	}
	////////get_token
	public function get_last_article($DepID)
	{
		$this->db->select('online_lec_dep_articles.ID AS ArticleID , online_lec_dep_articles.Title AS ArticleTitle , online_lec_dep_articles.Token AS ArticleToken ,
			online_lec_dep_articles.DateSTM AS ArticleDate ,contact.Name AS AutherName
			');
		$this->db->from('online_lec_dep_articles');
		$this->db->join('contact', 'contact.ID = online_lec_dep_articles.ContactID');
		$this->db->where('online_lec_dep_articles.DepID', $DepID);
		$this->db->order_by('online_lec_dep_articles.DateSTM', 'asc');
		$this->db->limit(1);
		
		$ResultDepArts = $this->db->get();			
		$NumRowResultDepArts  = $ResultDepArts->num_rows() ; 
		if($NumRowResultDepArts != 0)
		{
			$ReturnDeps = $ResultDepArts ->row_array() ;
			return $ReturnDeps ;
		}
		else
		{
			return $NumRowResultDepArts ;
		}
	}

	////////get_token
	public function get_dep_articles_num($DepID)
	{
		$this->db->select('*');
		$this->db->from('online_lec_dep_articles');
		$this->db->where('DepID', $DepID);
		
		$ResultDepArts = $this->db->get();			
		$NumRowResultDepArts  = $ResultDepArts->num_rows() ; 
		return $NumRowResultDepArts ;
	}

	////////get_token
	public function get_articles_comments_num($DepID)
	{
		$this->db->select('online_lec_dep_articles.ID AS ArticleID , online_lec_dep_articles_comments.ID AS CommentID');
		$this->db->from('online_lec_dep_articles');
		$this->db->join('online_lec_dep_articles_comments', 'online_lec_dep_articles_comments.ArticleID = online_lec_dep_articles.ID');
		$this->db->where('online_lec_dep_articles.DepID', $DepID);
		
		$ResultDepArts = $this->db->get();			
		$NumRowResultDepArts  = $ResultDepArts->num_rows() ; 
		return $NumRowResultDepArts ;
	}
	public function get_comment($Token = NULL)
	{
		$query = $this->db->query("
			SELECT
			online_lec_dep_articles_comments.ID ,
			online_lec_dep_articles_comments.ArticleID ,
			online_lec_dep_articles_comments.DateSTM ,
			online_lec_dep_articles_comments.Title ,
			online_lec_dep_articles_comments.Txt ,
			online_lec_dep_articles_comments.IsActive ,
			contact.Name
			FROM
			online_lec_dep_articles_comments
			INNER JOIN contact ON online_lec_dep_articles_comments.ContactID = contact.ID
			INNER JOIN online_lec_dep_articles ON online_lec_dep_articles_comments.ArticleID = online_lec_dep_articles.ID
			WHERE
			online_lec_dep_articles_comments.IsActive = 1 AND
			online_lec_dep_articles.Token = '".$Token."'
			ORDER BY online_lec_dep_articles_comments.ID DESC
			")->result();
		if(sizeof($query)>0){return $query ;}else{return FALSE ; }

	}

	public function comment_not_active()
	{
		$query = $this->db->query("
			SELECT
			online_lec_dep_articles_comments.ID  AS ComID ,
			online_lec_dep_articles_comments.ArticleID ,
			online_lec_dep_articles_comments.DateSTM ,
			online_lec_dep_articles_comments.Title ,
			online_lec_dep_articles_comments.Txt ,
			online_lec_dep_articles.Title AS ArticlesTitle ,
			online_lec_deps.Name AS DepsName ,
			contact.Name
			FROM
			online_lec_dep_articles_comments
			INNER JOIN online_lec_dep_articles ON online_lec_dep_articles_comments.ArticleID = online_lec_dep_articles.ID
			INNER JOIN online_lec_deps ON online_lec_dep_articles.DepID = online_lec_deps.ID
			INNER JOIN contact ON online_lec_dep_articles_comments.ContactID = contact.ID
			WHERE
			online_lec_dep_articles_comments.IsActive = 0
			ORDER BY online_lec_dep_articles_comments.ID DESC
			")->result();
		if(sizeof($query)>0){return $query ;}else{return FALSE ; }

	}
	public function active_comment($ID = 0 )
	{
		$this->db->query("UPDATE online_lec_dep_articles_comments SET IsActive = 1 WHERE ID ='".$ID."' ");
		return true ;
	}
	/////////////////////////////add_comment
	public function add_comment($data = array())
	{
		$DataInsert = array(
			'ContactID'=> $data['ContactID'],
			'ArticleID'=> $data['ArticleID'],
			'Title	'=> '',
			'Txt'=> $data['comment'],
			'Token'=> $this->Token,
			'IsActive'=> $data['IsActive'],
			'DateInsert'=> $this->Date
		);
		$this->db->insert('online_lec_dep_articles_comments',$DataInsert);
		return TRUE ;
	}
	////////get_token
	public function get_dep_Admin($DepID)
	{
		$this->db->select('*');
		$this->db->from('online_lec_dep_admin');
		$this->db->where('DepID', $DepID);
		$this->db->where('IsActive', 1);
		
		$ResultDepAdmin = $this->db->get();			
		$NumRowResultDepAdmin  = $ResultDepAdmin->num_rows() ; 
		if($NumRowResultDepAdmin != 0)
		{
			$ReturnDepAdmin = $ResultDepAdmin->row_array() ;
			return $ReturnDepAdmin ;
		}
		else
		{
			return $NumRowResultDepAdmin ;
		}
	}
	
	////////Add Dep
	public function DepAdmin($data)
	{
		extract($data);
		if($CurAdminID == 0)
		{
			$DataInsert = array("DepID" =>$DepID ,"AdminID" =>$DepAdminID , "IsActive" => 1);
			$this->db->insert('online_lec_dep_admin',$DataInsert);
			return TRUE ;
		}else
		{
			$DataUpdate = array("AdminID" =>$DepAdminID );
			$this->db->update('online_lec_dep_admin', $DataUpdate , array('DepID' => $DepID));
			return TRUE ;
		}
	}

	////////Add Dep
	public function addDep($data)
	{
		extract($data);
		$DataInsert = array("Name"  =>$DepName ,"Descripe"  =>$DepDescripe ,"RowLevelID"  =>$RowLevelID ,"Token" =>$this->Token , "IsActive" => 1);
		$this->db->insert('online_lec_deps',$DataInsert);
		return TRUE ;
	}
	
	////////Edit Dep
	public function editDep($data)
	{
		extract($data);//echo $EditIsActive;die;
		$DataUpdate = array("Name"  	=>$EditDepName ,
			"Descripe"  =>$EditDepDescripe ,
			"RowLevelID"=>$EditRowLevelID ,
			"IsActive"=>$EditIsActive 
		);
		$this->db->update('online_lec_deps', $DataUpdate , array('ID' => $EditDepID));
		return TRUE ;
	}

 	////////Active Dep
	public function activecomment($commentID)
	{ 
		$DataUpdate = array("IsActive" => 1);
		$this->db->update('online_lec_dep_articles_comments', $DataUpdate , array('ID' => $commentID));
		return TRUE ;
	}

	////////Not Active Dep
	public function notActivecomment($commentID)
	{
		$DataUpdate = array("IsActive" => 0);
		$this->db->update('online_lec_dep_articles_comments', $DataUpdate , array('ID' => $commentID));
		return TRUE ;
	}

 	////////Active Dep
	public function activeDep($DepID)
	{
		$DataUpdate = array("IsActive" => 1);
		$this->db->update('online_lec_deps', $DataUpdate , array('ID' => $DepID));
		return TRUE ;
	}

	////////Not Active Dep
	public function notActiveDep($DepID)
	{
		$DataUpdate = array("IsActive" => 0);
		$this->db->update('online_lec_deps', $DataUpdate , array('ID' => $DepID));
		return TRUE ;
	}

	////////Not Active Dep
	public function delDep($DepID)
	{
		$this->db->delete('online_lec_deps', array('ID' => $DepID));
		return TRUE ;
	}

	////////Not Active Dep
	public function get_DepInfo($DepToken)
	{
		$this->db->select('ID AS DepID , Name AS DepName');
		$this->db->from('online_lec_deps');
		$this->db->where('Token', $DepToken);
		
		$ResultDepInfo = $this->db->get();			
		$NumRowResultDepInfo  = $ResultDepInfo->num_rows() ; 
		if($NumRowResultDepInfo != 0)
		{
			$ReturnDepInfo = $ResultDepInfo ->row_array() ;
			return $ReturnDepInfo ;
		}
		else
		{
			return $NumRowResultDepInfo ;
		}
	}
	
	////////get_token
	public function get_Dep_Articles($DepID)
	{
		$idContact = (int)$this->session->userdata('id');
		$this->db->select('online_lec_dep_articles.ID AS ArticleID ,
			online_lec_dep_articles.Title AS ArticleTitle ,
			online_lec_dep_articles.Token AS ArticleToken ,
			online_lec_dep_articles.DateSTM AS ArticleDate ,
			online_lec_dep_articles.ViewCounter AS ArticleViews ,
			contact.Name AS AutherName
			');
		$this->db->from('online_lec_dep_articles');
		$this->db->join('contact', 'contact.ID = online_lec_dep_articles.ContactID'); 
		$this->db->where("(FIND_IN_SET(".$idContact.", students_ids))"); 
		$this->db->or_where("(FIND_IN_SET(".$idContact.", RowLevel_ids))"); 
		$this->db->where('DepID', $DepID);
		
		$ResultDepArts = $this->db->get();	
  //  echo  $this->db->last_query() ;	die;	
		$NumRowResultDepArts  = $ResultDepArts->num_rows() ; 
		if($NumRowResultDepArts != 0)
		{
			$ReturnDepArts = $ResultDepArts ->result() ;
			return $ReturnDepArts ;
		}
		else
		{
			return $NumRowResultDepArts ;
		}
	}
	
	////////get_token
	public function get_comments_num($ArticleID)
	{
		$this->db->select('*');
		$this->db->from('online_lec_dep_articles_comments');
		$this->db->where('ArticleID', $ArticleID);
		
		$ResultComments = $this->db->get();			
		$NumRowResultComments  = $ResultComments->num_rows() ; 
		return $NumRowResultComments ;
	}
	
	////////get_token
	public function get_last_comment($ArticleID)
	{
		$this->db->select('online_lec_dep_articles_comments.Txt AS CommentTitle,
			online_lec_dep_articles_comments.DateSTM AS DateSTM,
			contact.Name AS AutherName
			');
		$this->db->from('online_lec_dep_articles_comments');
		$this->db->join('contact', 'contact.ID = online_lec_dep_articles_comments.ContactID');
		$this->db->where('online_lec_dep_articles_comments.ArticleID', $ArticleID);
		$this->db->order_by('online_lec_dep_articles_comments.DateSTM', 'desc');
		$this->db->limit(1);
		
		$ResultComment = $this->db->get();			
		$NumRowResultComment  = $ResultComment->num_rows() ; 
		if($NumRowResultComment != 0)
		{
			$ReturnComment = $ResultComment ->row_array() ;
			return $ReturnComment ;
		}
		else
		{
			return $NumRowResultComment ;
		}
	}
	
	////////get_token
	public function get_Article($ArtiToken)
	{ 

		// $this->db->where('Token', $ArtiToken);
		// $this->db->set('ViewCounter', 'ViewCounter+1', FALSE);
		// $this->db->update('online_lec_dep_articles');
		
		if($this->db->affected_rows()>0)
		{
			$this->db->select('online_lec_dep_articles.ID AS ArticleID , online_lec_dep_articles.students_ids AS students_ids , online_lec_dep_articles.Title AS ArticleTitle , online_lec_dep_articles.allow_comment AS allow_comment  , online_lec_dep_articles.auto_approve_comment AS auto_approve_comment ,
				online_lec_dep_articles.Content AS ArticleContent , online_lec_dep_articles.Token AS ArticleToken ,
				online_lec_dep_articles.DateSTM AS ArtiDateSTM , 
				contact.Name AS AutherName ,
				online_lec_deps.Name AS DepName , online_lec_deps.Token AS DepToken
				');
			$this->db->from('online_lec_dep_articles');
			$this->db->join('contact', 'contact.ID = online_lec_dep_articles.ContactID');
			$this->db->join('online_lec_deps', 'online_lec_deps.ID = online_lec_dep_articles.DepID');
			$this->db->where('online_lec_dep_articles.Token', $ArtiToken);
			$this->db->limit(1);
			
			$ResultArticle = $this->db->get();			
			$NumRowResultArticle  = $ResultArticle->num_rows() ; 
			if($NumRowResultArticle != 0)
			{
				$ReturnArticle = $ResultArticle ->row_array() ;

				$stringArray = explode(',',$ReturnArticle['students_ids']);  
				if (!in_array($this->session->userdata('id'), $stringArray)) {  

				$students_ids=$ReturnArticle['students_ids'].",".$this->session->userdata('id');
				}else{
				$students_ids=$ReturnArticle['students_ids'];
				}

				$this->db->query("UPDATE online_lec_dep_articles SET ViewCounter =ViewCounter+1 , students_ids = '".$students_ids."' WHERE Token ='".$ArtiToken."' ");
				return $ReturnArticle ;
			}
			else
			{
				return $NumRowResultArticle ;
			}
		} 
		
	}

	////////Add Dep
	public function addArticle($data)
	{
		extract($data);
		$DataInsert = array("ContactID"	=>$ContactID ,
			"DepID"		=>$DepID ,
			"Title"  	=>$ArticleTitle ,
			"Content" 	=>$ArticleTxt , 
			"Token" 	=>$this->Token , 
			"IsActive" 	=> 1
		);
		$this->db->insert('online_lec_dep_articles',$DataInsert);
		return TRUE ;
	}

	
}//Class
?>