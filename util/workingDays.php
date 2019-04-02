<?php
// This function calculates the number of days included in the the given leave type taking parameters
// @param: from : from date in yyyy-mm-dd format
// @param: to   : to date in yyyy-mm-dd format
// @param: include_weekend : 0 - no; 1 - yes  

include_once ('leave.php');

class workingDays
{
	/**
	 * @param: from and to (string) (from date and to date) 
	 */
	private $from;
	private $to;
	
	/**
	  *	@param: t_from and t_to (int) (from date and to date)
	  */
	private $t_from;
	private $t_to;
	private $t_Days;	

	/* ================================================
					Accessors and Modifiers
	   ================================================ */ 

	
	/* ================================================
				Constructors and Destructors
	   ================================================ */ 
}