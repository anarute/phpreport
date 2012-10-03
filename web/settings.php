<?php
/*
 * Copyright (C) 2012 Igalia, S.L. <info@igalia.com>
 *
 * This file is part of PhpReport.
 *
 * PhpReport is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * PhpReport is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with PhpReport.  If not, see <http://www.gnu.org/licenses/>.
 */

/**
 * System settings UI
 *
 * @filesource
 * @package PhpReport
 * @subpackage UI
 * @author Jacobo Aragunde Pérez <jaragunde@igalia.com>
 */

define('PHPREPORT_ROOT', __DIR__ . '/../');

/* We check authentication and authorization */
require_once(PHPREPORT_ROOT . '/web/auth.php');

include_once(PHPREPORT_ROOT . '/model/facade/TasksFacade.php');

/* There are POST data: we try to save the settings */
if(isset($_POST["numberOfDays"])) {
    $enabled = false;
    if(isset($_POST["enabled"])) {
        $enabled = true;
    }
    var_dump(TasksFacade::SetTaskBlockConfiguration($enabled, $_POST["numberOfDays"]));
}

/* Include the generic header and sidebar*/
define('PAGE_TITLE', "PhpReport - Settings");
include("include/header.php");
include("include/sidebar.php");
?>

<div id="content">
    <!-- Here we inject the form from the JavaScript code -->
</div>

<script>
Ext.onReady(function () {

    var sendFormFunction = function () {
        form.getForm().getEl().dom.action = 'settings.php';
        form.getForm().getEl().dom.method = 'POST';
        form.getForm().submit();
    };

    var form = new Ext.form.FormPanel({
        standardSubmit: true,
        frame: true,
        title: 'Task report block settings',

        width: 250,
        defaults: {width: 130},
        items: [{
                fieldLabel: 'Block enabled',
                xtype: 'checkbox',
                name: 'enabled',
            },{
                fieldLabel: 'Number of days',
                xtype: 'numberfield',
                name: 'numberOfDays'
            }
        ],
        buttons: [{
            text: 'Save',
            handler: sendFormFunction
        }],
        keys: [{
            key: [Ext.EventObject.ENTER],
            handler: sendFormFunction
        }]
    });

    form.render('content');
});
</script>

<?php
/* Include the footer to close the header */
include("include/footer.php");
?>
