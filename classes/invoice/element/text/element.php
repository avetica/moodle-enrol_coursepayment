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
 * This file contains the customcert element text's core interaction API.
 *
 * @package    coursepaymentelement_text
 * @copyright  2013 Mark Nelson <markn@moodle.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace enrol_coursepayment\invoice\element\text;

defined('MOODLE_INTERNAL') || die();

/**
 * The customcert element text's core interaction API.
 *
 * @package    coursepaymentelement_text
 * @copyright  2013 Mark Nelson <markn@moodle.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class element extends \enrol_coursepayment\invoice\element {

    /**
     * This function renders the form elements when adding a customcert element.
     *
     * @param \enrol_coursepayment\invoice\edit_element_form $mform the edit_form instance
     *
     * @throws \coding_exception
     */
    public function render_form_elements($mform) {
        $mform->addElement('textarea', 'text', get_string('text', 'coursepaymentelement_text'));
        $mform->setType('text', PARAM_RAW);
        $mform->addHelpButton('text', 'text', 'coursepaymentelement_text');

        parent::render_form_elements($mform);
    }

    /**
     * This will handle how form data will be saved into the data column in the
     * customcert_elements table.
     *
     * @param \stdClass $data the form data
     * @return string the text
     */
    public function save_unique_data($data) {
        return $data->text;
    }

    /**
     * Handles rendering the element on the pdf.
     *
     * @param \pdf      $pdf     the pdf object
     * @param bool      $preview true if it is a preview, false otherwise
     * @param \stdClass $user    the user we are rendering this for
     * @throws \dml_exception
     */
    public function render($pdf, $preview, $user) {
        $courseid = \enrol_coursepayment\invoice\element_helper::get_courseid($this->get_id());
        $text = format_text($this->get_data(), FORMAT_HTML, ['context' => \context_course::instance($courseid)]);
        \enrol_coursepayment\invoice\element_helper::render_content($pdf, $this, $text);
    }

    /**
     * Render the element in html.
     *
     * This function is used to render the element when we are using the
     * drag and drop interface to position it.
     *
     * @return string the html
     * @throws \dml_exception
     */
    public function render_html() {
        $courseid = \enrol_coursepayment\invoice\element_helper::get_courseid($this->get_id());
        $text = format_text($this->get_data(), FORMAT_HTML, ['context' => \context_course::instance($courseid)]);
        return \enrol_coursepayment\invoice\element_helper::render_html_content($this, $text);
    }

    /**
     * Sets the data on the form when editing an element.
     *
     * @param \enrol_coursepayment\invoice\edit_element_form $mform the edit_form instance
     */
    public function definition_after_data($mform) {
        if (!empty($this->get_data())) {
            $element = $mform->getElement('text');
            $element->setValue($this->get_data());
        }
        parent::definition_after_data($mform);
    }
}
