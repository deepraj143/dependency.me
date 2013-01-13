<?php

namespace Hal\ReleaseBundle\Aggregate;

use Hal\ReleaseBundle\Entity\ReleaseInterface;
use Hal\ReleaseBundle\Specification\ConstraintSpecificationInterface;
use Hal\ReleaseBundle\Entity\ConstraintInterface;
class ConstraintAggregate implements ConstraintSpecificationInterface
{

    private $constraints;

    public function __construct(array $constraints = array())
    {
        $this->constraints = $constraints;
    }

    public function isSatisfiedBy(ReleaseInterface $release)
    {
        foreach ($this->constraints as $constraint) {
            if (!$constraint->isSatisfiedBy($release)) {
                return false;
            }
        }
        return true;
    }

    public function addConstraint(ConstraintInterface $constraint)
    {
        array_push($this->constraints, $constraint);
        return $this;
    }

    public function getConstraints()
    {
        return $this->constraints;
    }

    public function getPrettyString()
    {
        $strings = array();
        foreach ($this->getConstraints() as $constraint) {
            array_push($strings, $constraint->getPrettyString());
        }
        return implode(',', $strings);
    }

}