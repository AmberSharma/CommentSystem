<?php
require_once 'model.php';
ini_set ( "display_error", 'on' );
class Register extends model {
	protected $name;
	protected $email;
	protected $comment;
	protected $pageid;
	protected $replyid;
	
	
	
	/**
	 * @return the $replyid
	 */
	public function getReplyid() {
		return $this->replyid;
	}

	/**
	 * @param field_type $replyid
	 */
	public function setReplyid($replyid) {
		$this->replyid = $replyid;
	}

	/**
	 * @return the $pageid
	 */
	public function getPageid() {
		return $this->pageid;
	}

	/**
	 * @param field_type $pageid
	 */
	public function setPageid($pageid) {
		$this->pageid = $pageid;
	}

	/**
	 * @return the $name
	 */
	public function getName() {
		return $this->name;
	}

	/**
	 * @return the $email
	 */
	public function getEmail() {
		return $this->email;
	}

	/**
	 * @return the $comment
	 */
	public function getComment() {
		return $this->comment;
	}

	/**
	 * @param field_type $name
	 */
	public function setName($name) {
		$this->name = $name;
	}

	/**
	 * @param field_type $email
	 */
	public function setEmail($email) {
		$this->email = $email;
	}

	/**
	 * @param field_type $comment
	 */
	public function setComment($comment) {
		$this->comment = $comment;
	}

	public function Question($id)
	{
    	$this->db->Fields(array("id","question"));
    	$this->db->From("question");
    	$this->db->where(array("id"=>$id));
    	$this->db->Select ();
    	$result = $this->db->resultArray ();
    	//echo $this->db->lastQuery();
    	return $result;
    
    }
    public function saveReply($id , $parent=0)
    {
    	echo $parent;
    	//$this->db->Fields(array("id","question"));
    	if($parent != "0" )
    	{
    	$this->db->fields(array("id"=>'',"parent_id"=>$parent,"ques_id"=>$id,"name"=>$this->getName (),"email"=>$this->getEmail(),"comment"=>$this->getComment(),"likes"=>'',"dislike"=>'',"created_on"=>date('Y-m-d H:m:s') ));
    	}
    	
    	else
    	{
    		$this->db->fields(array("id"=>'',"parent_id"=>"'".$parent."'","ques_id"=>$id,"name"=>$this->getName (),"email"=>$this->getEmail(),"comment"=>$this->getComment(),"likes"=>'',"dislike"=>'',"created_on"=>date('Y-m-d H:m:s') ));
    		 
    	}
    	$this->db->From("reply");
    	
    	if($this->db->insert())
    	{
    		echo $this->db->lastQuery();
    		return "1".",".$parent;
    	}
    	
    	
    	
    
    }
    public function fetchComment($parent , $id)
    {
    	$a=1;
    	$i=0;
    	$result1=array();
	$m=0;
	$n=0;
    	while($parent || $a)
    	{
    		$this->db->Fields(array("id","name","email","comment","likes","dislike","created_on"));
    		$this->db->From("reply");
    	
    		$this->db->where(array("parent_id"=>$parent,"ques_id"=>$id));
    	
    		$this->db->Select ();
    		$result = $this->db->resultArray ();
		for($k=0;$k<count($result);$k++)
		{
			$value[$m]=$result[$k]['id'];
			$m++;
		}
    	
    		if($result)
    		{
    		
				for($j=0;$j< count($result);$j++)
				{
					$result1[$i]=$result[$j];
					$result1[$i]['parent']=$parent;
					$i++;
					
				}
				
				
				
				$parent=$value[$n++];
				
				$a=0;
    		}
    		else 
    		{
    		
    			break;
    		}
    	//echo $this->db->lastQuery();
    	
    	}
    	
    	return $result1;
    
    }
    
    public function fetchLatestcomment($parent , $id)
    {
    	 
    	$this->db->Fields(array("id","name","email","comment","likes","dislike","created_on"));
    	$this->db->From("reply");
    	
    	$this->db->where(array("parent_id"=>$parent,"ques_id"=>$id));
    	$this->db->OrderBy("id","DESC");
    	$this->db->Limit("1");
    	$this->db->Select ();
    	$result = $this->db->resultArray ();
    
    	echo $this->db->lastQuery();
    	//print_r($result);die;
    	return $result;
    
    }
    
    public function handleLikes()
    {
    	$this->db->Fields(array("likes"));
    	$this->db->From("reply");
    	$this->db->where(array("id"=>$this->replyid));
    	//$this->db->Limit("1");
    	$this->db->Select ();
    	$result = $this->db->resultArray ();
    	
    	if(empty($result[0]))
    	{
    		$result[0]['likes'] =1;
    	}
    	else 
    	{
    		$result[0]['likes'] =$result[0]['likes']+1;
    	}
    	
    	$this->db->Fields(array("likes"=>$result[0]['likes']));
    	$this->db->From("reply");
    	$this->db->where(array("id"=>$this->replyid));
    	if($this->db->update ())
    	{
    		return "1";
    	}
    	
    
    }
    public function handleUnlikes()
    {
    	$this->db->Fields(array("dislike"));
    	$this->db->From("reply");
    	$this->db->where(array("id"=>$this->replyid));
    	//$this->db->Limit("1");
    	$this->db->Select ();
    	$result = $this->db->resultArray ();
    	 
    	if(empty($result[0]))
    	{
    		$result[0]['dislike'] =1;
    	}
    	else
    	{
    		$result[0]['dislike'] =$result[0]['dislike']+1;
    	}
    	 
    	$this->db->Fields(array("dislike"=>$result[0]['dislike']));
    	$this->db->From("reply");
    	$this->db->where(array("id"=>$this->replyid));
    	if($this->db->update ())
    	{
    		return "1";
    	}
    	 
    
    }
	
	public function checkUnique() {
		$this->db->Fields ( array (
				"user_name" 
		) );
		$this->db->From ( "users" );
		$this->db->Where ( array (
				"user_name" => $this->getUserName () 
		) );
		$this->db->Select ();
		if ($this->db->resultArray ()) {
			return 1;
		} else {
			return 0;
		}
	}
}

?>
