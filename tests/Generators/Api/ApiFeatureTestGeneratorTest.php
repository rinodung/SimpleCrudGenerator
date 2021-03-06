<?php

namespace Tests\Generators\Api;

use Tests\TestCase;

class ApiFeatureTestGeneratorTest extends TestCase
{
    /** @test */
    public function it_creates_correct_feature_test_class_content()
    {
        $this->artisan('make:crud-api', ['name' => $this->model_name, '--no-interaction' => true]);

        $this->assertFileExists(base_path("tests/Feature/Api/Manage{$this->plural_model_name}Test.php"));
        $featureTestClassContent = "<?php

namespace Tests\Feature\Api;

use {$this->full_model_name};
use Tests\BrowserKitTest as TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class Manage{$this->plural_model_name}Test extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function user_can_see_{$this->lang_name}_list_in_{$this->lang_name}_index_page()
    {
        \$user = \$this->createUser();
        \${$this->single_model_var_name} = factory({$this->model_name}::class)->create();

        \$this->getJson(route('api.{$this->table_name}.index'), [
            'Authorization' => 'Bearer '.\$user->api_token
        ]);

        \$this->seeJson(['name' => \${$this->single_model_var_name}->name]);
    }

    /** @test */
    public function user_can_create_a_{$this->lang_name}()
    {
        \$user = \$this->createUser();

        \$this->postJson(route('api.{$this->table_name}.store'), [
            'name'        => '{$this->model_name} 1 name',
            'description' => '{$this->model_name} 1 description',
        ], [
            'Authorization' => 'Bearer '.\$user->api_token
        ]);

        \$this->seeInDatabase('{$this->table_name}', [
            'name'        => '{$this->model_name} 1 name',
            'description' => '{$this->model_name} 1 description',
        ]);

        \$this->seeJson(['name' => '{$this->model_name} 1 name']);
    }

    /** @test */
    public function user_can_get_a_{$this->lang_name}_detail()
    {
        \$user = \$this->createUser();
        \${$this->single_model_var_name} = factory({$this->model_name}::class)->create(['name' => 'Testing 123']);

        \$this->getJson(route('api.{$this->table_name}.show', \${$this->single_model_var_name}), [
            'Authorization' => 'Bearer '.\$user->api_token
        ]);

        \$this->seeJson(['name' => 'Testing 123']);
    }

    /** @test */
    public function user_can_update_a_{$this->lang_name}()
    {
        \$user = \$this->createUser();
        \${$this->single_model_var_name} = factory({$this->model_name}::class)->create(['name' => 'Testing 123']);

        \$this->patchJson(route('api.{$this->table_name}.update', \${$this->single_model_var_name}), [
            'name'        => '{$this->model_name} 1 name',
            'description' => '{$this->model_name} 1 description',
        ], [
            'Authorization' => 'Bearer '.\$user->api_token
        ]);

        \$this->seeInDatabase('{$this->table_name}', [
            'name'        => '{$this->model_name} 1 name',
            'description' => '{$this->model_name} 1 description',
        ]);

        \$this->seeJson(['name' => '{$this->model_name} 1 name']);
    }

    /** @test */
    public function user_can_delete_a_{$this->lang_name}()
    {
        \$user = \$this->createUser();
        \${$this->single_model_var_name} = factory({$this->model_name}::class)->create();

        \$this->deleteJson(route('api.{$this->table_name}.destroy', \${$this->single_model_var_name}), [
            '{$this->lang_name}_id' => \${$this->single_model_var_name}->id,
        ], [
            'Authorization' => 'Bearer '.\$user->api_token
        ]);

        \$this->dontSeeInDatabase('{$this->table_name}', [
            'id' => \${$this->single_model_var_name}->id,
        ]);
    }
}
";
        $this->assertEquals($featureTestClassContent, file_get_contents(base_path("tests/Feature/Api/Manage{$this->plural_model_name}Test.php")));
    }

    /** @test */
    public function it_creates_correct_feature_test_class_with_base_test_class_based_on_config_file()
    {
        config(['simple-crud.base_test_path' => 'tests/TestCase.php']);
        config(['simple-crud.base_test_class' => 'Tests\TestCase']);

        $this->artisan('make:crud-api', ['name' => $this->model_name, '--no-interaction' => true]);

        $this->assertFileExists(base_path("tests/Feature/Api/Manage{$this->plural_model_name}Test.php"));
        $featureTestClassContent = "<?php

namespace Tests\Feature\Api;

use {$this->full_model_name};
use Tests\TestCase as TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class Manage{$this->plural_model_name}Test extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function user_can_see_{$this->lang_name}_list_in_{$this->lang_name}_index_page()
    {
        \$user = \$this->createUser();
        \${$this->single_model_var_name} = factory({$this->model_name}::class)->create();

        \$this->getJson(route('api.{$this->table_name}.index'), [
            'Authorization' => 'Bearer '.\$user->api_token
        ]);

        \$this->seeJson(['name' => \${$this->single_model_var_name}->name]);
    }

    /** @test */
    public function user_can_create_a_{$this->lang_name}()
    {
        \$user = \$this->createUser();

        \$this->postJson(route('api.{$this->table_name}.store'), [
            'name'        => '{$this->model_name} 1 name',
            'description' => '{$this->model_name} 1 description',
        ], [
            'Authorization' => 'Bearer '.\$user->api_token
        ]);

        \$this->seeInDatabase('{$this->table_name}', [
            'name'        => '{$this->model_name} 1 name',
            'description' => '{$this->model_name} 1 description',
        ]);

        \$this->seeJson(['name' => '{$this->model_name} 1 name']);
    }

    /** @test */
    public function user_can_get_a_{$this->lang_name}_detail()
    {
        \$user = \$this->createUser();
        \${$this->single_model_var_name} = factory({$this->model_name}::class)->create(['name' => 'Testing 123']);

        \$this->getJson(route('api.{$this->table_name}.show', \${$this->single_model_var_name}), [
            'Authorization' => 'Bearer '.\$user->api_token
        ]);

        \$this->seeJson(['name' => 'Testing 123']);
    }

    /** @test */
    public function user_can_update_a_{$this->lang_name}()
    {
        \$user = \$this->createUser();
        \${$this->single_model_var_name} = factory({$this->model_name}::class)->create(['name' => 'Testing 123']);

        \$this->patchJson(route('api.{$this->table_name}.update', \${$this->single_model_var_name}), [
            'name'        => '{$this->model_name} 1 name',
            'description' => '{$this->model_name} 1 description',
        ], [
            'Authorization' => 'Bearer '.\$user->api_token
        ]);

        \$this->seeInDatabase('{$this->table_name}', [
            'name'        => '{$this->model_name} 1 name',
            'description' => '{$this->model_name} 1 description',
        ]);

        \$this->seeJson(['name' => '{$this->model_name} 1 name']);
    }

    /** @test */
    public function user_can_delete_a_{$this->lang_name}()
    {
        \$user = \$this->createUser();
        \${$this->single_model_var_name} = factory({$this->model_name}::class)->create();

        \$this->deleteJson(route('api.{$this->table_name}.destroy', \${$this->single_model_var_name}), [
            '{$this->lang_name}_id' => \${$this->single_model_var_name}->id,
        ], [
            'Authorization' => 'Bearer '.\$user->api_token
        ]);

        \$this->dontSeeInDatabase('{$this->table_name}', [
            'id' => \${$this->single_model_var_name}->id,
        ]);
    }
}
";
        $this->assertEquals($featureTestClassContent, file_get_contents(base_path("tests/Feature/Api/Manage{$this->plural_model_name}Test.php")));
    }
}
