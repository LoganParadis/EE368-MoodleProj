<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * File containing the helper class.
 *
 * @package    tool_bulkenrol
 * @copyright  2013 Frédéric Massart
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();
require_once($CFG->dirroot . '/cache/lib.php');
require_once($CFG->dirroot . '/backup/util/includes/backup_includes.php');
require_once($CFG->dirroot . '/backup/util/includes/restore_includes.php');

/**
 * Class containing a set of helpers.
 *
 * @package    tool_bulkenrol
 * @copyright  2013 Frédéric Massart
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class tool_bulkenrol_helper {

    public static function resolve_user($data, $by, &$errors = array()) {
        $user = null;
        global $DB;

        if ($by === tool_bulkenrol_processor::MODE_USER_ID) {
            $user = $DB->get_record('user', array('id'=> $data));
            if(empty($user)) {
                $errors['couldnotresolveuserbyid'] = new lang_string('couldnotresolveuserbyid', 'tool_bulkenrol');
            }
        } else if ($by === tool_bulkenrol_processor::MODE_USER_USERNAME) {
            $user = $DB->get_record('user', array('username'=> $data));
            if(empty($user)) {
                $errors['couldnotresolveuserbyusername'] = new lang_string('couldnotresolveuserbyusername', 'tool_bulkenrol');
            }
        } else if ($by === tool_bulkenrol_processor::MODE_USER_EMAIL) {
            $user = $DB->get_record('user', array('email' => $data));
            if (empty($user)) {
                $errors['couldnotresolveuserbyemail'] = new lang_string('couldnotresolveuserbyemail', 'tool_bulkenrol');
            }
        } else {
            $errors['invalidresolveuser'] = new lang_string('invalidresolveuser', 'tool_bulkenrol');
        }

        return $user;
    }

    public static function resolve_course($data, $by, &$errors = array()) {
        $course = null;
        global $DB;

        if ($by === tool_bulkenrol_processor::MODE_COURSE_ID) {
            $course = $DB->get_record('course', array('id'=> $data));
            if(empty($course)) {
                $errors['couldnotresolvecoursebyid'] = new lang_string('couldnotresolvecoursebyid', 'tool_bulkenrol');
            }
        } else if ($by === tool_bulkenrol_processor::MODE_COURSE_SHORTNAME) {
            $course = $DB->get_record('course', array('shortname'=> $data));
            if(empty($course)) {
                $errors['couldnotresolvecoursebyshortname'] = new lang_string('couldnotresolvecoursebyshortname', 'tool_bulkenrol');
            }
        } else if  ($by === tool_bulkenrol_processor::MODE_COURSE_IDNUMBER) {
            $course = $DB->get_record('course', array('idnumber' => $data));
            if (empty($course)) {
                $errors['couldnotresolvecoursebyidnumber'] = new lang_string('couldnotresolvecoursebyidnumber', 'tool_bulkenrol');
            }
        } else {
            $errors['invalidresolvecourse'] = new lang_string('invalidresolvecourse', 'tool_bulkenrol');
        }

        return $course;
    }

    public static function resolve_role($data, $by, &$errors = array()) {
        $role = null;
        global $DB;

        if ($by === tool_bulkenrol_processor::MODE_ROLE_ID) {
            $role = $DB->get_record('role', array('id'=> $data));
            if(empty($role)) {
                $errors['couldnotresolverolebyid'] = new lang_string('couldnotresolverolebyid', 'tool_bulkenrol');
            }
        } else if ($by === tool_bulkenrol_processor::MODE_ROLE_SHORTNAME) {
            $role = $DB->get_record('role', array('shortname' => $data));
            if (empty($role)) {
                $errors['couldnotresolverolebyshortname'] = new lang_string('couldnotresolverolebyshortname', 'tool_bulkenrol');
            }
        }else {
            $errors['invalidresolverole'] = new lang_string('invalidresolverole', 'tool_bulkenrol');
        }

        return $role;
    }


}