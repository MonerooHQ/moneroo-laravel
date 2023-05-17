<?php

namespace AxaZara\Moneroo\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static \AxaZara\Moneroo\Moneroo createLead(string $email, bool $subscribed = true, array $fields = [])
 * @method static \AxaZara\Moneroo\Moneroo readLead(string $email)
 * @method static \AxaZara\Moneroo\Moneroo updateLead(string $email, array $fields = [])
 * @method static \AxaZara\Moneroo\Moneroo deleteLead(string $email)
 * @method static \AxaZara\Moneroo\Moneroo createField(string $label, string $tag)
 * @method static \AxaZara\Moneroo\Moneroo getFields()
 * @method static \AxaZara\Moneroo\Moneroo updateField(string $id, string $label, string $tag)
 * @method static \AxaZara\Moneroo\Moneroo deleteField(string $id)
 * @method static \AxaZara\Moneroo\Moneroo createProduct(string $id, string $name)
 * @method static \AxaZara\Moneroo\Moneroo getProducts()
 * @method static \AxaZara\Moneroo\Moneroo getProduct(string $id)
 * @method static \AxaZara\Moneroo\Moneroo updateProduct(string $id, string $name)
 * @method static \AxaZara\Moneroo\Moneroo deleteProduct(string $id)
 * @method static \AxaZara\Moneroo\Moneroo getLastError()
 */
class Moneroo extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'Moneroo';
    }
}
