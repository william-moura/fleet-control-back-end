<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Permission::create(['name' => 'listar_motoristas', 'guard_name' => 'sanctum']);
        Permission::create(['name' => 'adicionar_motorista', 'guard_name' => 'sanctum']);
        Permission::create(['name' => 'editar_motorista', 'guard_name' => 'sanctum']);
        Permission::create(['name' => 'excluir_motorista', 'guard_name' => 'sanctum']);
        Permission::create(['name' => 'listar_veiculos', 'guard_name' => 'sanctum']);
        Permission::create(['name' => 'adicionar_veiculo', 'guard_name' => 'sanctum']);
        Permission::create(['name' => 'editar_veiculo', 'guard_name' => 'sanctum']);
        Permission::create(['name' => 'excluir_veiculo', 'guard_name' => 'sanctum']);
        Permission::create(['name' => 'listar_manutencoes', 'guard_name' => 'sanctum']);
        Permission::create(['name' => 'adicionar_manutencoes', 'guard_name' => 'sanctum']);
        Permission::create(['name' => 'editar_manutencoes', 'guard_name' => 'sanctum']);
        Permission::create(['name' => 'excluir_manutencoes', 'guard_name' => 'sanctum']);
        Permission::create(['name' => 'adicionar_servico_manutencoes', 'guard_name' => 'sanctum']);
        Permission::create(['name' => 'listar_servicos_manutencoes', 'guard_name' => 'sanctum']);
        Permission::create(['name' => 'listar_abastecimento', 'guard_name' => 'sanctum']);
        Permission::create(['name' => 'adicionar_abastecimento', 'guard_name' => 'sanctum']);
        Permission::create(['name' => 'editar_abastecimento', 'guard_name' => 'sanctum']);
        Permission::create(['name' => 'excluir_abastecimento', 'guard_name' => 'sanctum']);
        Permission::create(['name' => 'listar_fornecedores', 'guard_name' => 'sanctum']);
        Permission::create(['name' => 'adicionar_fornecedores', 'guard_name' => 'sanctum']);
        Permission::create(['name' => 'editar_fornecedores', 'guard_name' => 'sanctum']);
        Permission::create(['name' => 'excluir_fornecedores', 'guard_name' => 'sanctum']);
        Permission::create(['name' => 'acessar_relatorios', 'guard_name' => 'sanctum']);
        Permission::create(['name' => 'acessar_dashboards', 'guard_name' => 'sanctum']);
        Permission::create(['name' => 'listar_usuarios', 'guard_name' => 'sanctum']);
        Permission::create(['name' => 'adicionar_usuarios', 'guard_name' => 'sanctum']);
        Permission::create(['name' => 'editar_usuarios', 'guard_name' => 'sanctum']);
        Permission::create(['name' => 'excluir_usuarios', 'guard_name' => 'sanctum']);
        Permission::create(['name' => 'listar_multas_veiculos', 'guard_name' => 'sanctum']);
        Permission::create(['name' => 'adicionar_multas_veiculos', 'guard_name' => 'sanctum']);
        Permission::create(['name' => 'editar_multas_veiculos', 'guard_name' => 'sanctum']);
        Permission::create(['name' => 'excluir_multas_veiculos', 'guard_name' => 'sanctum']);
        Permission::create(['name' => 'adicionar_quilometragem', 'guard_name' => 'sanctum']);
        Permission::create(['name' => 'listar_quilometragem', 'guard_name' => 'sanctum']);
        Permission::create(['name' => 'excluir_quilometragem', 'guard_name' => 'sanctum']);
        Permission::create(['name' => 'editar_quilometragem', 'guard_name' => 'sanctum']);
        
        $permissions = Permission::all();
        Role::create(['name' => 'administrador', 'guard_name' => 'sanctum'])->givePermissionTo($permissions);

    }
}
