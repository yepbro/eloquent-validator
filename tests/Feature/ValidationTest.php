<?php

namespace YepBro\EloquentValidator\Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use PHPUnit\Framework\Attributes\CoversMethod;
use PHPUnit\Framework\Attributes\TestWith;
use YepBro\EloquentValidator\Exceptions\ModelNotValidated;
use YepBro\EloquentValidator\Exceptions\ModelValidatorNotFound;
use YepBro\EloquentValidator\HasValidator;

#[CoversMethod(HasValidator::class, 'validate')]
#[CoversMethod(HasValidator::class, 'validationFails')]
#[CoversMethod(HasValidator::class, 'validationPasses')]
#[CoversMethod(HasValidator::class, 'getValidationErrors')]
#[CoversMethod(HasValidator::class, 'getValidationErrorsAsJson')]
class ValidationTest extends FeatureTestCase
{
    use DatabaseMigrations;

    protected bool $fakeProduct = true;

    /**
     * @throws ModelValidatorNotFound
     * @throws ModelNotValidated
     */
    public function test_validate_success(): void
    {
        $this->product->fill(['name' => 'test'])->validate();
        $this->assertTrue(true);
    }

    /**
     * @throws ModelValidatorNotFound
     * @throws ModelNotValidated
     */
    public function test_validate_exception(): void
    {
        $this->expectException(ModelNotValidated::class);
        $this->product->fill(['name' => 't'])->validate();
    }

    /**
     * @throws ModelValidatorNotFound
     */
    #[TestWith([['name' => 'test'], false])]
    #[TestWith([['name' => 't'], true])]
    public function test_validation_fails(array $data, bool $expected)
    {
        $actual = $this->product->fill($data)->validationFails();
        $this->assertSame($expected, $actual);
    }

    /**
     * @throws ModelValidatorNotFound
     */
    #[TestWith([['name' => 'test'], true])]
    #[TestWith([['name' => 't'], false])]
    public function test_validation_passes(array $data, bool $expected)
    {
        $actual = $this->product->fill($data)->validationPasses();
        $this->assertSame($expected, $actual);
    }

    /**
     * @throws ModelValidatorNotFound
     */
    #[TestWith([['name' => 'test'], []])]
    #[TestWith([['name' => 't'], ['name' => ['The Product name field must be at least 3 characters.']]])]
    public function test_validation_get_errors_as_array(array $data, array $expected)
    {
        $actual = $this->product->fill($data)->getValidationErrors();
        $this->assertSame($expected, $actual);
    }

    /**
     * @throws ModelValidatorNotFound
     */
    #[TestWith([['name' => 'test'], []])]
    #[TestWith([['name' => 't'], ['name' => ['The Product name field must be at least 3 characters.']]])]
    public function test_validation_get_errors_as_json(array $data, array $expected)
    {
        $actual = $this->product->fill($data)->getValidationErrorsAsJson();
        $this->assertSame(json_encode($expected, JSON_UNESCAPED_UNICODE), $actual);
    }
}