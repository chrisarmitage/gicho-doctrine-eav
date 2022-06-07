<?php

namespace Core;

use Ramsey\Uuid\Uuid;

class DeviceIdentifier
{
    protected $deviceUuid;

    protected $tenantId;

    protected function __construct(?string $deviceUuid, int $tenantId)
    {
        $this->deviceUuid = $deviceUuid ?: Uuid::uuid4()->toString();
        $this->tenantId = $tenantId;
    }

    /**
     * @param string|null $deviceUuid
     * @param int         $tenantId
     */
    public static function create(?string $deviceUuid, int $tenantId): DeviceIdentifier
    {
        return new static($deviceUuid, $tenantId);
    }

    /**
     * @return string
     */
    public function deviceUuid(): string
    {
        return $this->deviceUuid;
    }

    /**
     * @return int
     */
    public function tenantId(): int
    {
        return $this->tenantId;
    }
}
