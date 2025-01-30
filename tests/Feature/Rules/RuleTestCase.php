<?php

namespace YepBro\EloquentValidator\Tests\Feature\Rules;

use PHPUnit\Framework\Attributes\TestDox;
use YepBro\EloquentValidator\Exceptions\ModelNotValidated;
use YepBro\EloquentValidator\Exceptions\ModelValidatorNotFound;
use YepBro\EloquentValidator\Tests\Feature\FeatureTestCase;

class RuleTestCase extends FeatureTestCase
{
    protected bool $catch = false;

    protected function setUp(): void
    {
        parent::setUp();
        $this->catch = false;
        $this->app->setLocale('fr');
        $this->app->setFallbackLocale('fr');
    }

    /**
     * @throws ModelValidatorNotFound
     */
    protected function testSuccess(string $rule, mixed $value): void
    {
        $model = $this->getRuleModel($value);
        $model->getModelValidatorInstance()->setRules(['field' => $rule]);
        $this->assertTrue($model->validationPasses());
    }

    /**
     * @throws ModelValidatorNotFound
     */
    protected function testException(string $rule, mixed $value): void
    {
        $model = $this->getRuleModel($value);

        try {
            $model->getModelValidatorInstance()->setRules(['field' => $rule]);
            $model->validate();
        } catch (ModelNotValidated $e) {
            $this->assertSame(['field' => ["validation.$rule"]], $e->getErrors());
            $this->catch = true;
        }

        if (!$this->catch) {
            $this->assertTrue($this->catch, 'The model was validated incorrectly.');
        }
    }
}