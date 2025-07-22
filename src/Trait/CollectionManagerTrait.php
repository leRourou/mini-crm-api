<?php

namespace App\Trait;

use Doctrine\Common\Collections\Collection;

trait CollectionManagerTrait
{
    protected function addToCollection(Collection $collection, object $item, callable $setter): static
    {
        if (!$collection->contains($item)) {
            $collection->add($item);
            $setter($item, $this);
        }

        return $this;
    }

    protected function removeFromCollection(Collection $collection, object $item, callable $getter, callable $setter = null): static
    {
        if ($collection->removeElement($item)) {
            if ($getter($item) === $this) {
                if ($setter) {
                    $setter($item, null);
                } else {
                    $item->setContact(null);
                }
            }
        }

        return $this;
    }
}