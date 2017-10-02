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
 * 
 *
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 *
 * @package coursepayment
 * @copyright 2017 MoodleFreak.com
 * @author    Luuk Verhoeven
 **/
namespace enrol_coursepayment\output;
defined('MOODLE_INTERNAL') || die;

use renderable;
use stdClass;
use templatable;
use renderer_base;

class multi_account implements renderable, templatable {


    /**
     * Export this data so it can be used as the context for a mustache template.
     *
     * @param renderer_base $output
     *
     * @return stdClass
     */
    public function export_for_template(renderer_base $output) {
        global $DB;
        $multiaccounts = $DB->get_records('coursepayment_multiaccount');

        $object = new stdClass();
        $object->data = array_values($multiaccounts);

        return $object;
    }
 }