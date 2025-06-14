Ldesign Media - Enrol CoursePayment
====================

With this plugin you can sell courses to your moodle users. There is also a [availability plugin](https://deploy01.avetica.net/technisch-team/moodlefreak/availability_coursepayment/) available.

### Description

This plugin allows you to sell courses with multiple gateways.

Has support for:
* Mollie gateway.
* IPN/Callbacks.
* Query openen transactions every hour with cron.
* Easy to build own extend with another gateway.
* Instance based settings like currency, enrol period.
* Global notification settings.
* A global sandbox and debug switches.
* After successful transaction user will be enrolled.
* Multiple Mollie accounts support, account selection based on matching profile field value.
* Supports iDeal 2.0

### Installation

1. Copy this plugin to the `enrol` folder called `coursepayment`.
2. Login as administrator.
3. Go to Site Administrator > Notification.
4. Install the plugin.
5. Register on the gateway page you interested at.
6. Add global settings and your gateway settings.
7. Enable enrollment plugin by going to `/admin/settings.php?section=manageenrols`. 

##### Requirements:

* Requires at least: Moodle 3.9
* Supports PHP: 7.4, 8.0, 8.1

![Moodle39](https://img.shields.io/badge/moodle-3.9-brightgreen.svg)
![Moodle310](https://img.shields.io/badge/moodle-3.10-brightgreen.svg)
![Moodle311](https://img.shields.io/badge/moodle-3.11-brightgreen.svg)
![Moodle4005](https://img.shields.io/badge/moodle-4.0.5-brightgreen.svg)
![Moodle41](https://img.shields.io/badge/moodle-4.1-brightgreen.svg)
![Moodle43](https://img.shields.io/badge/moodle-4.3-brightgreen.svg)
![Moodle44](https://img.shields.io/badge/moodle-4.4-brightgreen.svg)
![Moodle45](https://img.shields.io/badge/moodle-4.5-brightgreen.svg)

![PHP7.4](https://img.shields.io/badge/PHP-7.4-brightgreen.svg)
![PHP8.0](https://img.shields.io/badge/PHP-8.0-brightgreen.svg)
![PHP8.1](https://img.shields.io/badge/PHP-8.1-brightgreen.svg)

### Changelog

See Git for the complete history, major changes will be listed below.

- 2025060300 - upcoming changes to API identifiers
- 2025040100 - profile fields support.
- 2025012800 - iDeal 2.0 support implemented, Mollie PHP Client version updated to v2.76.1.
- 2024091300 - Moodle 4.5 support implemented.
- 2024042900 - Moodle 4.4 support implemented.
- 2024041100 - Moodle 4.3 support implemented.
- 2022120300 - Moodle 4.1 support implemented.
- 2022120200 - Moodle workplace 4.0.5 support implemented.
- 2020103000 - Moodle 3.11 support implemented.
- 2020103000 - Moodle 3.10 support implemented.
- 2020012800 - Moodle 3.9 support implemented, only supports PHP 7.2 and higher.
- 2020012800 - Mollie connect is required for new installations.
- 2020011500 - Upgrade Mollie API to the latest version, using composer/vendor now.
- 2020010200 - Moodle 3.8 support implemented.
- 2019052800 - Moodle 3.7 support implemented.
- 2019052000 - Mollie account claim removed.
- 2018110601 - PDF Invoice generation added.
- 2018070500 - Added privacy provider GDPR.
- 2018070500 - Git folder structure changed.
- 2018010800 - Added support focustom transaction Mollie description.
- 2017082101 - Added multi account option, to support multiple Mollie accounts.
   The correct payment account is selected based on profile field.
- 2017021701 - Added reseller support and direct account create function.
- 2017021000 - Added latest https://github.com/mollie/mollie-api-php
- 2016111200 - Support for availability_coursepayment, purchase a single activity.
- 2015061202 - Intergration of customable vat percentage per instance and global.
- 2015061201 - We added invoice mail support.

### Security Vulnerabilities

If you discover any security vulnerabilities, please send an e-mail via [luuk@ldesignmedia.nl](luuk@ldesignmedia.nl)

### License

This project is licensed under the **GNU General Public License v3.0**. - http://www.gnu.org/licenses or see
the [LICENSE](LICENSE) file.

### Copyright

<img src="https://avetica.nl/logo.svg" alt="avetica logo" width="250px">

Copyright © 2022 Avetica :: [Avetica.nl](https://avetica.nl/)

##### Author

* Luuk Verhoeven :: [Ldesign Media](https://ldesignmedia.nl/) - [luuk@ldesignmedia.nl](luuk@ldesignmedia.nl)
* Hamza Tamyachte :: [Ldesign Media](https://ldesignmedia.nl/) -  [hamza.tamyachte@ldesignmedia.nl](hamza.tamyachte@ldesignmedia.nl)

<img src="https://ldesignmedia.nl/themes/ldesignmedia/assets/images/logo/logo.svg" alt="ldesignmedia" height="70px">
