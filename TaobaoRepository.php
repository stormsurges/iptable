<?php

namespace Surges\Iptable;

use function GuzzleHttp\json_decode;
use GuzzleHttp\Client;

class TaobaoRepository implements IptableRepository
{
    public $url = 'http://ip.taobao.com/service/getIpInfo.php';

    public function get($ip)
    {
        try {
            $client = new Client();
            $res = $client->request('GET', $this->url, [
                'query' => ['ip' => $ip],
            ]);
            $result = json_decode((string) $res->getBody(), true);
            if ($result['code'] === 0) {
                return [
                    'address' => implode('', [
                        $result['data']['country'] === '中国' ? '' : $result['data']['country'],
                        $result['data']['region'],
                        $result['data']['city'],
                    ]),
                    'isp' => $result['data']['isp'],
                ];
            } else {
                return [];
            }
        } catch (\Throwable $th) {
            return [];
        }
    }

    public function getText($ip)
    {
        $result = $this->get($ip);

        return implode('|', $result);
    }

}
