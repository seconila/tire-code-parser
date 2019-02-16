<?php

namespace Seconila\TireCode;

class Parser
{
    /**
     * https://en.wikipedia.org/wiki/Tire_code
     *
     * E.g. 225/55 R17 101V S954 TL XL
     * @var string
     */
    protected $tire_code;

    public function __construct($tire_code)
    {
        $this->tire_code = trim($tire_code);
        return $this;
    }

    public function getTireCode()
    {
        return $this->tire_code;
    }

    public function getWidth()
    {
        if (preg_match("/^([0-9]+)\/[0-9]+/", $this->tire_code, $matches)) {  // Check if begins with "225"
            return $matches[1];
        }
    }

    public function getAspectRatio()
    {
        if (preg_match("/^[0-9]+\/([0-9]+)/", $this->tire_code, $matches)) {
            return $matches[1];
        }
    }

    public function getTireSize()
    {
        if (preg_match("/^([0-9]+\/[0-9]+)/", $this->tire_code, $matches)) {
            return $matches[1];
        }
    }

    public function getSpeedRating()
    {
        $tire_size = str_replace(' ', '', $this->tire_code); // Strip spaces e.g. 225/55 Z R78 -> 225/55R17
        if (preg_match("/^.*ZR.*/", $tire_size)) {
            return 'ZR';
        } else {
            return 'R';
        }
    }

    public function getRimDiameter()
    {
        if (preg_match("/^[0-9]+\/[0-9]+\s*[{R,ZR}]+\s*([0-9]{2})/", $this->tire_code, $matches)) {
            return $matches[1];
        }
    }

    public function getLoadIndex()
    {
        $load_index_speed_symbol = $this->getLoadIndexSpeedSymbol();
        if ($load_index_speed_symbol) {
            return str_replace(array('Q', 'R', 'S', 'T', 'H', 'V', 'W', 'Y', '(', ')'), '', $load_index_speed_symbol);
        }
    }

    public function getLoadIndexSpeedSymbol()
    {
        $pattern = "/^[0-9]+\/[0-9]+\s*[{R,ZR}]+\s*[0-9]{2}\s*(\(?[0-9]{2,3}[QRSTHVWY]\)?)/";

        if (preg_match($pattern, $this->tire_code, $matches)) {
            return $matches[1];
        }
    }

    public function getSpeedSymbol()
    {
        $load_index_speed_symbol = $this->getLoadIndexSpeedSymbol();
        if ($load_index_speed_symbol) {
            return str_replace(range(0, 9), '', $load_index_speed_symbol);
        }
    }

}