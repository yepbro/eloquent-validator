<?php

namespace YepBro\EloquentValidator\Tests\Feature\Rules;

use Workbench\App\Models\RuleModel;
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

    public function getRuleModel(array $attributes): RuleModel
    {
        return new RuleModel($attributes);
    }

    /**
     * @throws ModelValidatorNotFound
     */
    protected function testSuccess(mixed $rule, mixed $value): void
    {
        $attributes = is_array($value) ? $value : ['field' => $value];
        $model = $this->getRuleModel($attributes);
        $model->getModelValidatorInstance()->setRules(['field' => $rule]);
        $this->assertTrue($model->validationPasses());
    }

    /**
     * @throws ModelValidatorNotFound
     */
    protected function testException(mixed $rule, mixed $value, string $validationMessageKey = null, string $message = null): void
    {
        $attributes = is_array($value) ? $value : ['field' => $value];
        $model = $this->getRuleModel($attributes);
        $validationMessageKey ??= $rule;
        $model->getModelValidatorInstance()->setRules(['field' => $rule]);
        $this->assertSame(['field' => [$message ?: "validation.$validationMessageKey"]], $model->getValidationErrors());
    }
}