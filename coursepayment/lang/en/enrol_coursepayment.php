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
 * language file for coursepayment
 *
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 *
 * @package   enrol_coursepayment
 * @copyright 2015 MoodleFreak.com
 * @author    Luuk Verhoeven
 */

$string['pluginname'] = 'CoursePayment';
$string['pluginname_desc'] = 'This plugin allows you to purchase course with a payment gateway';
$string['mailadmins'] = 'Notify admin';
$string['nocost'] = 'There is no cost associated with enrolling in this course!';
$string['currency'] = 'Currency';
$string['cost'] = 'Enrol cost';
$string['assignrole'] = 'Assign role';
$string['welcomemail'] = 'Welcome mail';
$string['invoicemail'] = 'Invoice mail';
$string['mailstudents'] = 'Notify students';
$string['mailteachers'] = 'Notify teachers';
$string['expiredaction'] = 'Enrolment expiration action';
$string['expiredaction_help'] = 'Select action to carry out when user enrolment expires. Please note that some user data and settings are purged from course during course unenrolment.';
$string['status'] = 'Allow CoursePayment enrolments';
$string['status_desc'] = 'Allow users to use CoursePayment to enrol into a course by default.';
$string['defaultrole'] = 'Default role assignment';
$string['defaultrole_desc'] = 'Select role which should be assigned to users during CoursePayment enrolments';
$string['enrolenddate'] = 'End date';
$string['enrolenddate_help'] = 'If enabled, users can be enrolled until this date only.';
$string['enrolenddaterror'] = 'Enrolment end date cannot be earlier than start date';
$string['enrolperiod'] = 'Enrolment duration';
$string['enrolperiod_desc'] = 'Default length of time that the enrolment is valid. If set to zero, the enrolment duration will be unlimited by default.';
$string['enrolstartdate'] = 'Start date';
$string['enrolstartdate_help'] = 'If enabled, users can be enrolled from this date onward only.';
$string['enrolperiod_help'] = 'Length of time that the enrolment is valid, starting with the moment the user is enrolled. If disabled, the enrolment duration will be unlimited.';
$string['debug'] = 'Debug';
$string['debug_desc'] = 'Should only be enabled by developers this outputs debug messages';
$string['sandbox'] = 'Sandbox';
$string['sandbox_desc'] = 'Only for testing purposes should not be enabeld. User can enrol in course without paying. For mollie this has no effect';
$string['enabled'] = 'Enabled';
$string['error:failed_getting_plugin_instance'] = 'Failed getting instance details!';
$string['crontask'] = 'CoursePayment - process orders';
$string['title:returnpage'] = 'Payment Status';
$string['success_enrolled'] = 'Thanks for your purchase.<br> We have enrolled you for: {$a->fullname}';
$string['error:unknown_order'] = 'Unknown order we don\'t have a record of it!';
$string['error:gettingorderdetails'] = 'We were unable to query the gateway for order details. We will retry later.';
$string['error:paymentabort'] = 'The payment is aborted!';
$string['error:no_record'] = 'Error: Not exists!';
$string['error:not_within_the_time_period'] = 'Error: Not valid within this time period!';
$string['error:not_for_this_course'] = 'Error: This discountcode is for another course!';
$string['gateway_not_exists'] = 'Error! Gateway not exists';
$string['enabled_desc'] = 'Status of the gateway if this can be used to create a transaction';
$string['expiredaction'] = 'Enrolment expiration action';
$string['expiredaction_help'] = 'Select action to carry out when user enrolment expires. Please note that some user data and settings are purged from course during course unenrolment.';
$string['expirymessageenrollersubject'] = 'Enrolment expiry notification';
$string['expirymessageenrollerbody'] = 'Enrolment in the course \'{$a->course}\' will expire within the next {$a->threshold} for the following users:

{$a->users}

To extend their enrolment, go to {$a->extendurl}';
$string['expirymessageenrolledsubject'] = 'Enrolment expiry notification';
$string['expirymessageenrolledbody'] = 'Dear {$a->user},

This is a notification that your enrolment in the course \'{$a->course}\' is due to expire on {$a->timeend}.

If you need help, please contact {$a->enroller}.';
$string['purchase'] = 'Purchase course';
$string['provider'] = 'Provider';
$string['name'] = 'Name';
$string['minimum'] = 'Minimum';
$string['maximum'] = 'Maximum';
$string['instancedesc'] = 'Description';
$string['gateway_mollie_issuers'] = 'Select a bank';
$string['gateway_mollie_select_method'] = 'Please click the method you like to use.';
$string['gateway_mollie'] = 'Gateway: Mollie';
$string['gateway_mollie_desc'] = 'Offer your customers the payment methods Creditcard, SOFORT Banking, iDEAL, Bancontact/Mister Cash, Bank transfer, Bitcoin, PayPal or paysafecard. Mollie is known for reliability, transparency, nice API’s and ready-to-go modules.';
$string['gateway_mollie_apikey'] = 'API key';
$string['gateway_mollie_link'] = 'If you don\'t have a account please <a href=" https://www.mollie.com/en/signup/1787751">register</a>';
$string['gateway_mollie_send_button'] = 'Purchase with mollie';
$string['error:capability_config'] = 'Error: You need the coursepayment/config capability!';
$string['enrol_coursepayment_discount'] = 'Discount';
$string['enrol_coursepayment_discount_desc'] = 'Discount codes to distribute to your customers can be created in the discount manager. <br/><br/><a href="{$a->link}" class="btn btn-small btn-primary">Discount manager</a>';

$string['new:discountcode'] = 'Add a new discount code';
$string['th:code'] = 'Code';
$string['th:courseid'] = 'Course';
$string['th:start_time'] = 'From';
$string['th:end_time'] = 'End';
$string['th:amount'] = 'Discount';
$string['th:action'] = 'Action';

$string['form:allcourses'] = 'Complete website';
$string['form:code'] = 'Code to get the discount<br> (make sure its unique)';
$string['form:discountcode'] = 'Discount code';
$string['form:start_time'] = 'Valid from';
$string['form:end_time'] = 'Valid to';
$string['form:save'] = 'Save';
$string['form:amount'] = 'Amount of discount';
$string['form:percentage'] = 'Percentage of discount';

$string['error:number_to_low'] = 'This number is to low';
$string['error:price_wrongformat'] = 'This isn\'t numeric!';
$string['error:code_not_unique'] = 'Discount code needs to be unique';

$string['discount_code_desc'] = 'If you have a discount code enter it below';
$string['discountcode_invalid'] = 'Error: This code isn\'t valid anymore or is incorrect for this course!';
$string['vatpercentages'] = 'VAT Percentage included in the cost';

$string['invoicedetails'] = 'Invoice details';
$string['invoicedetails_desc'] = 'This fields are required! When you leave them blank the generate invoice will be incorrect.';
$string['btw'] = 'VAT';
$string['kvk'] = 'kvk';
$string['place'] = 'Place';
$string['zipcode'] = 'Zipcode';
$string['address'] = 'Address';
$string['companyname'] = 'Companyname';

$string['mail:invoice_subject'] = 'Thank you for ordering: {$a->course} / {$a->fullname}';
$string['mail:invoice_message'] = '<h2>INVOICE</h2>
<br/>
<b>{$a->companyname}</b><br/>
{$a->address}<br/>
{$a->zipcode} {$a->place}<br/>
<br/>
KvK: {$a->kvk}<br/>
VAT: {$a->btw}<br/>
<br/>
Invoice number: {$a->invoice_number}<br/>
Date: {$a->date}<br/>
<br/>
<br/>
To:<br/>
<b>{$a->fullname}</b><br/>
{$a->email}<br/>
<br/>
<table cellpadding="0" cellspacing="0" style="margin:0;padding:0;width: 100%">
    <tr>
        <td colspan="2">Course: {$a->fullcourse}</td>
    </tr>
    <tr>
        <td colspan="2">&nbsp;</td>
    </tr>
    <tr>
        <td style="width: 30%">VAT ({$a->vatpercentage}%)</td>
        <td>{$a->currency} {$a->costvat}</td>
    </tr>
     <tr>
        <td>Total cost</td>
        <td>{$a->currency} {$a->cost}</td>
    </tr>
</table><br/><br/>
Purchased {$a->date} and paid through <b>{$a->method}</b>';

$string['coursepayment:config'] = 'Configuration';
$string['coursepayment:manage'] = 'Manage';
$string['coursepayment:unenrol'] = 'Unenrol';
$string['coursepayment:unenrolself'] = 'Unenrolself';