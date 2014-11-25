<?php
/**
 * @package   ImpressPages
 */


/**
 * Created by PhpStorm.
 * User: mangirdas
 * Date: 14.11.25
 * Time: 15.22
 */

namespace Plugin\LanguageDomain;

class Job {
    public static function ipRouteLanguage($info)
    {
        $languages = ipContent()->getLanguages();


        $domainLanguage = false;
        foreach($languages as $language) {
            $domain = ipStorage()->get('Config', 'LanguageDomain.' . $language->getCode() . '.yourEmail');
            if ('http://' . $domain . '/' == ipConfig()->baseUrl('http://')) {
                $domainLanguage = $language;
                break;
            }
        }


        if (!$domainLanguage) {
            //proceed as system default
            return null;
        }


        //let system think that current language URL is empty
        $domainLanguage->url = '';



        /** @var \Ip\Request $request */
        $request = $info['request'];

        $result = array(
            'language' => $domainLanguage,
            'relativeUri' => $info['relativeUri']
        );


        return $result;
    }
}
