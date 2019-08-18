<?php
namespace Budkovsky\OpenSslWrapper\Tests\Collection;

use Budkovsky\OpenSslWrapper\Abstraction\CollectionAbstract;
use Budkovsky\OpenSslWrapper\Tests\Entity\CryptionDataSet;
use Budkovsky\OpenSslWrapper\Abstraction\StaticFactoryInterface;

class CryptionDataSetCollection extends CollectionAbstract implements StaticFactoryInterface
{
    /**
     * {@inheritDoc}
     * @param CryptionDataSet $cryptionDataSet
     * @return CryptionDataSetCollection
     */
    public function add(CryptionDataSet $cryptionDataSet = null): CryptionDataSetCollection
    {
        if ($cryptionDataSet) {
            $this->collection[] = $cryptionDataSet;            
        }
        
        return $this;
    }
    
    /**
     * Static Factory for CryptionDataSetCollection
     * @return CryptionDataSetCollection
     */
    public static function create(): CryptionDataSetCollection
    {
        return new static();
    }
}
