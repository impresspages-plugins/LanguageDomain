<?php
/**
 * @package   ImpressPages
 */


/**
 * Created by PhpStorm.
 * User: mangirdas
 * Date: 14.11.25
 * Time: 16.13
 */

namespace Plugin\LanguageDomain;


class Slot {
    /**
     * @desc Generate language selection menu
     * @author Allan Laal <allan@permanent.ee>
     * @param array $params
     * @return string
     */
    public static function languages($params)
    {
        $data = array(
            'languages' => ipContent()->getLanguages()
        );

        if (!is_array($params)) {
            $params = array();
        }

        $data += $params;

        if (empty($data['attributes']) || !is_array($data['attributes'])) {
            $data['attributes'] = array();
        }

        $languages = ipContent()->getLanguages();
        if (isset($server['HTTPS']) && strtolower($server['HTTPS']) == "on") {
            $protocol = 'https://';
        } else {
            $protocol = 'http://';
        }
        $links = array();
        foreach($languages as $language) {
            $domain = ipStorage()->get('Config', 'LanguageDomain.' . $language->getCode() . '.yourEmail');
            if ($domain) {
                $links[$language->getCode()] = $protocol . $domain . '/';
            } else {
                $links[$language->getCode()] = $protocol . ipGetOption('LanguageDomain.defaultDomain') . '/';
                if ($language->getUrlPath()) {
                    $links[$language->getCode()] .= $language->getUrlPath();
                }
            }
        }

        $data['links'] = $links;

        $data['attributesStr'] = join(
            ' ',
            array_map(
                function ($sKey) use ($data) {
                    if (is_bool($data['attributes'][$sKey])) {
                        return $data['attributes'][$sKey] ? $sKey : '';
                    }
                    return $sKey . '="' . $data['attributes'][$sKey] . '"';
                },
                array_keys($data['attributes'])
            )
        );


        return ipView('view/languages.php', $data);
    }
}
