<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class CreatePermissionTables extends Migration
{
    public function up()
    {
        $tableNames = config('permission.table_names');
        $columnNames = config('permission.column_names');
        $teams = config('permission.teams');

        if (empty($tableNames)) {
            throw new \Exception('Error: config/permission.php not loaded. Run [php artisan config:clear] and try again.');
        }
        if ($teams && empty($columnNames['team_foreign_key'] ?? null)) {
            throw new \Exception('Error: team_foreign_key on config/permission.php not loaded. Run [php artisan config:clear] and try again.');
        }

        Schema::create($tableNames['permissions'], function (Blueprint $table) {
            $table->bigIncrements('id'); // permission id
            $table->string('name');       // For MySQL 8.0 use string('name', 125);
            $table->string('guard_name'); // For MySQL 8.0 use string('guard_name', 125);
            $table->timestamps();

            $table->unique(['name', 'guard_name']);
        });

        Schema::create($tableNames['roles'], function (Blueprint $table) use ($teams, $columnNames) {
            $table->bigIncrements('id'); // role id
            if ($teams || config('permission.testing')) { // permission.testing is a fix for sqlite testing
                $table->unsignedBigInteger($columnNames['team_foreign_key'])->nullable();
                $table->index($columnNames['team_foreign_key'], 'roles_team_foreign_key_index');
            }
            $table->string('name');       // For MySQL 8.0 use string('name', 125);
            $table->string('guard_name'); // For MySQL 8.0 use string('guard_name', 125);
            $table->timestamps();
            if ($teams || config('permission.testing')) {
                $table->unique([$columnNames['team_foreign_key'], 'name', 'guard_name']);
            } else {
                $table->unique(['name', 'guard_name']);
            }
        });

        Schema::create($tableNames['model_has_permissions'], function (Blueprint $table) use ($tableNames, $columnNames, $teams) {
            $table->unsignedBigInteger(PermissionRegistrar::$pivotPermission);

            $table->string('model_type');
            $table->unsignedBigInteger($columnNames['model_morph_key']);
            $table->index([$columnNames['model_morph_key'], 'model_type'], 'model_has_permissions_model_id_model_type_index');

            $table->foreign(PermissionRegistrar::$pivotPermission)
                ->references('id') // permission id
                ->on($tableNames['permissions'])
                ->onDelete('cascade');
            if ($teams) {
                $table->unsignedBigInteger($columnNames['team_foreign_key']);
                $table->index($columnNames['team_foreign_key'], 'model_has_permissions_team_foreign_key_index');

                $table->primary([$columnNames['team_foreign_key'], PermissionRegistrar::$pivotPermission, $columnNames['model_morph_key'], 'model_type'],
                    'model_has_permissions_permission_model_type_primary');
            } else {
                $table->primary([PermissionRegistrar::$pivotPermission, $columnNames['model_morph_key'], 'model_type'],
                    'model_has_permissions_permission_model_type_primary');
            }

        });

        Schema::create($tableNames['model_has_roles'], function (Blueprint $table) use ($tableNames, $columnNames, $teams) {
            $table->unsignedBigInteger(PermissionRegistrar::$pivotRole);

            $table->string('model_type');
            $table->unsignedBigInteger($columnNames['model_morph_key']);
            $table->index([$columnNames['model_morph_key'], 'model_type'], 'model_has_roles_model_id_model_type_index');

            $table->foreign(PermissionRegistrar::$pivotRole)
                ->references('id') // role id
                ->on($tableNames['roles'])
                ->onDelete('cascade');
            if ($teams) {
                $table->unsignedBigInteger($columnNames['team_foreign_key']);
                $table->index($columnNames['team_foreign_key'], 'model_has_roles_team_foreign_key_index');

                $table->primary([$columnNames['team_foreign_key'], PermissionRegistrar::$pivotRole, $columnNames['model_morph_key'], 'model_type'],
                    'model_has_roles_role_model_type_primary');
            } else {
                $table->primary([PermissionRegistrar::$pivotRole, $columnNames['model_morph_key'], 'model_type'],
                    'model_has_roles_role_model_type_primary');
            }
        });

        Schema::create($tableNames['role_has_permissions'], function (Blueprint $table) use ($tableNames) {
            $table->unsignedBigInteger(PermissionRegistrar::$pivotPermission);
            $table->unsignedBigInteger(PermissionRegistrar::$pivotRole);

            $table->foreign(PermissionRegistrar::$pivotPermission)
                ->references('id') // permission id
                ->on($tableNames['permissions'])
                ->onDelete('cascade');

            $table->foreign(PermissionRegistrar::$pivotRole)
                ->references('id') // role id
                ->on($tableNames['roles'])
                ->onDelete('cascade');

            $table->primary([PermissionRegistrar::$pivotPermission, PermissionRegistrar::$pivotRole], 'role_has_permissions_permission_id_role_id_primary');
        });

        app('cache')
            ->store(config('permission.cache.store') != 'default' ? config('permission.cache.store') : null)
            ->forget(config('permission.cache.key'));

        /* ---------------------------- 
        /*   R O L E S  Y  P E R M I S O S 
        /* -----------------------------*/


        $admin = Role::create(['name' => 'Administrador']);
        $dev = Role::create(['name' => 'Developer']);
        $empleado = Role::create(['name' => 'Empleado']);
        $role3 = Role::create(['name' => 'Cliente']);

        /* Products permission */
        Permission::create(['name' => 'dashboard']);

        /* User permission */
        Permission::create(['name' => 'destroy_users']);
        Permission::create(['name' => 'create_users']);
        Permission::create(['name' => 'update_users']);
        Permission::create(['name' => 'details_users']);
        Permission::create(['name' => 'sidebar_users']);

        /* Products permission */
        Permission::create(['name' => 'destroy_products']);
        Permission::create(['name' => 'create_products']);
        Permission::create(['name' => 'update_products']);
        Permission::create(['name' => 'details_products']);
        Permission::create(['name' => 'sidebar_products']);

        /* Inventory permission */
        Permission::create(['name' => 'sidebar_inventory']);

        /* Category permission */
        Permission::create(['name' => 'destroy_category']);
        Permission::create(['name' => 'create_category']);
        Permission::create(['name' => 'update_category']);
        Permission::create(['name' => 'details_category']);
        Permission::create(['name' => 'sidebar_category']);

        /* Providers permission */
        Permission::create(['name' => 'destroy_provider']);
        Permission::create(['name' => 'create_provider']);
        Permission::create(['name' => 'update_provider']);
        Permission::create(['name' => 'details_provider']);
        Permission::create(['name' => 'sidebar_provider']);
    
        /* Purchase permission */
        Permission::create(['name' => 'destroy_purchase']);
        Permission::create(['name' => 'create_purchase']);
        Permission::create(['name' => 'update_purchase']);
        Permission::create(['name' => 'details_purchase']);
        Permission::create(['name' => 'sidebar_purchase']);

        /* Sales permission */
        Permission::create(['name' => 'details_sales']);
        Permission::create(['name' => 'sidebar_sales']);

        /* P O S */
        Permission::create(['name' => 'pos']);

        // Dev permission
        $dev->givePermissionTo([
            'dashboard',
            'pos',
            'destroy_products',
            'create_products',
            'update_products',
            'details_products',
            'sidebar_products',

            'destroy_category',
            'create_category',
            'update_category',
            'details_category',
            'sidebar_category',
            
            'destroy_provider',
            'create_provider',
            'update_provider',
            'details_provider',
            'sidebar_provider',
            
            'details_sales',
            'sidebar_sales',
            
            'destroy_purchase',
            'create_purchase',
            'update_purchase',
            'details_purchase',
            'sidebar_purchase',
            
            'destroy_users',
            'create_users',
            'update_users',
            'details_users',
            'sidebar_users',
        ]);

        // Products admin permission
        $admin->givePermissionTo([
            'dashboard',
            'pos',
            'destroy_products',
            'create_products',
            'update_products',
            'details_products',
            'sidebar_products',

            'destroy_category',
            'create_category',
            'update_category',
            'details_category',
            'sidebar_category',
            
            'destroy_provider',
            'create_provider',
            'update_provider',
            'details_provider',
            'sidebar_provider',
            
            'details_sales',
            'sidebar_sales',
            
            'destroy_purchase',
            'create_purchase',
            'update_purchase',
            'details_purchase',
            'sidebar_purchase',
            
            'destroy_users',
            'create_users',
            'update_users',
            'details_users',
            'sidebar_users',
        ]);

        // Products employee permission
        $empleado->givePermissionTo([
            'pos',
            'dashboard',
            'destroy_products',
            'create_products',
            'update_products',
            'details_products',
            'sidebar_products',

            'destroy_category',
            'create_category',
            'update_category',
            'details_category',
            'sidebar_category',
            
            'destroy_provider',
            'create_provider',
            'update_provider',
            'details_provider',
            'sidebar_provider',
            
            'details_sales',
            'sidebar_sales',
            
            'destroy_purchase',
            'create_purchase',
            'update_purchase',
            'details_purchase',
            'sidebar_purchase',
        ]);

        Permission::create(['name'=> 'controlDeCliente'])->syncRoles([$role3]);
    }

    public function down()
    {
        $tableNames = config('permission.table_names');

        if (empty($tableNames)) {
            throw new \Exception('Error: config/permission.php not found and defaults could not be merged. Please publish the package configuration before proceeding, or drop the tables manually.');
        }

        Schema::drop($tableNames['role_has_permissions']);
        Schema::drop($tableNames['model_has_roles']);
        Schema::drop($tableNames['model_has_permissions']);
        Schema::drop($tableNames['roles']);
        Schema::drop($tableNames['permissions']);
    }
}
