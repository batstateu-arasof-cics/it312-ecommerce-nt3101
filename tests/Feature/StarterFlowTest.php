<?php

namespace Tests\Feature;

use App\Models\User;
use App\Modules\Catalog\Models\Product;
use App\Modules\Orders\Models\Order;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Instructor-owned integration test. It checks that the modules still work together.
 * It must pass on every pull request. Teams put their own tests in tests/Feature/<Module>/.
 */
class StarterFlowTest extends TestCase
{
    use RefreshDatabase;

    protected $seed = true;

    public function test_guest_can_browse_products(): void
    {
        $product = Product::first();

        $this->get(route('catalog.index'))->assertOk()->assertSee($product->name);
        $this->get(route('catalog.show', $product))->assertOk()->assertSee('Reviews');
        $this->get(route('search.index', ['q' => 'Barako']))->assertOk()->assertSee('Kapeng Barako');
    }

    public function test_customer_can_check_out_with_cash_on_delivery(): void
    {
        $customer = User::where('email', 'customer@shop.test')->first();
        $product = Product::first();
        $stockBefore = $product->stock;

        $this->actingAs($customer)
            ->post(route('cart.add', $product), ['quantity' => 2])
            ->assertRedirect(route('cart.index'));

        $this->actingAs($customer)->get(route('checkout.show'))->assertOk();

        $this->actingAs($customer)
            ->post(route('checkout.store'), ['payment_method' => 'cod'])
            ->assertRedirect(route('orders.index'));

        $order = Order::where('user_id', $customer->id)->first();
        $this->assertNotNull($order);
        $this->assertSame(Order::PENDING, $order->status);
        $this->assertEquals($product->price * 2 + 150, (float) $order->total); // Shipping team default fee

        $this->assertSame($stockBefore - 2, $product->fresh()->stock);                          // Inventory team
        $this->assertDatabaseHas('payments', ['order_id' => $order->id, 'method' => 'cod']);   // Payments team
        $this->assertDatabaseHas('notification_logs', ['template' => 'order_placed']);         // Notifications team
        $this->assertDatabaseCount('cart_items', 0);                                           // Cart team
    }

    public function test_only_admins_can_open_the_dashboard(): void
    {
        $customer = User::where('email', 'customer@shop.test')->first();
        $admin = User::where('email', 'admin@shop.test')->first();

        $this->actingAs($customer)->get(route('admin.dashboard'))->assertForbidden();
        $this->actingAs($admin)->get(route('admin.dashboard'))
            ->assertOk()
            ->assertSee('Total sales')
            ->assertSee('Sagada Coffee 500g'); // seeded with stock 3, below the low-stock threshold (Inventory team)
    }
}
