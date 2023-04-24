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
 * File containing processor class.
 *
 * @package    tool_bulkenrol
 * @copyright  2013 Frédéric Massart
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();
require_once($CFG->libdir . '/csvlib.class.php');

/**
 * Processor class.
 *
 * @package    tool_bulkenrol
 * @copyright  2013 Frédéric Massart
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class tool_bulkenrol_processor {

    const MODE_USER_EMAIL = 'email';
    const MODE_USER_USERNAME = 'username';
    const MODE_USER_ID = 'id';


    const MODE_COURSE_SHORTNAME = 'shortname';
    const MODE_COURSE_IDNUMBER = 'idnumber';
    const MODE_COURSE_ID = 'id';


    const MODE_ROLE_SHORTNAME = 'shortname';
    const MODE_ROLE_ID = 'id';


    /** @var int user resolve mode. */
    protected $mode_user;

    /** @var int course resolve mode. */
    protected $mode_course;

    /** @var int role resolve mode. */
    protected $mode_role;


    /** @var csv_import_reader */
    protected $cir;

    /** @var array CSV columns. */
    protected $columns = array();

    /** @var array of errors where the key is the line number. */
    protected $errors = array();

    /** @var int line number. */
    protected $linenb = 0;

    /** @var bool whether the process has been started or not. */
    protected $processstarted = false;

    /**
     * Constructor
     *
     * @param csv_import_reader $cir import reader object
     * @param array $options options of the process
     * @param array $defaults default data value
     */
    public function __construct(csv_import_reader $cir, array $options) {
        // User mode validation
        if (!isset($options['mode_user']) || !in_array($options['mode_user'], array(self::MODE_USER_EMAIL, self::MODE_USER_USERNAME, self::MODE_USER_ID))) {
            throw new coding_exception('Unknown user mode');
        }

        // Course mode validation
        if (!isset($options['mode_course']) || !in_array($options['mode_course'], array(self::MODE_COURSE_SHORTNAME, self::MODE_COURSE_IDNUMBER,
                self::MODE_COURSE_ID))) {
            throw new coding_exception('Unknown course mode');
        }

        // Role mode validation
        if (!isset($options['mode_role']) || !in_array($options['mode_role'], array(self::MODE_ROLE_SHORTNAME, self::MODE_ROLE_ID))) {
            throw new coding_exception('Unknown role mode');
        }

        $this->mode_user = $options['mode_user'];
        $this->mode_course = $options['mode_course'];
        $this->mode_role = $options['mode_role'];

        $this->cir = $cir;
        $this->columns = $cir->get_columns();
        $this->validate();
        $this->reset();
    }

    /**
     * Execute the process.
     *
     * @param object $tracker the output tracker to use.
     * @return void
     */
    public function execute($tracker = null) {
        if ($this->processstarted) {
            throw new coding_exception('Process has already been started');
        }
        $this->processstarted = true;

        if (empty($tracker)) {
            $tracker = new tool_bulkenrol_tracker(tool_bulkenrol_tracker::NO_OUTPUT);
        }
        $tracker->start();

        $total = 0;
        $enrolled = 0;
        $errors = 0;

        // We will most certainly need extra time and memory to process big files.
        core_php_time_limit::raise();
        raise_memory_limit(MEMORY_EXTRA);

        // Loop over the CSV lines.
        while ($line = $this->cir->next()) {
            $this->linenb++;
            $total++;

            $data = $this->parse_line($line);
            $enrollment = $this->get_enrollment($data);
            if ($enrollment->prepare()) {
                $enrollment->proceed();

                $status = $enrollment->get_statuses();
                if (array_key_exists('bulkuserenrolled', $status)) {
                    $enrolled++;
                }

                $data = array_merge($data, $enrollment->get_data(), array('id' => $enrollment->get_id()));
                $tracker->output($this->linenb, true, $status, $data);
                if ($enrollment->has_errors()) {
                    $errors++;
                    $tracker->output($this->linenb, false, $enrollment->get_errors(), $data);
                }
            } else {
                $errors++;
                $tracker->output($this->linenb, false, $enrollment->get_errors(), $data);
            }
        }

        $tracker->finish();
        $tracker->results($total, $enrolled, $errors);
    }

    /**
     * Return a user import object.
     *
     * @param array $data data to import the user with.
     * @return tool_bulkenrol_enrollment
     */
    protected function get_enrollment($data) {
        $importoptions = array(
            'user' => $this->mode_user,
            'course' => $this->mode_course,
            'role' => $this->mode_role,
        );
        return new tool_bulkenrol_enrollment($data, $importoptions);
    }

    /**
     * Return the errors.
     *
     * @return array
     */
    public function get_errors() {
        return $this->errors;
    }


    /**
     * Log errors on the current line.
     *
     * @param array $errors array of errors
     * @return void
     */
    protected function log_error($errors) {
        if (empty($errors)) {
            return;
        }

        foreach ($errors as $code => $langstring) {
            if (!isset($this->errors[$this->linenb])) {
                $this->errors[$this->linenb] = array();
            }
            $this->errors[$this->linenb][$code] = $langstring;
        }
    }

    /**
     * Parse a line to return an array(column => value)
     *
     * @param array $line returned by csv_import_reader
     * @return array
     */
    protected function parse_line($line) {
        $data = array();
        foreach ($line as $keynum => $value) {
            if (!isset($this->columns[$keynum])) {
                // This should not happen.
                continue;
            }

            $key = $this->columns[$keynum];
            $data[$key] = $value;
        }
        return $data;
    }

    /**
     * Return a preview of the import.
     *
     * This only returns passed data, along with the errors.
     *
     * @param integer $rows number of rows to preview.
     * @param object $tracker the output tracker to use.
     * @return array of preview data.
     */
    public function preview($rows = 10, $tracker = null) {
        if ($this->processstarted) {
            throw new coding_exception('Process has already been started');
        }
        $this->processstarted = true;

        if (empty($tracker)) {
            $tracker = new tool_bulkenrol_tracker(tool_bulkenrol_tracker::NO_OUTPUT);
        }
        $tracker->start();

        // We might need extra time and memory depending on the number of rows to preview.
        core_php_time_limit::raise();
        raise_memory_limit(MEMORY_EXTRA);

        // Loop over the CSV lines.
        $preview = array();
        while (($line = $this->cir->next()) && $rows > $this->linenb) {
            $this->linenb++;
            $data = $this->parse_line($line);
            $enrollment = $this->get_enrollment($data);
            $result = $enrollment->prepare();
            $data = $enrollment->get_data();
            if (!$result) {
                $tracker->output($this->linenb, $result, $enrollment->get_errors(), $data);
            } else {
                $tracker->output($this->linenb, $result, $enrollment->get_statuses(), $data);
            }
            $row = $data;
            $preview[$this->linenb] = $row;
        }

        $tracker->finish();

        return $preview;
    }

    /**
     * Reset the current process.
     *
     * @return void.
     */
    public function reset() {
        $this->processstarted = false;
        $this->linenb = 0;
        $this->cir->init();
        $this->errors = array();
    }

    /**
     * Validation.
     *
     * @return void
     */
    protected function validate() {
        if (empty($this->columns)) {
            throw new moodle_exception('cannotreadtmpfile', 'error');
        } else if (count($this->columns) < 2) {
            throw new moodle_exception('csvfewcolumns', 'error');
        }
    }
}
