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
 * This file contains the form element for handling the colour picker.
 *
 * @package    enrol_coursepayment
 * @copyright  2013 Mark Nelson <markn@moodle.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace enrol_coursepayment\invoice;

use html_writer;
use renderer_base;

defined('MOODLE_INTERNAL') || die('Direct access to this script is forbidden.');

global $CFG;
require_once($CFG->dirroot . '/lib/form/editor.php');

/**
 * Form element for handling the colour picker.
 *
 * @package    enrol_coursepayment
 * @copyright  2013 Mark Nelson <markn@moodle.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class colourpicker extends \moodlequickform_editor {

    /**
     * Sets the value of the form element
     *
     * @param string $value
     *
     * @return void
     */
    public function setvalue($value): void {
        $this->updateAttributes(['value' => $value]);
    }

    /**
     * Gets the value of the form element
     *
     * @return string
     */
    public function getvalue(): string {
        return $this->getAttribute('value');
    }

    /**
     * Returns the html string to display this element.
     *
     * @return string
     * @throws \coding_exception
     */
    public function tohtml(): string {
        global $PAGE, $OUTPUT;

        $PAGE->requires->js_init_call('M.util.init_colour_picker', [$this->getAttribute('id'), null]);
        $content = '<label class="accesshide" for="' . $this->getAttribute('id') . '" >' . $this->getLabel() . '</label>';
        $content .= html_writer::start_tag('div', ['class' => 'form-colourpicker defaultsnext']);
        $content .= html_writer::tag('div', $OUTPUT->pix_icon('i/loading', get_string('loading', 'admin'), 'moodle',
            ['class' => 'loadingicon']), ['class' => 'admin_colourpicker clearfix']);
        $content .= html_writer::empty_tag('input', [
            'type' => 'text',
            'id' => $this->getAttribute('id'),
            'name' => $this->getName(),
            'value' => $this->getValue(),
            'size' => '12',
        ]);
        $content .= html_writer::end_tag('div');

        return $content;
    }

    /**
     * Function to export the renderer data in a format that is suitable for a mustache template.
     *
     * @param renderer_base $output Used to do a final render of any components that need to be rendered for export.
     *
     * @return array
     * @throws \coding_exception
     */
    public function export_for_template(renderer_base $output): array {
        $context = $this->export_for_template_base($output);
        $context['html'] = $this->toHtml();

        return $context;
    }

}
