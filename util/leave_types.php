<?php
define('oneDay', 86400);

/**
 * This class keeps tabs on the distribution of the days in the requested time period as leave, holidays, weekends, and vacations
 */
class LeaveTypes
{
	/**
	 * @param: Leave Id(int)
	 */
	private $id;

	/**
	 * @param: Leave Type Name(string)
	 */
	private $LeaveType;

	/**
	  *	@param: (int) No. of days added per year
	  */
	private $totl_avl_year;

	/**
	  *	@param: (int) 1: Accumulates over the years
	  * 			  0: Desnot accumulate 	
	  */
	private $accumulates;

	/**
	  *	@param: (int) x: x parts of the year    
	  * 			  0: Desnot accumulate 	
	  */	
	private $distributed;

	/**
	  *	@param: (int) No. of leaves left of this type 
	  */
	private $left;

	/**
	  *	@param: (int) No. of leaves used of this type 
	  */
	private $used;



	private $description;
	private $restriction;
	
	private $dbh;

	/* ================================================
					Accessors and Modifiers
	   ================================================ */ 
	
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
		return $query_holidays;
	}

	/* ================================================
				Constructors and Destructors
	   ================================================ */ 

	function __construct($arr)
	{
		if (!empty($arr)) {
      		isset($arr['id']) ? $this->setid($arr['id']) : '';
      		isset($arr['LeaveType']) ? $this->setLeaveType($arr['LeaveType']) : '';
      		isset($arr['totl_avl_year']) ? $this->setTotlAvlYear($arr['totl_avl_year']) : '';
      		isset($arr['Description']) ? $this->setDescription($arr['Description']) : '';
      		isset($arr['Restriction']) ? $this->setRestriction($arr['Restriction']) : '';
            isset($arr['Distributed']) ? $this->setDistributed($arr['Distributed']) : '';
            isset($arr['accumulates']) ? $this->setAccumulates($arr['accumulates']) : '';   
    	}
	}

	// Methods =======================================

	function getWeekday($date,$i) 
	{
	    return date('w', strtotime('+'.$i.' day', $date));
	}

	function getDay($date,$i) 
	{
	    return strtotime('+'.$i.' day', $date);
	}

	function getDateToStr($date, $i)
	{
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
		$j = 0;
		while (true) {
			$curr_h = $this->getWeekday($this->inc_holidays[$i],0);
			if ( ($this->getWeekday($this->t_from, $i)==$curr_h || in_array($this->getDay($this->t_from, $i), $this->inc_weekends)) && $this->getDay($this->t_from, $i)<=$this->t_to ) {
				$i++;
				if($i==count($this->inc_holidays) || $i==$this->t_Days){
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
		$j = 0;
		while (true) {
			$curr_h = $this->getWeekday($this->inc_holidays[$i],0);
			if ( ($this->getWeekday($this->t_to, -1*$i)==$curr_h || in_array($this->getDay($this->t_to, -1*$i), $this->inc_weekends)) && $this->getDay($this->t_from, $i)<=$this->t_to ) {
				$i++;
				if($i==count($this->inc_holidays)){
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
		$count = 0;
		$leaves = $this->calcToalLeaveDays();		
		if (isset($leaves['holidays'])) {
			$count+= count($leaves['holidays']); 
		}
		if (isset($leaves['weekends'])) {
			$count+= count($leaves['weekends']); 
		}

		$date1=date_create($this->from);
		$date2=date_create($this->to);
		$total=(int)(date_diff($date1,$date2)->format("%a"));

		return $total-$count;
	}
}
