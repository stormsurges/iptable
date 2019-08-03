<?php

namespace Surges\Iptable;

use DB;

class DatabaseRepository implements IptableRepository
{
    public $table;

    public function __construct($table = 'iptables')
    {
        $this->table = $table;
    }

    public function get($ip)
    {
        if (empty($ip)) {
            return [];
        }

        $iptable = $this->getConnection()->whereRaw('INET_ATON("' . $ip . '") BETWEEN StartIPNum AND EndIPNum')->first();
        if (!empty($iptable)) {
            return [
                'address' => $iptable->Country,
                'isp' => $iptable->Local,
            ];
        }

        return [];
    }

    public function getText($ip)
    {
        if (empty($ip)) {
            return '未知';
        }

        $iptable = $this->getConnection()->whereRaw('INET_ATON("' . $ip . '") BETWEEN StartIPNum AND EndIPNum')->first();
        if (!empty($iptable)) {
            if (empty($iptable->Local)) {
                $text = $iptable->Country;
            } else {
                $text = $iptable->Country . '|' . $iptable->Local;
            }

            return $text;
        }

        return '未知';
    }

    public function getConnection()
    {
        return DB::table($this->table);
    }

}
