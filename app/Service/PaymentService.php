<?php

namespace App\Service;

use YooKassa\Client;

class PaymentService
{
    private function getClient(): Client
    {
        $client = new Client();
        $client->setAuth(config('services.yookassa.shop_id'), config('services.yookassa.secret_key'));

        return $client;
    }

    /**
     * @param float $amount
     * @param string $description
     * @param array $options
     * @return string
     * @throws \YooKassa\Common\Exceptions\ApiException
     * @throws \YooKassa\Common\Exceptions\BadApiRequestException
     * @throws \YooKassa\Common\Exceptions\ExtensionNotFoundException
     * @throws \YooKassa\Common\Exceptions\ForbiddenException
     * @throws \YooKassa\Common\Exceptions\InternalServerError
     * @throws \YooKassa\Common\Exceptions\NotFoundException
     * @throws \YooKassa\Common\Exceptions\ResponseProcessingException
     * @throws \YooKassa\Common\Exceptions\TooManyRequestsException
     * @throws \YooKassa\Common\Exceptions\UnauthorizedException
     */
    public function createPayment(float $amount, string $description, array $options = [])
    {
        $idempotenceKey = uniqid('', true);
        $client = $this->getClient();
        $payment = $client->createPayment([
            'amount' => [
                "value" => $amount,
                "currency" => "RUB"
            ],
            'capture' => false,
            'confirmation' => [
                'type' => 'redirect',
                'return_url' => route('sport-objects.index'),
            ],
            'metadata' => [
                'transaction_id' => $options['transaction_id'],
                'rates' => $options['rates'],
                'sport_object_id' => $options['sport_object_id'],
            ],
            'description' => $description,
        ], $idempotenceKey);

        return $payment->getConfirmation()->getConfirmationUrl();
    }
}
