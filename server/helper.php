<?php
date_default_timezone_set("Asia/Ho_Chi_Minh");

define('SESSION_USER_KEY', 'astd_user');
define('FILE_TEAM_DATA', 'data/team.json');
define('FILE_CONFIG_DATA', 'data/config.json');
define('FILE_PICKED_DATA', 'data/questions/picked.json');
define('FILE_ANSWER_PATTERN', 'data/answer-%s.json');
define('FILE_QUESTION_PATTERN', 'data/questions/bo-%s.json');
define('FILE_PACK_PATTERN', 'data/questions/pack%s/bo-%s.json');


class Helper {
	public static function removeFiles($files) {
		foreach ($files as $file) {
			if (file_exists($file)) {
				unlink($file);
			}
		}
	}

	public static function loadJSON($filename) {
		$content = @file_get_contents($filename);
		if (!$content) {
			return false;
		}
		return json_decode($content, true);
	}

	public static function saveJSON($filename, $data) {
		$success = file_put_contents($filename, json_encode($data, JSON_PRETTY_PRINT));
		if (!$success) {
			return false;
		}
		@chmod($filename, 0777);
		return true;
	}

	public static function loadTeamData() {
		return self::loadJSON(FILE_TEAM_DATA);
	}

	public static function loadAnswerByTeam($username) {
		$filename = sprintf(FILE_ANSWER_PATTERN, $username);
		if (!file_exists($filename)) {
			return false;
		}
		$content = @file_get_contents($filename);
		if (!$content) {
			return false;
		}
		return json_decode($content, true);
	}

	public static function loadAllTeamAnswers() {
		$teamData = self::loadTeamData();
		$answers = array();
		foreach ($teamData as $key => $team) {
			$answer = Helper::loadAnswerByTeam($key);
			if ($answer) {
				$answers[] = array(
					'username' => $key,
					'fullname' => $team['shortName'],
					'answer' => $answer['answer'],
					'time' => $answer['time']
				);
			}
		}
		usort($answers, function($a, $b) {
			return $a['time'] > $b['time'];
		});
		return $answers;
	}

	public static function clearAnswers() {
		$teamData = self::loadTeamData();
		$files = array();
		foreach ($teamData as $key => $team) {
			$files[] = sprintf(FILE_ANSWER_PATTERN, $key);
		}
		self::removeFiles($files);
	}

	public static function isLoggedIn() {
		session_start();
		session_commit();
		if (self::getUserData() === false) {
			return false;
		}
		return true;
	}

	public static function getUserData() {
		session_start();
		session_commit();
		if (!isset($_SESSION[SESSION_USER_KEY])) {
			return false;
		}
		return $_SESSION[SESSION_USER_KEY];
	}

	public static function setUserData($data) {
		session_start();
		$_SESSION[SESSION_USER_KEY] = $data;
		session_commit();
	}

	public static function clearSession() {
		session_start();
		session_destroy();
	}

	public static function showError($msg) {
		echo json_encode(array(
			'error' => $msg
		));
		exit;
	}

	public static function toJSON($data) {
		echo json_encode(array(
			'data' => $data
		));
		exit;
	}

	public static function loadConfigData(){
	    $content = file_get_contents(FILE_CONFIG_DATA);
	    return json_decode($content);
    }
}