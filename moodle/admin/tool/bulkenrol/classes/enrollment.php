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
 * File containing the bulkuser class.
 *
 * @package    tool_bulkenrol
 * @copyright  2013 Frédéric Massart
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();
require_once($CFG->libdir . '/enrollib.php');

/**
 * bulkuser class.
 *
 * @package    tool_bulkenrol
 * @copyright  2013 Frédéric Massart
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class tool_bulkenrol_enrollment {

    /** @var array Roles context levels. */
    protected $contextlevels = [];

    /** @var array final import data. */
    protected $data = array();

    /** @var array default values. */
    protected $defaults = array();

    /** @var array enrolment data. */
    protected $enrolmentdata;

    /** @var array errors. */
    protected $errors = array();

    /** @var int the ID of the bulkuser that had been processed. */
    protected $id;

    /** @var array containing options passed from the processor. */
    protected $importoptions = array();

    /** @var array bulkuser import options. */
    protected $options = array();

    /** @var bool set to true once we have prepared the bulkuser */
    protected $prepared = false;

    /** @var bool set to true once we have started the process of the bulkuser */
    protected $processstarted = false;

    /** @var array bulkuser import data. */
    protected $rawdata = array();


    /** @var array errors. */
    protected $statuses = array();


    /** @var array fields allowed as bulkuser data. */
    static protected $validfields = array('user', 'course', 'role');

    /**
     * Constructor
     *
     * @param array $rawdata raw bulkuser data.
     * @param array $importoptions import options.
     */
    public function __construct($rawdata, $importoptions = array()) {

        $this->rawdata = $rawdata;

        $this->importoptions = $importoptions;
    }


    /**
     * Log an error
     *
     * @param string $code error code.
     * @param lang_string $message error message.
     * @return void
     */
    protected function error($code, lang_string $message) {
        if (array_key_exists($code, $this->errors)) {
            throw new coding_exception('Error code already defined');
        }
        $this->errors[$code] = $message;
    }

    /**
     * Return whether the bulkuser exists or not.
     *
     * @param string $shortname the shortname to use to check if the bulkuser exists. Falls back on $this->shortname if empty.
     * @return bool
     */
    protected function exists($courseid, $userid) {
        global $DB;
        $enrolinstance = $DB->get_record('enrol', array('courseid'=>$courseid, 'enrol'=>'manual'));
        if ($enrolinstance) {
            return $DB->record_exists('user_enrolments', array('userid' => $userid, 'enrolid' => $enrolinstance->id));
        }
        return false;
    }

    /**
     * Return the data that will be used upon saving.
     *
     * @return null|array
     */
    public function get_data() {
        return $this->data;
    }

    /**
     * Return the errors found during preparation.
     *
     * @return array
     */
    public function get_errors() {
        return $this->errors;
    }

    /**
     * Return the ID of the processed bulkuser.
     *
     * @return int|null
     */
    public function get_id() {
        if (!$this->processstarted) {
            throw new coding_exception('The bulkuser has not been processed yet!');
        }
        return $this->id;
    }


    /**
     * Return the errors found during preparation.
     *
     * @return array
     */
    public function get_statuses() {
        return $this->statuses;
    }

    /**
     * Return whether there were errors with this bulkuser.
     *
     * @return boolean
     */
    public function has_errors() {
        return !empty($this->errors);
    }

    /**
     * Validates and prepares the data.
     *
     * @return bool false is any error occured.
     */
    public function prepare() {
        $this->prepared = true;

        // Basic data.
        $bulkuserdata = array();
        foreach ($this->rawdata as $field => $value) {
            if (!in_array($field, self::$validfields)) {
                continue;
            }
            $bulkuserdata[$field] = $value;
        }

        // Resolve the category, and fail if not found.
        $errors = array();
        $user = tool_bulkenrol_helper::resolve_user($this->rawdata['user'], $this->importoptions['user'],$errors);
        $course = tool_bulkenrol_helper::resolve_course($this->rawdata['course'], $this->importoptions['course'],$errors);
        $role = tool_bulkenrol_helper::resolve_role($this->rawdata['role'], $this->importoptions['role'],$errors);

        if (empty($errors)) {
            $bulkuserdata['user_id'] = $user->id;
            $bulkuserdata['course_id'] = $course->id;
            $bulkuserdata['role_id'] = $role->id;
            $bulkuserdata['user_display'] = $user->email;
            $bulkuserdata['course_display'] = $course->fullname;
            $bulkuserdata['role_display'] = $role->shortname;
        } else {
            foreach ($errors as $key => $message) {
                $this->error($key, $message);
            }
            return false;
        }


        $exists = $this->exists($course->id, $user->id);

        // If the bulkuser does not exist check all fields are available.
        if (!$exists ) {

            // Mandatory fields upon creation.
            $errors = array();
            foreach (self::$validfields as $field) {
                if ((!isset($bulkuserdata[$field]) || $bulkuserdata[$field] === '') &&
                        (!isset($this->defaults[$field]) || $this->defaults[$field] === '')) {
                    $errors[] = $field;
                }
            }
            if (!empty($errors)) {
                $this->error('missingmandatoryfields', new lang_string('missingmandatoryfields', 'tool_bulkenrol',
                    implode(', ', $errors)));
                return false;
            }
        }

        if ($exists) {
            $this->error('bulkuserexistsanduploadnotallowed',
                new lang_string('bulkuserexistsanduploadnotallowed', 'tool_bulkenrol'));
            return false;
        }

        // Saving data.
        $this->data = $bulkuserdata;

        return true;
    }

    /**
     * Proceed with the import of the bulkuser.
     *
     * @return void
     */
    public function proceed() {
        global $DB;

        if (!$this->prepared) {
            throw new coding_exception('The bulkuser has not been prepared.');
        } else if ($this->has_errors()) {
            throw new moodle_exception('Cannot proceed, errors were detected.');
        } else if ($this->processstarted) {
            throw new coding_exception('The process has already been started.');
        }
        $this->processstarted = true;

        $this->status('bulkuserenrolled', new lang_string('bulkuserenrolled', 'tool_bulkenrol'));


        // Retrieve the manual enrolment plugin.
        $enrol = enrol_get_plugin('manual');
        if (empty($enrol)) {
            throw new moodle_exception('manualpluginnotinstalled', 'enrol_manual');
        }
        // Check manual enrolment plugin instance is enabled/exist.
        $instance = $DB->get_record('enrol', array('courseid'=>$this->data['course_id'], 'enrol' => 'manual'));

        $enrol->enrol_user($instance,  $this->data['user_id'], $this->data['role_id'],);
    }


    /**
     * Log a status
     *
     * @param string $code status code.
     * @param lang_string $message status message.
     * @return void
     */
    protected function status($code, lang_string $message) {
        if (array_key_exists($code, $this->statuses)) {
            throw new coding_exception('Status code already defined');
        }
        $this->statuses[$code] = $message;
    }

}
