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

	/**
	 * TODO: Add validation for this
	 *
	 * @param string $role
	 */
	public static function setForcedRole($role)
	{
		Session::set("forcedRole", $role);
	}

	public static function getForcedYear($default = null)
	{
		return Session::get("forcedYear", $default);
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
			return new ApiResponse(400, array(), '"No uploaded files found."');
		}

		if (empty($_FILES["file"]))
		{
			return new ApiResponse(400, array(), '"No uploaded file found."');
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
			return new ApiResponse(400, array(), '"' . $error . '"');
		}

		$filename = md5($user->email) . "." . pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);

		exec(sprintf("rm -f %s/%s*", UPLOADS_DIR, md5($user->email)));

		if (move_uploaded_file($_FILES["file"]["tmp_name"], UPLOADS_DIR . "/" . $filename))
		{
			return new ApiResponse(200, array(), json_encode((object)array(
				"file" => "/uploads/" . $filename
			)));
		}
		else
		{
			return new ApiResponse(500, array(), '"Failed to upload."');
		}
	}
}