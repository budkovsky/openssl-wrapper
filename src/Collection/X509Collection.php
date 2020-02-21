<?php
namespace Budkovsky\OpenSslWrapper\Collection;

use Budkovsky\OpenSslWrapper\Abstraction\CollectionAbstract;
use Budkovsky\OpenSslWrapper\X509;

class X509Collection extends CollectionAbstract
{

    public function add(?X509 $x509 = null): X509Collection
    {
        if ($x509) {
            $this->collection[] = $x509;
        }

        return $this;
    }

    public function toArray(): array
    {
        $result = [];
        foreach ($this->collection as $item) {
            /** @var X509 $item */
            $result[] = $item->export();
        }

        return $result;
    }
}
