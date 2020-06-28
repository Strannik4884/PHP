<?php

class GeoObject implements \JsonSerializable
{
    private $structuredAddress = "";
    private $coordinates = "";
    private $metroName = "";
    private $metroCoordinates = "";

    public function setStructuredAddress(string $structuredAddress)
    {
        $this->structuredAddress = $structuredAddress;
    }

    public function getStructuredAddress(): string
    {
        return $this->structuredAddress;
    }

    public function setCoordinates(string $coordinates)
    {
        $this->coordinates = $coordinates;
    }

    public function getCoordinates(): string
    {
        return $this->coordinates;
    }

    public function setMetroName(string $metroName)
    {
        $this->metroName = $metroName;
    }

    public function getMetroName(): string
    {
        return $this->metroName;
    }

    public function setMetroCoordinates(string $metroCoordinates)
    {
        $this->metroCoordinates = $metroCoordinates;
    }

    public function getMetroCoordinates(): string
    {
        return $this->metroCoordinates;
    }

    /**
     * @inheritDoc
     */
    public function jsonSerialize()
    {
        return get_object_vars($this);
    }
}