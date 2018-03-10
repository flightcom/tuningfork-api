<?php

namespace Managers\Devices;

use Models\Device;
use JWTAuth;

class DevicesManager
{
    /*
    |--------------------------------------------------------------------------
    | DevicesManager
    |--------------------------------------------------------------------------
    |
    | The DevicesManager is simply the business logic between the controller and
    | the model.
    |
    */

    /**
     * @return mixed
     */
    public function query()
    {
        $user = \Auth::user();

        return $user->devices;
    }

    /**
     * @param array $data
     * @return static
     */
    public function store(array $data)
    {
        $user = \Auth::user();

        $device = $user->devices()->where('uuid', $data['uuid'])->first();

        if ($device) {
            return $this->update($data, $device->id);
        }

        return $user->devices()->save(new Device([
            'uuid' => $data['uuid'],
            'type' => $data['type'],
            'token' => $data['token'],
        ]));
    }

    /**
     * @param $id
     * @return mixed
     */
    public function show($id)
    {
        $device = Device::find($id);

        if ($device->user === \Auth::user()) {
            return $device;
        } else {
            return false;
        }
    }

    /**
     * @param array $data
     * @param $id
     * @return mixed
     */
    public function update(array $data, $id)
    {
        $user = \Auth::user();

        $device = $user->devices()->find($id);

        if (!$device) {
            return $device;
        }

        if ($device->uuid !== $data['uuid']) {
            throw new \Exception("UUID does not match", 1);
        }

        return $device->update($data);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function destroy($id)
    {
        $user = \Auth::user();

        return $user->devices()->destroy($id);
    }
}
