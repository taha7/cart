<?php

namespace Tests\Unit\Models\Categories;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Category;
use Illuminate\Database\Eloquent\Collection;
use App\Models\Product;

class CategoryTest extends TestCase
{
    /** @test */
    public function it_has_many_children()
    {
        $category = factory(Category::class)->create();

        $category->children()->save(factory(Category::class)->create());

        $this->assertInstanceOf(Category::class, $category->children()->first());
        $this->assertInstanceOf(Collection::class, $category->children);
    }

    /** @test */
    public function it_can_fetch_only_parents()
    {
        $category = factory(Category::class)->create();

        $category->children()->save(factory(Category::class)->create());

        $this->assertEquals(1, Category::parents()->count());
        $this->assertCount(1, Category::parents()->get());
    }

    /** @test */
    public function it_is_orderable()
    {
        $category = factory(Category::class)->create(['order' => 2]);
        $anotherCategory = factory(Category::class)->create(['order' => 1]);

        $this->assertEquals(Category::ordered()->first()->slug, $anotherCategory->slug);
        $this->assertEquals(Category::ordered()->get()[1]->slug, $category->slug);
    }

    /** @test */
    public function it_has_many_to_many_relationship_with_products()
    {
        $category = factory(Category::class)->create();

        $category->products()->save(
            factory(Product::class)->create()
        );

        $this->assertInstanceOf(Product::class, $category->products()->first());
        $this->assertInstanceOf(Collection::class, $category->products);
    }
}
