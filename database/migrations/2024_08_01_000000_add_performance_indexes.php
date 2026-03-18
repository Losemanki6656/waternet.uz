<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // clients
        Schema::table('clients', function (Blueprint $table) {
            if (!$this->hasIndex('clients', 'clients_organization_id_status_index')) {
                $table->index(['organization_id', 'status'], 'clients_organization_id_status_index');
            }
            if (!$this->hasIndex('clients', 'clients_user_id_index')) {
                $table->index('user_id', 'clients_user_id_index');
            }
            if (!$this->hasIndex('clients', 'clients_area_id_index')) {
                $table->index('area_id', 'clients_area_id_index');
            }
            if (!$this->hasIndex('clients', 'clients_city_id_index')) {
                $table->index('city_id', 'clients_city_id_index');
            }
        });

        // orders
        Schema::table('orders', function (Blueprint $table) {
            if (!$this->hasIndex('orders', 'orders_organization_id_status_created_at_index')) {
                $table->index(['organization_id', 'status', 'created_at'], 'orders_organization_id_status_created_at_index');
            }
            if (!$this->hasIndex('orders', 'orders_client_id_index')) {
                $table->index('client_id', 'orders_client_id_index');
            }
            if (!$this->hasIndex('orders', 'orders_area_id_index')) {
                $table->index('area_id', 'orders_area_id_index');
            }
            if (!$this->hasIndex('orders', 'orders_user_id_index')) {
                $table->index('user_id', 'orders_user_id_index');
            }
            if (!$this->hasIndex('orders', 'orders_product_id_index')) {
                $table->index('product_id', 'orders_product_id_index');
            }
        });

        // areas
        Schema::table('areas', function (Blueprint $table) {
            if (!$this->hasIndex('areas', 'areas_organization_id_status_index')) {
                $table->index(['organization_id', 'status'], 'areas_organization_id_status_index');
            }
            if (!$this->hasIndex('areas', 'areas_city_id_index')) {
                $table->index('city_id', 'areas_city_id_index');
            }
        });

        // success_orders
        Schema::table('success_orders', function (Blueprint $table) {
            if (!$this->hasIndex('success_orders', 'success_orders_org_status_user_index')) {
                $table->index(['organization_id', 'order_status', 'user_id'], 'success_orders_org_status_user_index');
            }
            if (!$this->hasIndex('success_orders', 'success_orders_client_id_index')) {
                $table->index('client_id', 'success_orders_client_id_index');
            }
            if (!$this->hasIndex('success_orders', 'success_orders_created_at_index')) {
                $table->index('created_at', 'success_orders_created_at_index');
            }
        });

        // sms
        Schema::table('sms', function (Blueprint $table) {
            if (!$this->hasIndex('sms', 'sms_organization_id_index')) {
                $table->index('organization_id', 'sms_organization_id_index');
            }
            if (!$this->hasIndex('sms', 'sms_client_id_index')) {
                $table->index('client_id', 'sms_client_id_index');
            }
            if (!$this->hasIndex('sms', 'sms_created_at_index')) {
                $table->index('created_at', 'sms_created_at_index');
            }
        });

        // take_products
        Schema::table('take_products', function (Blueprint $table) {
            if (!$this->hasIndex('take_products', 'take_products_organization_id_index')) {
                $table->index('organization_id', 'take_products_organization_id_index');
            }
            if (!$this->hasIndex('take_products', 'take_products_received_id_index')) {
                $table->index('received_id', 'take_products_received_id_index');
            }
            if (!$this->hasIndex('take_products', 'take_products_sent_id_index')) {
                $table->index('sent_id', 'take_products_sent_id_index');
            }
            if (!$this->hasIndex('take_products', 'take_products_product_id_index')) {
                $table->index('product_id', 'take_products_product_id_index');
            }
            if (!$this->hasIndex('take_products', 'take_products_created_at_index')) {
                $table->index('created_at', 'take_products_created_at_index');
            }
        });

        // entry_products
        Schema::table('entry_products', function (Blueprint $table) {
            if (!$this->hasIndex('entry_products', 'entry_products_organization_id_index')) {
                $table->index('organization_id', 'entry_products_organization_id_index');
            }
            if (!$this->hasIndex('entry_products', 'entry_products_product_id_index')) {
                $table->index('product_id', 'entry_products_product_id_index');
            }
            if (!$this->hasIndex('entry_products', 'entry_products_user_id_index')) {
                $table->index('user_id', 'entry_products_user_id_index');
            }
            if (!$this->hasIndex('entry_products', 'entry_products_created_at_index')) {
                $table->index('created_at', 'entry_products_created_at_index');
            }
        });

        // client_containers
        Schema::table('client_containers', function (Blueprint $table) {
            if (!$this->hasIndex('client_containers', 'client_containers_organization_id_index')) {
                $table->index('organization_id', 'client_containers_organization_id_index');
            }
            if (!$this->hasIndex('client_containers', 'client_containers_client_id_index')) {
                $table->index('client_id', 'client_containers_client_id_index');
            }
            if (!$this->hasIndex('client_containers', 'client_containers_user_id_index')) {
                $table->index('user_id', 'client_containers_user_id_index');
            }
        });

        // products
        Schema::table('products', function (Blueprint $table) {
            if (!$this->hasIndex('products', 'products_organization_id_index')) {
                $table->index('organization_id', 'products_organization_id_index');
            }
        });

        // user_organizations
        Schema::table('user_organizations', function (Blueprint $table) {
            if (!$this->hasIndex('user_organizations', 'user_organizations_org_role_index')) {
                $table->index(['organization_id', 'role'], 'user_organizations_org_role_index');
            }
            if (!$this->hasIndex('user_organizations', 'user_organizations_user_id_index')) {
                $table->index('user_id', 'user_organizations_user_id_index');
            }
        });

        // region_users
        Schema::table('region_users', function (Blueprint $table) {
            if (!$this->hasIndex('region_users', 'region_users_user_id_index')) {
                $table->index('user_id', 'region_users_user_id_index');
            }
        });

        // organizations
        Schema::table('organizations', function (Blueprint $table) {
            if (!$this->hasIndex('organizations', 'organizations_traffic_id_index')) {
                $table->index('traffic_id', 'organizations_traffic_id_index');
            }
        });
    }

    public function down(): void
    {
        Schema::table('clients', function (Blueprint $table) {
            $table->dropIndex('clients_organization_id_status_index');
            $table->dropIndex('clients_user_id_index');
            $table->dropIndex('clients_area_id_index');
            $table->dropIndex('clients_city_id_index');
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->dropIndex('orders_organization_id_status_created_at_index');
            $table->dropIndex('orders_client_id_index');
            $table->dropIndex('orders_area_id_index');
            $table->dropIndex('orders_user_id_index');
            $table->dropIndex('orders_product_id_index');
        });

        Schema::table('areas', function (Blueprint $table) {
            $table->dropIndex('areas_organization_id_status_index');
            $table->dropIndex('areas_city_id_index');
        });

        Schema::table('success_orders', function (Blueprint $table) {
            $table->dropIndex('success_orders_org_status_user_index');
            $table->dropIndex('success_orders_client_id_index');
            $table->dropIndex('success_orders_created_at_index');
        });

        Schema::table('sms', function (Blueprint $table) {
            $table->dropIndex('sms_organization_id_index');
            $table->dropIndex('sms_client_id_index');
            $table->dropIndex('sms_created_at_index');
        });

        Schema::table('take_products', function (Blueprint $table) {
            $table->dropIndex('take_products_organization_id_index');
            $table->dropIndex('take_products_received_id_index');
            $table->dropIndex('take_products_sent_id_index');
            $table->dropIndex('take_products_product_id_index');
            $table->dropIndex('take_products_created_at_index');
        });

        Schema::table('entry_products', function (Blueprint $table) {
            $table->dropIndex('entry_products_organization_id_index');
            $table->dropIndex('entry_products_product_id_index');
            $table->dropIndex('entry_products_user_id_index');
            $table->dropIndex('entry_products_created_at_index');
        });

        Schema::table('client_containers', function (Blueprint $table) {
            $table->dropIndex('client_containers_organization_id_index');
            $table->dropIndex('client_containers_client_id_index');
            $table->dropIndex('client_containers_user_id_index');
        });

        Schema::table('products', function (Blueprint $table) {
            $table->dropIndex('products_organization_id_index');
        });

        Schema::table('user_organizations', function (Blueprint $table) {
            $table->dropIndex('user_organizations_org_role_index');
            $table->dropIndex('user_organizations_user_id_index');
        });

        Schema::table('region_users', function (Blueprint $table) {
            $table->dropIndex('region_users_user_id_index');
        });

        Schema::table('organizations', function (Blueprint $table) {
            $table->dropIndex('organizations_traffic_id_index');
        });
    }

    private function hasIndex(string $table, string $indexName): bool
    {
        return collect(\DB::select("SHOW INDEX FROM `{$table}`"))
            ->pluck('Key_name')
            ->contains($indexName);
    }
};
