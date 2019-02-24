<?php

namespace Seconila\TireCode;

use PHPUnit\Framework\TestCase;

class ParserTest extends TestCase
{
    protected $parser;

    public function testConstructorTrimsSpaces()
    {
        $parser = new Parser(' 225/55 R17 101V S954 TL XL ');
        $this->assertEquals('225/55 R17 101V S954 TL XL', $parser->getTireCode());
    }

    public function testGetWidth()
    {
        $parser = new Parser('225/55 R17 101V S954 TL XL');
        $this->assertEquals('225', $parser->getWidth());

        $parser = new Parser(' 185/60 R14 82H 86A TL  ');
        $this->assertEquals('185', $parser->getWidth());

        $parser = new Parser('XXX/55 R17 101V S954 TL XL');
        $this->assertEquals(null, $parser->getWidth());
    }

    public function testGetAspectRatio()
    {
        $parser = new Parser('225/55 R17 101V S954 TL XL');
        $this->assertEquals('55', $parser->getAspectRatio());

        $parser = new Parser(' 185/60 R14 82H 86A TL  ');
        $this->assertEquals('60', $parser->getAspectRatio());

        $parser = new Parser('225/XX R17 101V S954 TL XL');
        $this->assertEquals(null, $parser->getAspectRatio());
    }

    public function testGetSpeedRating()
    {
        $parser = new Parser('225/55 R17 101V S954 TL XL');
        $this->assertEquals('R', $parser->getSpeedRating());

        $parser = new Parser('275/35ZR19 100Y PXT1R TL        ');
        $this->assertEquals('ZR', $parser->getSpeedRating());
    }

    public function testGetRimDiameter()
    {
        $parser = new Parser('225/55 R17 101V S954 TL XL');
        $this->assertEquals('17', $parser->getRimDiameter());

        $parser = new Parser('275/35ZR19 100Y PXT1R TL        ');
        $this->assertEquals('19', $parser->getRimDiameter());

        $parser = new Parser('275/35ZRXX 100Y PXT1R TL');
        $this->assertEquals(null, $parser->getRimDiameter());
    }

    public function testGetTireSize()
    {
        $parser = new Parser('225/55 R17 101V S954 TL XL');
        $this->assertEquals('225/55', $parser->getTireSize());

        $parser = new Parser('275/35ZR19 100Y PXT1R TL        ');
        $this->assertEquals('275/35', $parser->getTireSize());

        $parser = new Parser('XXX/XXZR19 100Y PXT1R TL');
        $this->assertEquals(null, $parser->getTireSize());
    }

    public function testGetLoadIndexEnclosedInBrackets()
    {
        $parser = new Parser('225/55 R17 101V S954 TL XL');
        $this->assertEquals('101', $parser->getLoadIndex());
    }

    public function testGetLoadIndexNotEnclosedInBrackets()
    {
        $parser = new Parser('275/35 ZR19 (100Y) XL');
        $this->assertEquals('100', $parser->getLoadIndex());

        $parser = new Parser('275/35 ZR19 (Y) XL');
        $this->assertEquals(null, $parser->getLoadIndex());

        $parser = new Parser('275/35 ZR19 XL');
        $this->assertEquals(null, $parser->getLoadIndex());
    }

    public function testGetSpeedSymbolNotEnclosedInBrackets()
    {
        $parser = new Parser('225/55 R17 101V S954 TL XL');
        $this->assertEquals('V', $parser->getSpeedSymbol());

        $parser = new Parser('225/55 R17 101 S954 TL XL');
        $this->assertEquals(null, $parser->getSpeedSymbol());
    }

    public function testGetSpeedSymbolEnclosedInBrackets()
    {
        $parser = new Parser('275/35 ZR19 (100Y) XL');
        $this->assertEquals('(Y)', $parser->getSpeedSymbol());
    }

    public function testGetLoadIndexSpeedSymbol()
    {
        $parser = new Parser('225/55 R17 101V S954 TL XL');
        $this->assertEquals('101V', $parser->getLoadIndexSpeedSymbol());

        $parser = new Parser('225/55 R17 S954 TL XL');
        $this->assertEquals(null, $parser->getLoadIndexSpeedSymbol());

        $parser = new Parser('225/55 R17 XXV S954 TL XL');
        $this->assertEquals(null, $parser->getLoadIndexSpeedSymbol());
    }

}
