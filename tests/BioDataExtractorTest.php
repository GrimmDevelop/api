<?php

use App\Import\Persons\BioDataExtractor;

class BioDataExtractorTest extends PHPUnit_Framework_TestCase
{

    /** @test */
    public function it_can_parse_well_formed_date_only()
    {
        $extractor = new BioDataExtractor();
        $extractor->extract('1824-1854');
        $this->assertEquals('1824', $extractor->getBirthDate());
        $this->assertEquals('1854', $extractor->getDeathDate());
    }

    /** @test */
    public function it_can_parse_well_formed_date_with_towns()
    {
        $extractor = new BioDataExtractor();
        $extractor->extract('Berlin 1781-1831 Wiepersdorf');
        $this->assertEquals('Berlin 1781', $extractor->getBirthDate());
        $this->assertEquals('1831 Wiepersdorf', $extractor->getDeathDate());

        $extractor->extract('Mönchsroth (Fürstentum Öttingen) 1762-1844 Göttingen');
        $this->assertEquals('Mönchsroth (Fürstentum Öttingen) 1762', $extractor->getBirthDate());
        $this->assertEquals('1844 Göttingen', $extractor->getDeathDate());
    }

    /** @test */
    public function it_skips_null_conversion()
    {
        $extractor = new BioDataExtractor();
        $extractor->extract(null);
        $this->assertNull($extractor->getBirthDate());
        $this->assertNull($extractor->getDeathDate());
    }

    /** @test */
    public function it_handles_empty_string()
    {
        $extractor = new BioDataExtractor();
        $extractor->extract('');
        $this->assertNull($extractor->getBirthDate());
        $this->assertNull($extractor->getDeathDate());
    }

    /** @test */
    public function it_can_extract_only_death_date()
    {
        $extractor = new BioDataExtractor();
        $extractor->extract('-1845');
        $this->assertNull($extractor->getBirthDate());
        $this->assertEquals('1845', $extractor->getDeathDate());
    }

    /** @test */
    public function it_can_extract_only_birth_date()
    {
        $extractor = new BioDataExtractor();
        $extractor->extract('1807-');
        $this->assertEquals('1807', $extractor->getBirthDate());
        $this->assertNull($extractor->getDeathDate());
    }

    /** @test */
    public function it_stops_on_multiple_dates()
    {
        $extractor = new BioDataExtractor();
        $extractor->extract('1837-1913 bzw. (St:) -1875');
        $this->assertNull($extractor->getBirthDate());
        $this->assertNull($extractor->getDeathDate());
    }

    /** @test */
    public function it_can_extract_alternative_death_dates()
    {
        $extractor = new BioDataExtractor();
        $extractor->extract('gest. 1681');
        $this->assertNull($extractor->getBirthDate());
        $this->assertEquals('1681', $extractor->getDeathDate());

        $extractor->extract('gestorben 1833');
        $this->assertNull($extractor->getBirthDate());
        $this->assertEquals('1833', $extractor->getDeathDate());

        $extractor->extract('gestorben wahrscheinlich 651');
        $this->assertNull($extractor->getBirthDate());
        $this->assertEquals('wahrscheinlich 651', $extractor->getDeathDate());
    }

    /** @test */
    public function it_can_extract_alternative_birht_dates()
    {
        $extractor = new BioDataExtractor();
        $extractor->extract('geb. 1854');
        $this->assertEquals('1854', $extractor->getBirthDate());
        $this->assertNull($extractor->getDeathDate());

        $extractor->extract('* 14. 5. 1826');
        $this->assertEquals('14. 5. 1826', $extractor->getBirthDate());
        $this->assertNull($extractor->getDeathDate());
    }

    /** @test */
    public function it_skips_errorneous_input()
    {
        $extractor = new BioDataExtractor();
        $extractor->extract('2. Sekretär der franz. Gesandtschaft in Berlin');
        $this->assertNull($extractor->getBirthDate());
        $this->assertNull($extractor->getDeathDate());
    }

    /** @test */
    public function it_can_parse_long_input()
    {
        $extractor = new BioDataExtractor();
        $extractor->extract('um 37 bis nach 105');
        $this->assertEquals('um 37', $extractor->getBirthDate());
        $this->assertEquals('nach 105', $extractor->getDeathDate());
    }
}
