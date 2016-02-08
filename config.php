<?php
/**
 * sysMonDash
 *
 * @author    nuxsmin
 * @link      http://cygnux.org
 * @copyright 2012-2016 Rubén Domínguez nuxsmin@cygnux.org
 *
 * This file is part of sysMonDash.
 *
 * sysMonDash is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * sysMonDash is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with sysMonDash.  If not, see <http://www.gnu.org/licenses/>.
 */

use SMD\Core\Config;
use SMD\Core\Language;
use SMD\Core\Session;
use SMD\Http\Request;
use SMD\Util\Util;

define('APP_ROOT', '.');

require APP_ROOT . DIRECTORY_SEPARATOR . 'inc' . DIRECTORY_SEPARATOR . 'Base.php';

$hash = Request::analyze('h');
$hashOk = ($hash === Session::getConfig()->getHash() || empty(Session::getConfig()->getHash()));
?>
<!DOCTYPE html>
<head xmlns="http://www.w3.org/1999/html">
    <meta charset="UTF-8">
    <title><?php echo Language::t(Config::getConfig()->getPageTitle()); ?></title>
    <meta name="author" content="Rubén Domínguez">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="imgs/logo_small.png">
    <script type="text/javascript" src="js/jquery.min.js"></script>
    <script type="text/javascript" src="js/functions.js"></script>
    <link rel="stylesheet" type="text/css" href="css/reset.css">
    <link rel="stylesheet" type="text/css" href="css/pure-min.css">
    <link rel="stylesheet" type="text/css" href="css/styles.css?v=<?php echo Session::getCssHash(); ?>">
    <link rel="stylesheet" type="text/css" href="css/config.css">
</head>
<body>
<div id="logo">
    <img src="imgs/logo.png"/>
    <div id="hora"><h1></h1></div>
    <div id="titulo">
        <h1><?php echo Language::t('Panel Monitorización'); ?></h1>
        <h2><?php echo Language::t('Dpto. Sistemas'); ?></h2>
    </div>
</div>
<div id="wrap">
    <?php if ($hashOk): ?>
        <?php if (Util::checkConfigFile()): ?>
        <form method="post" id="frmConfig" name="frmConfig" class="pure-form pure-form-aligned">
            <fieldset>
                <legend><?php echo Language::t('Aplicación'); ?></legend>
                <div class="flex-wrapper">
                    <div class="pure-control-group">
                        <label for="site_language"><?php echo Language::t('Idioma'); ?></label>
                        <select id="site_language" name="site_language"
                                data-selected="<?php echo Config::getConfig()->getLanguage(); ?>">
                            <option value="es_ES">Español</option>
                            <option value="en_US">English</option>
                        </select>
                    </div class="pure-control-group">
                    <div class="pure-control-group">
                        <label for="site_title"><?php echo Language::t('Título del sitio'); ?></label>
                        <input type="text" id="site_title" name="site_title" class="pure-input-1-2"
                               value="<?php echo Config::getConfig()->getPageTitle(); ?>"/>
                    </div>
                    <div class="pure-control-group">
                        <label for="event_refresh"><?php echo Language::t('Tiempo actualización (s)'); ?></label>
                        <input type="number" id="event_refresh" name="event_refresh" min="5" step="5"
                               value="<?php echo Config::getConfig()->getRefreshValue(); ?>"/>
                    </div>
                    <div class="pure-control-group">
                        <label for="event_new_item_time"><?php echo Language::t('Tiempo nuevo evento (s)'); ?></label>
                        <input type="number" id="event_new_item_time" name="event_new_item_time" min="60" step="60"
                               value="<?php echo Config::getConfig()->getNewItemTime(); ?>"/>
                    </div>
                    <div class="pure-control-group">
                        <label
                            for="event_max_items"><?php echo Language::t('Número máximo de eventos a mostrar'); ?></label>
                        <input type="number" id="event_max_items" name="event_max_items" min="50"
                               value="<?php echo Config::getConfig()->getMaxDisplayItems(); ?>"/>
                    </div>
                    <div class="pure-control-group">
                        <label for="col_last_check"><?php echo Language::t('Mostrar hora de eventos'); ?></label>
                        <input type="checkbox" id="col_last_check"
                               name="col_last_check" <?php echo (Config::getConfig()->isColLastcheck()) ? 'checked' : ''; ?>/>
                    </div>
                    <div class="pure-control-group">
                        <label for="col_host"><?php echo Language::t('Mostrar host de eventos'); ?></label>
                        <input type="checkbox" id="col_host"
                               name="col_host" <?php echo (Config::getConfig()->isColHost()) ? 'checked' : ''; ?>/>
                    </div>
                    <div class="pure-control-group">
                        <label for="col_service"><?php echo Language::t('Mostrar servicio de eventos'); ?></label>
                        <input type="checkbox" id="col_service"
                               name="col_service" <?php echo (Config::getConfig()->isColService()) ? 'checked' : ''; ?>/>
                    </div>
                    <div class="pure-control-group">
                        <label for="col_info"><?php echo Language::t('Mostrar info de eventos'); ?></label>
                        <input type="checkbox" id="col_info"
                               name="col_info" <?php echo (Config::getConfig()->isColStatusInfo()) ? 'checked' : ''; ?>/>
                    </div>
                    <div class="pure-control-group">
                        <label
                            for="regex_host_show"><?php echo Language::t('REGEX hosts visibles en inicio'); ?></label>
                        <input type="text" id="regex_host_show" name="regex_host_show" class="pure-input-1-2"
                               value="<?php echo Config::getConfig()->getRegexHostShow(); ?>"
                               placeholder="(SERVER-|VM-).*"/>
                    </div>
                    <div class="pure-control-group">
                        <label
                            for="regex_services_no_show"><?php echo Language::t('REGEX servicios ocultos en inicio'); ?></label>
                        <input type="text" id="regex_services_no_show" name="regex_services_no_show"
                               class="pure-input-1-2"
                               value="<?php echo Config::getConfig()->getRegexServiceNoShow(); ?>"
                               placeholder="(PRINTER|OldServer).*"/>
                    </div>
                    <div class="pure-control-group">
                        <label for="critical_items"><?php echo Language::t('Elementos críticos'); ?></label>
                        <input type="text" id="critical_items" name="critical_items" class="pure-input-1-2"
                               value="<?php echo implode(',', Config::getConfig()->getCriticalItems()); ?>"
                               placeholder="Dataserver,MailServer,DBServer"/>
                    </div>
                </div>
            </fieldset>
            <fieldset>
                <legend>Backends</legend>
                <div class="flex-wrapper">
                    <div class="pure-control-group">
                        <label for="backend">Backend</label>
                        <select id="backend" name="backend"
                                data-selected="<?php echo Config::getConfig()->getBackend(); ?>">
                            <option value="status">Status</option>
                            <option value="livestatus">Livestatus</option>
                            <option value="zabbix">Zabbix</option>
                        </select>
                    </div>
                    <div class="pure-control-group">
                        <label for="backend_status_file"><?php echo Language::t('Ruta archivo status.dat'); ?></label>
                        <input type="text" id="backend_status_file" name="backend_status_file" class="pure-input-1-2"
                               value="<?php echo Config::getConfig()->getStatusFile(); ?>"
                               placeholder="/var/lib/icinga/status.dat"/>
                    </div>
                    <div class="pure-control-group">
                        <label
                            for="backend_livestatus_file"><?php echo Language::t('Ruta socket livestatus'); ?></label>
                        <input type="text" id="backend_livestatus_file" name="backend_livestatus_file"
                               class="pure-input-1-2"
                               value="<?php echo Config::getConfig()->getLivestatusSocketPath(); ?>"
                               placeholder="/var/lib/icinga/rw/live"/>
                    </div>
                    <div class="pure-control-group">
                        <label for="backend_zabbix_url"><?php echo Language::t('URL API de Zabbix'); ?></label>
                        <input type="text" id="backend_zabbix_url" name="backend_zabbix_url" class="pure-input-1-2"
                               value="<?php echo Config::getConfig()->getZabbixUrl(); ?>"
                               placeholder="http://foo.bar/zabbix/api_jsonrpc.php"/>
                    </div>
                    <div class="pure-control-group">
                        <label for="backend_zabbix_version"><?php echo Language::t('Versión API de Zabbix'); ?></label>
                        <select id="backend_zabbix_version" name="backend_zabbix_version"
                                data-selected="<?php echo Config::getConfig()->getZabbixVersion(); ?>">
                            <option value="223">2.2</option>
                            <option value="243">2.4</option>
                        </select>
                    </div>
                    <div class="pure-control-group">
                        <label for="backend_zabbix_user"><?php echo Language::t('Usuario API de Zabbix'); ?></label>
                        <input type="text" id="backend_zabbix_user" name="backend_zabbix_user"
                               value="<?php echo Config::getConfig()->getZabbixUser(); ?>"/>
                    </div>
                    <div class="pure-control-group">
                        <label for="backend_zabbix_pass"><?php echo Language::t('Clave API de Zabbix'); ?></label>
                        <input type="password" id="backend_zabbix_pass" name="backend_zabbix_pass"/>
                    </div>
                </div>
            </fieldset>
            <fieldset>
                <legend><?php echo Language::t('Especial'); ?></legend>
                <div class="flex-wrapper">
                    <div class="pure-control-group">
                        <label for="special_client_url"><?php echo Language::t('URL del cliente'); ?></label>
                        <input type="text" id="special_client_url" name="special_client_url"
                               value="<?php echo Config::getConfig()->getClientURL(); ?>"
                               placeholder="http://myclient.foo.bar"/>
                    </div>
                    <div class="pure-control-group">
                        <label
                            for="special_remote_server_url"><?php echo Language::t('URL del servidor remoto'); ?></label>
                        <input type="text" id="special_remote_server_url" name="special_remote_server_url"
                               value="<?php echo Config::getConfig()->getRemoteServer(); ?>"
                               placeholder="http://server.foo.bar/sysMonDash"/>
                    </div>
                    <div class="pure-control-group">
                        <label
                            for="special_monitor_server_url"><?php echo Language::t('URL del servidor de monitorización'); ?></label>
                        <input type="text" id="special_monitor_server_url" name="special_monitor_server_url"
                               value="<?php echo Config::getConfig()->getMonitorServerUrl(); ?>"
                               placeholder="http://cloud.foo.bar/icinga"/>
                    </div>
                </div>
            </fieldset>

            <div class="pure-controls">
                <button type="submit"
                        class="pure-button pure-button-primary"><?php echo Language::t('Guardar'); ?></button>
                <button type="button" id="btnBack"
                        class="pure-button pure-button-primary"><?php echo Language::t('Volver'); ?></button>
            </div>

            <input type="hidden" name="hash" value="<?php echo Request::analyze('h'); ?>"/>
        </form>
        <div id="result">&nbsp;</div>
        <script>
            (function () {
                var form = jQuery('#frmConfig');

                form.on('submit', function (e) {
                    e.preventDefault();
                    SMD().saveSMDConfig(form);
                }).find("select").each(function () {
                    var sel = jQuery(this)
                    var selvalue = sel.data('selected');
                    sel.val(selvalue);
                });

                jQuery("#btnBack").click(function () {
                    location.href = SMD().getRootPath();
                });
            }())
        </script>
    <?php else: ?>
        <div id="result" class="error">
            <?php echo Language::t('El archivo de configuración no se puede escribir'); ?>
            <p><?php echo XML_CONFIG_FILE; ?></p>
        </div>
    <?php endif; ?>
    <?php else: ?>
        <form method="get" action="config.php" id="frmHash" name="frmHash" class="pure-form">
            <fieldset>
                <legend><?php echo Language::t('Configuración'); ?></legend>
                <label for="hash"><?php echo Language::t('Hash de configuración'); ?></label>
                <input type="text" id="hash" name="h" class="pure-input-1-2" required/>
                <button type="submit"
                        class="pure-button pure-button-primary"><?php echo Language::t('Comprobar'); ?></button>
            </fieldset>
        </form>
    <?php endif; ?>
</div>

<footer>
    <div id="project"><?php echo implode(' :: ', Util::getAppInfo()); ?></div>
</footer>
</body>
</html>
