<?php

namespace App\Helpers;

class ObjectHelper
{
    /**
     * Su00e9curise l'accu00e8s aux propriu00e9tu00e9s d'un objet
     * u00c9vite l'erreur "Undefined property: stdClass::$nom"
     *
     * @param mixed $object L'objet u00e0 vu00e9rifier
     * @param string $property La propriu00e9tu00e9 u00e0 accu00e9der
     * @param mixed $default Valeur par du00e9faut si la propriu00e9tu00e9 n'existe pas
     * @return mixed
     */
    public static function prop($object, $property, $default = null)
    {
        if (is_null($object)) {
            return $default;
        }
        
        if (is_array($object)) {
            return isset($object[$property]) ? $object[$property] : $default;
        }
        
        return isset($object->{$property}) ? $object->{$property} : $default;
    }
}
