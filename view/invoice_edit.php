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
 * Edit invoice details.
 *
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 *
 * @package   enrol_coursepayment
 * @copyright 26-10-2018 MFreak.nl
 * @author    Luuk Verhoeven
 **/

require_once(__DIR__ . '/../../../config.php');
defined('MOODLE_INTERNAL') || die;
require_login();

$context = context_system::instance();

if (!has_capability('enrol/coursepayment:config', $context)) {
    $errormessage = get_string('error:capability_config', 'enrol_coursepayment');
    throw new required_capability_exception($context, 'enrol/coursepayment:config', $errormessage, '');
}
$PAGE->navbar->add(get_string('pluginname', 'enrol_coursepayment'),
    new moodle_url('/admin/settings.php', ['section' => 'enrolsettingscoursepayment']));
$PAGE->navbar->add(get_string('enrol_coursepayment_invoice_edit', 'enrol_coursepayment'));
$PAGE->set_context($context);
$PAGE->set_title(get_string('enrol_coursepayment_invoice_edit', 'enrol_coursepayment'));

$invoicetype = optional_param('invoicetype', 'default', PARAM_ALPHA);
$id = optional_param('id', false, PARAM_INT);
$action = optional_param('action', false, PARAM_ALPHA);

$PAGE->set_url('/enrol/coursepayment/view/invoice_edit.php', [
    'id' => $id,
    'action' => $action,
]);

$tid = optional_param('tid', 1, PARAM_INT);
$action = optional_param('action', '', PARAM_ALPHA);
$contextid = context_system::instance()->id;

if ($action) {
    $actionid = required_param('aid', PARAM_INT);
}
$confirm = optional_param('confirm', 0, PARAM_INT);

// Create the template object.
$template = $DB->get_record('coursepayment_templates', ['id' => $tid], '*', MUST_EXIST);
$template = new \enrol_coursepayment\invoice\template($template);
// Set the context.
$contextid = $template->get_contextid();
// Set the page url.
$pageurl = new moodle_url('/enrol/coursepayment/view/invoice_edit.php', ['tid' => $tid]);

$context = context::instance_by_id($contextid);

// Flag to determine if we are deleting anything.
$deleting = false;

if ($tid) {
    if ($action && confirm_sesskey()) {
        switch ($action) {
            case 'pmoveup' :
                $template->move_item('page', $actionid, 'up');
                break;
            case 'pmovedown' :
                $template->move_item('page', $actionid, 'down');
                break;
            case 'emoveup' :
                $template->move_item('element', $actionid, 'up');
                break;
            case 'emovedown' :
                $template->move_item('element', $actionid, 'down');
                break;
            case 'addpage' :
                $template->add_page();
                $url = new moodle_url('/enrol/coursepayment/view/invoice_edit.php', ['tid' => $tid]);
                redirect($url);
                break;
            case 'deletepage' :
                if (!empty($confirm)) { // Check they have confirmed the deletion.
                    $template->delete_page($actionid);
                    $url = new moodle_url('/enrol/coursepayment/view/invoice_edit.php', ['tid' => $tid]);
                    redirect($url);
                } else {
                    // Set deletion flag to true.
                    $deleting = true;
                    // Create the message.
                    $message = get_string('deletepageconfirm', 'enrol_coursepayment');
                    // Create the link options.
                    $nourl = new moodle_url('/enrol/coursepayment/view/invoice_edit.php', ['tid' => $tid]);
                    $yesurl = new moodle_url('/enrol/coursepayment/view/invoice_edit.php',
                        [
                            'tid' => $tid,
                            'action' => 'deletepage',
                            'aid' => $actionid,
                            'confirm' => 1,
                            'sesskey' => sesskey(),
                        ]
                    );
                }
                break;
            case 'deleteelement' :
                if (!empty($confirm)) { // Check they have confirmed the deletion.
                    $template->delete_element($actionid);
                } else {
                    // Set deletion flag to true.
                    $deleting = true;
                    // Create the message.
                    $message = get_string('deleteelementconfirm', 'enrol_coursepayment');
                    // Create the link options.
                    $nourl = new moodle_url('/enrol/coursepayment/view/invoice_edit.php', ['tid' => $tid]);
                    $yesurl = new moodle_url('/enrol/coursepayment/view/invoice_edit.php',
                        [
                            'tid' => $tid,
                            'action' => 'deleteelement',
                            'aid' => $actionid,
                            'confirm' => 1,
                            'sesskey' => sesskey(),
                        ]
                    );
                }
                break;
        }
    }
}

// Check if we are deleting either a page or an element.
if ($deleting) {
    // Show a confirmation page.
    $PAGE->navbar->add(get_string('deleteconfirm', 'enrol_coursepayment'));
    echo $OUTPUT->header();
    echo $OUTPUT->confirm($message, $yesurl, $nourl);
    echo $OUTPUT->footer();
    exit();
}

if ($tid) {
    $mform = new \enrol_coursepayment\invoice\edit_form($pageurl, ['tid' => $tid]);
    // Set the name for the form.
    $mform->set_data(['name' => $template->get_name()]);
} else {
    $mform = new \enrol_coursepayment\invoice\edit_form($pageurl);
}

if ($data = $mform->get_data()) {
    // If there is no id, then we are creating a template.
    if (!$tid) {
        $template = \enrol_coursepayment\invoice\template::create($data->name, $contextid);

        // Create a page for this template.
        $pageid = $template->add_page();

        // Associate all the data from the form to the newly created page.
        $width = 'pagewidth_' . $pageid;
        $height = 'pageheight_' . $pageid;
        $leftmargin = 'pageleftmargin_' . $pageid;
        $rightmargin = 'pagerightmargin_' . $pageid;

        $data->$width = $data->pagewidth_0;
        $data->$height = $data->pageheight_0;
        $data->$leftmargin = $data->pageleftmargin_0;
        $data->$rightmargin = $data->pagerightmargin_0;

        // We may also have clicked to add an element, so these need changing as well.
        if (isset($data->element_0) && isset($data->addelement_0)) {
            $element = 'element_' . $pageid;
            $addelement = 'addelement_' . $pageid;
            $data->$element = $data->element_0;
            $data->$addelement = $data->addelement_0;

            // Need to remove the temporary element and add element placeholders so we
            // don't try add an element to the wrong page.
            unset($data->element_0);
            unset($data->addelement_0);
        }
    }

    // Save any data for the template.
    $template->save($data);

    // Save any page data.
    $template->save_page($data);

    // Loop through the data.
    foreach ($data as $key => $value) {
        // Check if they chose to add an element to a page.
        if (strpos($key, 'addelement_') !== false) {
            // Get the page id.
            $pageid = str_replace('addelement_', '', $key);
            // Get the element.
            $element = "element_" . $pageid;
            $element = $data->$element;
            // Create the URL to redirect to to add this element.
            $params = [];
            $params['tid'] = $template->get_id();
            $params['action'] = 'add';
            $params['element'] = $element;
            $params['pageid'] = $pageid;
            $url = new moodle_url('/enrol/coursepayment/view/invoice_edit_element.php', $params);
            redirect($url);
        }
    }

    // Check if we want to preview this custom certificate.
    if (!empty($data->previewbtn)) {

        $template->generate_pdf(true);
        exit();
    }

    // Redirect to the editing page to show form with recent updates.
    $url = new moodle_url('/enrol/coursepayment/view/invoice_edit.php', ['tid' => $template->get_id()]);
    redirect($url);
}

echo $OUTPUT->header();
$mform->display();
echo $OUTPUT->footer();
