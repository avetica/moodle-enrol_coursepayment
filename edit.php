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
 * Adds new instance of enrol_coursepayment to specified course
 *
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 *
 * @package   enrol_coursepayment
 * @copyright 2015 MFreak.nl
 * @author    Luuk Verhoeven
 **/

require('../../config.php');
defined('MOODLE_INTERNAL') || die();

require_once('edit_form.php');

$courseid = required_param('courseid', PARAM_INT);
$instanceid = optional_param('id', 0, PARAM_INT); // Instanceid.

$course = $DB->get_record('course', ['id' => $courseid], '*', MUST_EXIST);
$context = context_course::instance($course->id, MUST_EXIST);

require_login($course);
require_capability('enrol/coursepayment:config', $context);

$PAGE->set_url('/enrol/coursepayment/edit.php', [
    'courseid' => $course->id,
    'id' => $instanceid,
]);
$PAGE->set_pagelayout('admin');
$return = new moodle_url('/enrol/instances.php', ['id' => $course->id]);
if (!enrol_is_enabled('coursepayment')) {
    redirect($return);
}

$plugin = enrol_get_plugin('coursepayment');

if ($instanceid) {
    $instance = $DB->get_record('enrol', [
        'courseid' => $course->id,
        'enrol' => 'coursepayment',
        'id' => $instanceid,
    ], '*', MUST_EXIST);
    $instance->cost = format_float($instance->cost, 2, true);
    $instance->profile_pricing = enrol_coursepayment_helper::get_profile_pricing($instance->id);
} else {
    require_capability('moodle/course:enrolconfig', $context);
    // No instance yet, we have to add new instance.
    navigation_node::override_active_url(new moodle_url('/enrol/instances.php', ['id' => $course->id]));
    $instance = new stdClass();
    $instance->id = null;
    $instance->courseid = $course->id;
    $instance->expirynotify = $plugin->get_config('expirynotify');
    $instance->expirythreshold = $plugin->get_config('expirythreshold');
}

$mform = new enrol_coursepayment_edit_form(null, [$instance, $plugin, $context]);

if ($mform->is_cancelled()) {
    redirect($return);

} else {
    if ($data = $mform->get_data()) {

        if ($data->expirynotify == 2) {
            $data->expirynotify = 1;
            $data->notifyall = 1;
        } else {
            $data->notifyall = 0;
        }
        if (!$data->expirynotify) {
            // Keep previous/default value of disabled expirythreshold option.
            $data->expirythreshold = $instance->expirythreshold;
        }

        if ($instance->id) {
            $reset = ($instance->status != $data->status);

            $instance->status = $data->status;
            $instance->name = $data->name;
            $instance->customtext1 = $data->customtext1;
            $instance->customtext2 = $data->customtext2;
            $instance->customint1 = $data->customint1;
            $instance->cost = unformat_float(str_replace(',', '.', $data->cost));
            $instance->currency = $data->currency;
            $instance->roleid = $data->roleid;
            $instance->enrolperiod = $data->enrolperiod;
            $instance->enrolstartdate = $data->enrolstartdate;
            $instance->enrolenddate = $data->enrolenddate;
            $instance->expirynotify = $data->expirynotify;
            $instance->notifyall = $data->notifyall;
            $instance->expirythreshold = $data->expirythreshold;
            $instance->timemodified = time();
            $DB->update_record('enrol', $instance);

            $enrolid = $instance->id;
            if ($reset) {
                $context->mark_dirty();
            }

        } else {
            $fields = [
                'status' => $data->status,
                'name' => $data->name,
                'cost' => unformat_float($data->cost),
                'currency' => $data->currency,
                'roleid' => $data->roleid,
                'enrolperiod' => $data->enrolperiod,
                'enrolstartdate' => $data->enrolstartdate,
                'enrolenddate' => $data->enrolenddate,
                'expirynotify' => $data->expirynotify,
                'notifyall' => $data->notifyall,
                'customtext1' => $data->customtext1,
                'customtext2' => $data->customtext2,
                'customint1' => $data->customint1,
                'expirythreshold' => $data->expirythreshold,
            ];
            $enrolid = $plugin->add_instance($course, $fields);
        }

        enrol_coursepayment_helper::update_profile_pricing($enrolid , $data);

        redirect($return);
    }
}

$PAGE->set_heading($course->fullname);
$PAGE->set_title(get_string('pluginname', 'enrol_coursepayment'));

echo $OUTPUT->header();
echo $OUTPUT->heading(get_string('pluginname', 'enrol_coursepayment'));
$mform->display();
echo $OUTPUT->footer();
