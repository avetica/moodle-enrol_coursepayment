<?php
// This file is part of the customcert module for Moodle - http://moodle.org/
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
 * Provides useful functions related to setting up the page.
 *
 * this part is copied from "mod_customcert" - Mark Nelson <markn@moodle.com>
 * Thanks for allowing us to use it.
 *
 * This file is modified not compatible with the original.
 *
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 *
 * @package   enrol_coursepayment
 * @copyright 2018 MFreak.nl
 * @author    Luuk Verhoeven
 */

namespace enrol_coursepayment\invoice;

/**
 * Class helper.
 *
 * Provides useful functions.
 *
 * @package    enrol_coursepayment
 * @copyright  2016 Mark Nelson <markn@moodle.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class page_helper {

    /**
     * Sets up the page variables.
     *
     * @param \moodle_url $pageurl
     * @param \context $context
     * @param string $title the page title
     *
     * @throws \coding_exception
     * @throws \moodle_exception
     */
    public static function page_setup(\moodle_url $pageurl, \context $context, string $title = ''): void {
        global $COURSE, $PAGE, $SITE;

        $PAGE->set_url($pageurl);
        $PAGE->set_context($context);
        $PAGE->set_title(format_string($title));

        // If we are in the system context then we are managing templates, and we want to show that in the navigation.
        if ($context->contextlevel === CONTEXT_SYSTEM) {
            $PAGE->set_pagelayout('admin');
            $PAGE->set_heading($SITE->fullname);

            $urloverride = new \moodle_url('/admin/settings.php?section=modsettingcustomcert');
            \navigation_node::override_active_url($urloverride);
        } else {
            $PAGE->set_heading(format_string($COURSE->fullname));
        }
    }

}
