<?php
declare(strict_types=1);

namespace Myracloud\WebApi\Endpoint;


use GuzzleHttp\RequestOptions;

/**
 * Class IpFilter
 *
 * @package Myracloud\WebApi\Endpoint
 */
class IpFilter extends AbstractEndpoint
{
    /**
     * @var string
     */
    protected $epName = 'ipfilter';

    /**
     * @param      $domain
     * @param      $type
     * @param      $value
     * @param bool $enabled
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function create(
        $domain,
        $type,
        $value,
        $enabled = true,
        \DateTime $expires = null,
        $comment = null
    ) {
        $uri = $this->uri . '/' . $domain;

        $this->validateIpfilterType($type);
        $options[RequestOptions::JSON] =
            [
                'type'    => $type,
                'value'   => $value,
                'enabled' => $enabled,
            ];
        if( !empty( $expires ) )
            $options[RequestOptions::JSON][ 'expireDate' ] = $expires->format( 'c' );
        if( !empty( $comment ) )
            $options[RequestOptions::JSON][ 'comment' ] = $comment;

        /** @var \GuzzleHttp\Psr7\Response $res */
        $res = $this->client->request('PUT', $uri, $options);

        return $this->handleResponse($res);
    }


    public function update(
        $domain,
        $id,
        \DateTime $modified,
        $type,
        $value,
        \DateTime $expires = null,
        $comment = null
    ) {
        $uri = $this->uri . '/' . $domain;

        $this->validateIpfilterType($type);
        $options[RequestOptions::JSON] =
            [
                'id'       => $id,
                'modified' => $modified->format('c'),
                'type'     => $type,
                'value'    => $value,
            ];
        if( !empty( $expires ) )
            $options[RequestOptions::JSON][ 'expireDate' ] = $expires->format( 'c' );
        if( !empty( $comment ) )
            $options[RequestOptions::JSON][ 'comment' ] = $comment;

        /** @var \GuzzleHttp\Psr7\Response $res */
        $res = $this->client->request('POST', $uri, $options);

        return $this->handleResponse($res);
    }
}