<?php
namespace KGaming\Core;
use Ramsey\Uuid\Uuid;

class Utils
{
    /**
     * Generate UUIDv1
     *
     * @return string
     */
    public static function uid1()
    {
        $uid1 = Uuid::uuid1();
        return $uid1->toString();
    }

    /**
     * Generate Namespaced UUIDv5
     *
     * @param string $ns Namespace (DNS) eg: hostname.com
     * @return string
     */
    public static function uid5($ns='example.host')
    {
        $uid5 = Uuid::uuid5(Uuid::NAMESPACE_DNS, $ns);
        return $uid5->toString();
    }

    /**
     * Get current time.
     *
     * @param string $format Desired time format, with default to 'c'
     * @param string $tz Desired timezone with default 'Asia/Jakarta'
     * @return string
     */
    public static function getTime($format = 'c', $tz = 'Asia/Jakarta')
    {
        $time = new \DateTime('now', new \DateTimeZone($tz));
        return $time->format($format);
    }
}
