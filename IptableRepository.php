<?php

namespace Surges\Iptable;

interface IptableRepository
{

    public function get($ip);

    public function getText($ip);

}
