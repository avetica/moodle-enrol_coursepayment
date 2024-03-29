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
 * Handles position elements on the PDF via drag and drop.
 *
 * @package    enrol_coursepayment
 * @copyright  2013 Mark Nelson <markn@moodle.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once(__DIR__ . '/../../../config.php');
defined('MOODLE_INTERNAL') || die;

// The page of the coursepayment invoice we are editing.
$pid = required_param('pid', PARAM_INT);

$page = $DB->get_record('coursepayment_pages', ['id' => $pid], '*', MUST_EXIST);
$template = $DB->get_record('coursepayment_templates', ['id' => $page->templateid], '*', MUST_EXIST);
$elements = $DB->get_records('coursepayment_elements', ['pageid' => $pid], 'sequence');

// Set the template.
$template = new \enrol_coursepayment\invoice\template($template);
// Perform checks.
require_login();

// Make sure the user has the required capabilities.
$template->require_manage();

// Set the $PAGE settings.
$pageurl = new moodle_url('/enrol/coursepayment/view/invoice_rearrange.php', ['pid' => $pid]);
\enrol_coursepayment\invoice\page_helper::page_setup($pageurl, $template->get_context());

$str = get_string('editinvoice', 'enrol_coursepayment');
$link = new moodle_url('/enrol/coursepayment/view/invoice_edit.php', ['tid' => $template->get_id()]);
$PAGE->navbar->add($str, new action_link($link, $str));

$PAGE->navbar->add(get_string('rearrangeelements', 'enrol_coursepayment'));

// Include the JS we need.
$PAGE->requires->yui_module('moodle-enrol_coursepayment-rearrange', 'Y.M.enrol_coursepayment.rearrange.init',
    [
        $template->get_id(),
        $page,
        $elements,
    ]);

// Create the buttons to save the position of the elements.
$html = html_writer::start_tag('div', ['class' => 'buttons']);
$html .= $OUTPUT->single_button(new moodle_url('/enrol/coursepayment/view/invoice_edit.php', ['tid' => $template->get_id()]),
    get_string('saveandclose', 'enrol_coursepayment'), 'get', ['class' => 'savepositionsbtn']);
$html .= $OUTPUT->single_button(new moodle_url('/enrol/coursepayment/view/invoice_rearrange.php', ['pid' => $pid]),
    get_string('saveandcontinue', 'enrol_coursepayment'), 'get', ['class' => 'applypositionsbtn']);
$html .= $OUTPUT->single_button(new moodle_url('/enrol/coursepayment/view/invoice_edit.php', ['tid' => $template->get_id()]),
    get_string('cancel'), 'get', ['class' => 'cancelbtn']);
$html .= html_writer::end_tag('div');

// Create the div that represents the PDF.
$style = 'height: ' . $page->height . 'mm; line-height: normal; width: ' . $page->width . 'mm;';
$marginstyle = 'height: ' . $page->height . 'mm; width:1px; float:left; position:relative;';
$html .= html_writer::start_tag('div', [
        'data-templateid' => $template->get_id(),
        'data-contextid' => $template->get_contextid(),
        'id' => 'pdf',
        'style' => $style,
    ]
);
if ($page->leftmargin) {
    $position = 'left:' . $page->leftmargin . 'mm;';
    $html .= "<div id='leftmargin' style='$position $marginstyle'></div>";
}
if ($elements) {
    foreach ($elements as $element) {
        // Get an instance of the element class.
        if ($e = \enrol_coursepayment\invoice\element_factory::get_element_instance($element)) {
            switch ($element->refpoint) {
                case \enrol_coursepayment\invoice\element_helper::COURSEPAYMENT_REF_POINT_TOPRIGHT:
                    $class = 'element refpoint-right';
                    break;
                case \enrol_coursepayment\invoice\element_helper::COURSEPAYMENT_REF_POINT_TOPCENTER:
                    $class = 'element refpoint-center';
                    break;
                case \enrol_coursepayment\invoice\element_helper::COURSEPAYMENT_REF_POINT_TOPLEFT:
                default:
                    $class = 'element refpoint-left';
            }
            $html .= html_writer::tag('div', $e->render_html(), [
                'class' => $class,
                'data-refpoint' => $element->refpoint,
                'id' => 'element-' . $element->id,
            ]);
        }
    }
}
if ($page->rightmargin) {
    $position = 'left:' . ($page->width - $page->rightmargin) . 'mm;';
    $html .= "<div id='rightmargin' style='$position $marginstyle'></div>";
}
$html .= html_writer::end_tag('div');

echo $OUTPUT->header();
echo $OUTPUT->heading(get_string('rearrangeelementsheading', 'enrol_coursepayment'), 4);
echo $html;
$PAGE->requires->js_call_amd('enrol_coursepayment/rearrange-area', 'init', ['#pdf']);
echo $OUTPUT->footer();
