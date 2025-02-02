<?php

declare(strict_types=1);

namespace App\Tests\Integration\Document\Api;

use App\Document\Infrastructure\Fixtures\CategoryFactory;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Zenstruck\Browser\Test\HasBrowser;
use Zenstruck\Foundry\Test\Factories;
use Zenstruck\Foundry\Test\ResetDatabase;

class GetCategoriesActionTest extends KernelTestCase
{
    use Factories, HasBrowser, ResetDatabase;

    public function test_are_categories_provided(): void
    {
        CategoryFactory::createOne(['name' => 'First Category']);
        CategoryFactory::createOne(['name' => 'Second Category']);
        CategoryFactory::createOne(['name' => 'Third Category']);

        $this->browser()
            ->get('/categories')
            ->assertSuccessful()
            ->assertJsonMatches('total', 3)
            ->assertJsonMatches('items[0].name', 'First Category')
            ->assertJsonMatches('items[1].name', 'Second Category')
            ->assertJsonMatches('items[2].name', 'Third Category');
    }
}
