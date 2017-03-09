/**
 * Gateway
 *
 * @package   enrol_coursepayment
 * @copyright 2015 MoodleFreak.com
 * @author    Luuk Verhoeven
 */
M.enrol_coursepayment_gateway = {
    config:           {
        'courseid': 0,
        'sesskey':  '',
        'ajaxurl':  ''
    },
    log:              function (val) {
        try {
            Y.log(val);

        } catch (e) {
            try {
                console.log(val);
            } catch (e) {
            }
        }
    },
    init:             function (Y, ajaxurl, sesskey, courseid) {
        M.enrol_coursepayment_gateway.log('Load: M.enrol_coursepayment_gateway');

        // Set config
        this.config.courseid = courseid;
        this.config.ajaxurl = ajaxurl;
        this.config.sesskey = sesskey;

        M.enrol_coursepayment_gateway.log(this.config);
        if (Y.one('#discountcode')) {
            this.validatediscount();
        }
        if(Y.one('#coursepayment_agreement')){
            this.validate_agreement();
        }
    },
    /**
     * Validate agreement checkbox on form submit.
     */
    validate_agreement: function () {
        M.enrol_coursepayment_gateway.log('validate_agreement()');
        Y.all('.coursepayment_mollie_form').on("submit" , function (e) {

            if(!Y.one('#coursepayment_agreement').get('checked')){
                e.preventDefault();
            }
        });
    },
    /**
     * Validate discount code.
     */
    validatediscount: function () {
        M.enrol_coursepayment_gateway.log('validatediscount()');

        var costorignal = Y.one('#coursepayment_cost').get("text");
        M.enrol_coursepayment_gateway.log(costorignal);

        Y.one('#discountcode').on("keyup", function (e) {

            var config = M.enrol_coursepayment_gateway.config;
            Y.io(config.ajaxurl, {
                method:  'GET',
                data:    {
                    'action':   'discountcode',
                    'courseid': config.courseid,
                    'sesskey':  config.sesskey,
                    'data':     Y.one('#discountcode').get('value')
                },
                on:      {
                    success: function (id, o) {
                        try {
                            var response = Y.JSON.parse(o.responseText);
                            if (response.error) {
                                Y.one('#discountcode').setStyle('border', '1px solid red');
                                Y.one('#error_coursepayment').setHTML(response.error);
                                Y.one('#coursepayment_cost').setHTML(costorignal);
                            }
                            else if (response.status == true) {
                                Y.one('#error_coursepayment').setHTML('');
                                Y.one('#discountcode').setStyle('border', '1px solid green');
                                // Update

                                if (response.amount > 0) {
                                    var newprice = parseFloat(costorignal) - response.amount;
                                    if (newprice < 0) {
                                        newprice = 0;
                                    }

                                    Y.one('#coursepayment_cost').setHTML(costorignal + '<br/><span style="color:green">(- ' + response.amount + ') = ' + newprice.toFixed(2) + '</span>');
                                }
                                else {
                                    var newprice = (parseFloat(costorignal) / 100)  * (100 - response.percentage) ;
                                    if (newprice < 0) {
                                        newprice = 0;
                                    }
                                    Y.one('#coursepayment_cost').setHTML(costorignal + '<br/><span style="color:green">(- ' + parseInt(response.percentage) + '%) = ' + newprice.toFixed(2) + '</span>');
                                }
                            }
                            M.enrol_coursepayment_gateway.log(response);
                        } catch (e) {
                            // exception
                            M.enrol_coursepayment_gateway.log(e);
                        }
                    },
                    failure: function (x, o) {
                        M.enrol_coursepayment_gateway.log("Async call failed!");

                    }
                },
                headers: {
                    'Content-Type': 'application/json'
                }
            })
        })
    }
}