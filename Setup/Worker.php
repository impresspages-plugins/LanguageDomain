<?php
/**
 * @package   ImpressPages
 */


/**
 * Created by PhpStorm.
 * User: mangirdas
 * Date: 14.11.25
 * Time: 16.27
 */

namespace Plugin\LanguageDomain\Setup;


class Worker {

    public function activate()
    {
        $domain = ipConfig()->baseUrl('');
        $domain = substr($domain, 0, -1);
        ipSetOption('LanguageDomain.defaultDomain', $domain);
    }
}
