<?php
/**
 * @author: KentProjects <developer@kentprojects.com>
 * @license: Copyright KentProjects
 * @link: http://kentprojects.com
 */
final class KentProjects
{
	/**
	 * A year runs from September to August.
	 * Therefore, if the month in the date is greater than or equal to September, return the year.
	 * Otherwise, return the year minus one.
	 *
	 * @param string $date
	 * @return int
	 */
	public static function getAcademicYearFromDate($date)
	{
		$date = strtotime($date);
		return (intval(date("n", $date)) >= 9) ? intval(date("Y", $date)) : (intval(date("Y", $date)) - 1);
	}

    public static function getForcedRole()
    {
        return Session::get("forcedRole");
    }

    // TODO: Add validation for this
    public static function setForcedRole($role)
    {
        Session::set("forcedRole", $role);
    }

    public static function getPotentialRoles(stdClass $user)
    {
	    $roles = array();
	    
		if ($user->role != "staff")
		{
			return $roles;
		}
		
		if ($user->is->convenor)
		{
			$roles[] = "Convenor";
		}
		if ($user->is->supervisor)
		{
			$roles[] = "Supervisor";
		}
		if ($user->is->secondmarker)
		{
			$roles[] = "Second Marker";
		}
		
		return $roles;
    }

	public static function getForcedYear()
	{
		return Session::get("forcedYear");
	}

	// TODO: Add validation for this
	public static function setForcedYear($year)
	{
		Session::set("forcedYear", $year);
	}

	public static function getPotentialYears(stdClass $user)
	{
		// TODO: Get a list of years the user is assigned to

		return $years;
	}
}