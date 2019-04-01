<?php
namespace App\Helpers;

use Automattic\WooCommerce\Client;
use Pixelpeter\Woocommerce\WoocommerceClient;

trait Woo {
    /**
     * @param $site
     * @return WoocommerceClient
     */
    public function woocommerceClient($site)
    {
        $client = new Client(
            $site->store_url,
            decrypt($site->consumer_key),
            decrypt($site->consumer_secret),
            [
                'version'           => 'wc/'.config('woocommerce.api_version'),
                'verify_ssl'        => config('woocommerce.verify_ssl'),
                'wp_api'            => config('woocommerce.wp_api'),
                'query_string_auth' => config('woocommerce.query_string_auth'),
                'timeout'           => config('woocommerce.timeout')
            ]);

        return new WoocommerceClient($client);
    }
}