<?php

namespace App\Services;

use App\Exceptions\ServiceException;
use App\Models\Tariff;

class TariffService
{
    private ?Tariff $tariff;

    public function __construct(?Tariff $tariff)
    {
        $this->tariff = $tariff;
    }

    public function delete(): Tariff
    {
        if ($this->tariff->users()->exists()) {
            throw new ServiceException('нельзя удалить тариф, есть активные пользователи');
        }

        $this->updateStatus(Tariff::DELETED_STATUS);
        $this->tariff->delete();

        return $this->tariff;
    }

    public function updateStatus(string $status): void
    {
        $this->tariff->status = $status;
        $this->tariff->save();
    }

}
