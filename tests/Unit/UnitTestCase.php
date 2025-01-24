<?php
declare(strict_types=1);

namespace YepBro\EloquentValidator\Tests\Unit {

    use PHPUnit\Framework\TestCase;
    use YepBro\EloquentValidator\Tests\Unit\Mocks\MockModel;
    use YepBro\EloquentValidator\Tests\Unit\Mocks\MockModelValidator;

    abstract class UnitTestCase extends TestCase
    {
        protected function getMockModelValidator(array $modelProperties = [], array $validatorProperties = []): MockModelValidator
        {
            $model = $this->makeModel($modelProperties);

            return $this->makeValidator($model, $validatorProperties);
        }

        protected function getMockModel(array $modelProperties = [], array $validatorProperties = []): MockModel
        {
            $model = $this->makeModel($modelProperties);

            $validator = $this->makeValidator($model, $validatorProperties);

            $model->magicSetProperty('validatorInstance', $validator);

            return $model;
        }

        private function makeValidator(MockModel $model, array $properties = []): MockModelValidator
        {
            $validator = new MockModelValidator($model::class, $model->getAttributes(), $model->exists);

            foreach ($properties as $key => $value) {
                $validator->magicSetProperty($key, $value);
            }

            return $validator;
        }

        private function makeModel(array $properties = []): MockModel
        {
            $attributes = $properties['attributes'] ?? $properties['original'] ?? [];

            $model = new MockModel();
            $properties = [
                    'attributes' => $attributes,
                    'original' => $attributes,
                ] + $properties;
            foreach ($properties as $key => $value) {
                $model->magicSetProperty($key, $value);
            }
            return $model;
        }
    }
}

namespace {

    use YepBro\EloquentValidator\Constants;

    function config(string $key, mixed $default = null): mixed
    {
        $key = str_replace(Constants::KEY . '.', '', $key);
        $params = include __DIR__ . '/../../config/' . Constants::KEY . '.php';
        return $params[$key] ?? $default;
    }
}
