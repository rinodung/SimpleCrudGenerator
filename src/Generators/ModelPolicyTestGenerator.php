<?php

namespace Luthfi\CrudGenerator\Generators;

/**
 * Model Test Generator Class
 */
class ModelPolicyTestGenerator extends BaseGenerator
{
    /**
     * {@inheritDoc}
     */
    public function generate(string $type = 'full')
    {
        $modelPolicyTestPath = $this->makeDirectory(base_path('tests/Unit/Policies'));

        $this->generateFile(
            "{$modelPolicyTestPath}/{$this->modelNames['model_name']}PolicyTest.php",
            $this->getContent('test-policy')
        );

        $this->command->info($this->modelNames['model_name'].'PolicyTest (model policy) generated.');
    }

    /**
     * {@inheritDoc}
     */
    protected function getContent(string $stubName)
    {
        $stub = $this->getStubFileContent($stubName);
        $baseTestClass = config('simple-crud.base_test_class');
        $stub = str_replace('use Tests\BrowserKitTest', 'use '.$baseTestClass, $stub);
        return $this->replaceStubString($stub);
    }
}
