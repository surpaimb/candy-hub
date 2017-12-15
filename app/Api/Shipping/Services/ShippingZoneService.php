<?php
namespace GetCandy\Api\Shipping\Services;

use GetCandy\Api\Scaffold\BaseService;
use GetCandy\Api\Shipping\Models\ShippingZone;

class ShippingZoneService extends BaseService
{
    public function __construct()
    {
        $this->model = new ShippingZone();
    }

    /**
     * Create a shipping method
     *
     * @param array $data
     *
     * @return ShippingZone
     */
    public function create(array $data)
    {
        $shipping = new ShippingZone;
        $shipping->fill($data);
        $shipping->save();

        if (!empty($data['countries'])) {
            $shipping->countries()->attach(
                app('api')->countries()->getDecodedIds($data['countries'])
            );
        }

        return $shipping;
    }

    /**
     * Updates a shipping zone
     *
     * @param string $id
     * @param array $data
     *
     * @return ShippingZone
     */
    public function update($id, array $data)
    {
        $shipping = $this->getByHashedId($id);
        $shipping->fill($data);
        $shipping->save();
        return $shipping;
    }

    public function getByCountryName($name, $locale = 'en')
    {
        $result = ShippingZone::whereHas('countries', function ($query) use ($name, $locale) {
            $query->where('name->' . $locale, $name);
        })->get();
        return $result;
    }
}
