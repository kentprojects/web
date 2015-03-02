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

	public static function getPotentialRoles(stdClass $roles)
	{
		$potential = array();

		if ($roles->convener)
		{
			$potential["convener"] = "Convener";
		}
		if ($roles->supervisor)
		{
			$potential["supervisor"] = "Supervisor";
		}
		if ($roles->secondmarker)
		{
			$potential["secondmarker"] = "Second Marker";
		}

		return $potential;
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

	public static function getPotentialYears()
	{
		if (Session::has("years"))
		{
			$years = Session::get("years");
		}
		else
		{
			$response = API::Request(API::GET, "/years");
			if ($response->status != 200)
			{
				throw new LogicException((string)$response);
			}
			$years = $response->body;
			Session::set("years", $years);
		}

		return $years;
	}

	/**
	 * @param stdClass $user
	 * @return ApiResponse
	 */
	public static function uploadUserAvatar(stdClass $user)
	{
		if (empty($_FILES))
		{
			return new ApiResponse(400, '"No uploaded files found."');
		}

		if (empty($_FILES["file"]))
		{
			return new ApiResponse(400, '"No uploaded file found."');
		}

		if (isset($_FILES["file"]["error"]) && ($_FILES["file"]["error"] > UPLOAD_ERR_OK))
		{
			switch ($_FILES["file"]["error"])
			{
				case UPLOAD_ERR_INI_SIZE:
				case UPLOAD_ERR_FORM_SIZE:
					$error = "File exceeds file size limits";
					break;
				default:
					$error = "An error occurred.";
			}
			return new ApiResponse(400, '"' . $error . '"');
		}

		$filename = md5($user->email) . "." . pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);

		if (move_uploaded_file($_FILES["file"]["tmp_name"], UPLOADS_DIR . "/" . $filename))
		{
			return new ApiResponse(200, json_encode((object)array(
				"file" => "/uploads/" . $filename
			)));
		}
		else
		{
			return new ApiResponse(500, '"Failed to upload."');
		}
	}
}