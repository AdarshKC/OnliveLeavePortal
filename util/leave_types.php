<?php
define('oneDay', 86400);

/**
* This class keeps tabs on the distribution of the days in the requested time period as leave, holidays, weekends, and vacations
*/
class Leave
{
	/**
	* @param: from and to (string) (actual from date and to date) 
	*/
	private $from;
	private $to;
	
	/**
	*	@param: sat_def_holi (int) 
	*  		(0-> Sundays are holidays and Saturdays are working days)
	* 		(1-> Both Sundays and Saturdays are holidays)
	*/
	private $sat_def_holi;
	
	/**
	*	@param: t_from and t_to (int) (effective(may not be original ie., given) from date and to date)
	*/
	private $t_from;
	private $t_to;
	
	/**
	*	@param: t_Day (int) (Total days from t_from to t_to)
	*/
	private $t_Days;
	
	/**
	*	@param: t_from and t_to (int) (from date and to date)
	*/
	private $l_Days;
	
	private $inc_holidays;
	private $inc_weekends;
	private $inc_vacation;
	private $query_holidays;
	private $dbh;
	
	/* ================================================
	Accessors and Modifiers
	================================================ */ 
	
	function getTDays(){
		return $this->t_Days;
	}
	
	function setT_From($from) 
	{
		$this->t_from = $from;
		
		$this->t_Days = ceil(($this->t_to-$this->t_from)/oneDay)+1;
		if ($this->t_Days<0) {
			$this->t_Days=0;
		}
	}
	
	function setT_To($to)
	{
		$this->t_to = $to;
		
		$this->t_Days = ceil(($this->t_to-$this->t_from)/oneDay)+1;
		if ($this->t_Days<0) {
			$this->t_Days=0;
		}
	}
	
	function setSatDefaultHoli($sat_def_holi) 
	{
		$this->sat_def_holi = $sat_def_holi;
	}
	
	function prepare_holidayQuery()
	{
		
		$sql="SELECT * FROM list_holidays WHERE date BETWEEN :from AND :to";
		$query_holidays = $this->dbh->prepare($sql);
		$query_holidays->bindParam(':from', $this->from, PDO::PARAM_STR);
		$query_holidays->bindParam(':to', $this->to, PDO::PARAM_STR);
		$query_holidays->execute();
		return $query_holidays;
	}
	
	/* ================================================
	Constructors and Destructors
	================================================ */ 
	
	function __construct($from, $to, $sat_def_holi = 1)
	{
		$this->from = $from;
		$this->to = $to;
		$this->sat_def_holi = $sat_def_holi;
		
		$this->t_from = strtotime($from);
		$this->t_to = strtotime($to);
		
		$this->t_Days = ceil(($this->t_to-$this->t_from)/oneDay)+1;
		if ($this->t_Days<0) {
			$this->t_Days=0;
		}
		
		$this->l_Days = $this->t_Days;
		// Initialize the public variables
		
		$this->inc_weekends = array();
		$this->inc_holidays = array();
		$this->inc_vacation = array();
		
		try {
			$this->dbh = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME,DB_USER, DB_PASS,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
		} catch (PDOException $e) {
			exit("Error: " . $e->getMessage());
		}
		
		$this->query_holidays = $this->prepare_holidayQuery(); 
	}
	
	// Methods =======================================
	
	function getWeekday($date,$i) 
	{
		if($date==null){
			return -1;
		} 
		return date('w', strtotime('+'.$i.' day', $date));
	}
	
	function getDay($date,$i) 
	{
		if($date==null){
			return -1;
		} 
		return strtotime('+'.$i.' day', $date);
	}
	
	function getDateToStr($date, $i)
	{
		if($date==null){
			return -1;
		} 
		return date('Y-m-d', strtotime('+'.$i.' day', $date));
	}
	
	
	/** 
	* @return: Elements of array1 that are not present in array2
	*/
	private function checkuncommon($array1,$array2)
	{
		$uncommon = array();
		foreach ($array1 as $elem1) {
			if (!in_array($elem1, $array2)) {
				$uncommon[] = $elem1;		
			}	
		}
		
		return $uncommon;
	}	
	
	function calcHolidays($save=0) 
	{	
		$holidays = array();
		if ( $this->t_from<=$this->t_to ) {
			if($this->query_holidays->execute()) {
				$results=$this->query_holidays->fetchAll(PDO::FETCH_OBJ);
				if($this->query_holidays->rowCount() > 0) {
					foreach ($results as $result) {
						$h_date = strtotime($result->from_date);
						$holidays[] = $h_date;
					}
				}
			}
		}
		
		if ($save==1) {
			$this->inc_holidays = $holidays;
		}
		
		return $holidays;
	}
	
	/**
	*	@return: if ($include_weekend)
	2 : All Saturdays and Sundays in array : int 
	1 : Only Sundays in array : int 
	*/
	function calcWeekends($save=0) 
	{		
		$weekends = array();
		if ($this->sat_def_holi==1) { // Saturdays and Sundays are default holidays
			for ($i=0; $i < ($this->t_Days); $i++) { 
				if ($this->getWeekday($this->t_from,$i)==6 || $this->getWeekday($this->t_from,$i)==0) {
					$weekends[] = strtotime('+'.($i).' days', $this->t_from);
				}
			}
		} elseif ($this->sat_def_holi==0) { // Saturday is working day and Sunday is holiday
			for ($i=0; $i < ($this->t_Days); $i++) { 
				if ($this->getWeekday($this->t_from,$i)==0) {
					$weekends[] = strtotime('+'.($i).' days', $this->t_from);
				}
			}
		} 
		
		if ($save==1) {
			$this->inc_weekends = $weekends;
		}
		
		return $weekends;
	}
	
	
	function trimLeavedays()
	{
		$this->calcWeekends(1);
		$this->calcHolidays(1);
		$i = 0;
		$temp = 0;
		$j = 0;
		while (true) {
			if(isset($this->inc_holidays[$temp])){
				$curr_h = $this->getDay($this->inc_holidays[$temp],0);
			} else {
				$curr_h = -1;
			}

			if ( ($this->getDay($this->t_from, $i)==$curr_h || in_array($this->getDay($this->t_from, $i), $this->inc_weekends)) && $this->getDay($this->t_from, $i)<=$this->t_to ) {
				$i++;
				if($this->getDay($this->t_from, $i)==$curr_h){
					$temp++;
				}
				if($temp==count($this->inc_holidays) || $i==$this->t_Days){
					break;
				}
			}
			$j++;
			
			if ($j!=$i) {
				break;
			}
		}
		$this->setT_From($this->getDay($this->t_from, $i));

		if($this->t_from>$this->t_to){
			return;
		}

		$i = 0;
		$temp = 0;
		$j = 0;
		while (true) {
			if(isset($this->inc_holidays[$temp])){
				$curr_h = $this->getDay($this->inc_holidays[$temp],0);
			} else {
				$curr_h = -1;
			}
			if ( ($this->getDay($this->t_to, -1*$i)==$curr_h || in_array($this->getDay($this->t_to, -1*$i), $this->inc_weekends)) && $this->getDay($this->t_from, $i)<=$this->t_to ) {
				$i++;
				if($this->getDay($this->t_to, -1*$i)==$curr_h){
					$temp++;
				}
				if($temp==count($this->inc_holidays)){
					break;
				}
			}
			$j++;
			
			if ($j!=$i) {
				break;
			}
		}
		
		$this->setT_To($this->getDay($this->t_to, -1*$i));
	}
	
	function calcToalLeaveDays($include_weekend_inLeave=0) 
	{
		$this->trimLeavedays();
		$total = 0;
		
		if ($this->t_Days>0) {
			$total+= $this->t_Days - count($this->calcHolidays());
		}
		
		if ($include_weekend_inLeave==0 && $this->t_Days>0) {
			$total-= count($this->checkuncommon($this->calcWeekends(), $this->calcHolidays()));	
		}
		
		$this->l_Days = $total;
		
		$Leave_days = array();
		
		$Leave_days['holidays'] = $this->inc_holidays;
		$Leave_days['weekends'] = $this->checkuncommon($this->inc_weekends, $this->inc_holidays);
		$Leave_days['days'] = $this->l_Days;
		
		return $Leave_days;
	}
	
	function WorkingDays_left()
	{
		$total = ceil((strtotime($this->to)-strtotime($this->from))/oneDay)+1;
		$Ldays = count($this->checkuncommon($this->calcWeekends(), $this->calcHolidays()));
		$count = $total - $Ldays;
		return $count;
	}
}


