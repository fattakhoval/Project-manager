<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Role;
use App\Models\Permission;


class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = Role::firstOrCreate(['name' => 'Админ']);
        $manager = Role::firstOrCreate(['name' => 'Руководитель проекта']);
        $executor = Role::firstOrCreate(['name' => 'Исполнитель']);

		// для Админа
        $manageUsersPermission = Permission::firstOrCreate(['name' => 'manage users']); // Управление пользователями
        $manageProjectsPermission = Permission::firstOrCreate(['name' => 'manage projects']); //Управление проектами
        $manageViewReports = Permission::firstOrCreate(['name' => 'view reports']); //Просмотр отчетов
        $exportReportsPermission = Permission::firstOrCreate(['name' => 'export reports']); //Экспорт отчетов
        $manageRolesPermission = Permission::firstOrCreate(['name' => 'manage roles']); // Управление ролями и правами доступа

        // для Рук. Проекта
        $createProjectsPermission = Permission::firstOrCreate(['name' => 'create projects']); // Создание проектов
        $manageOwnProjectsPermission = Permission::firstOrCreate(['name' => 'manage own projects']); // Управ. своими проектами
        $assignTasksPermission = Permission::firstOrCreate(['name' => 'assign tasks']); // Назначение задач пользователям
        $viewProjectStatusPermission = Permission::firstOrCreate(['name' => 'view project status']); // Просмотр состояния проектов и задач
        $viewProjectReportsPermission = Permission::firstOrCreate(['name' => 'view project reports']); //Просмотр отчетов по проекту
        $exportProjectReportsPermission = Permission::firstOrCreate(['name' => 'export project reports']); // просмотр отчетов по проекту

        // для Исполнителя
        $viewAssignedTasksPermission = Permission::firstOrCreate(['name' => 'view assigned tasks']); // просмот назначенных задач
        $compliteTasksPermission = Permission::firstOrCreate(['name' => 'complete tasks']); // Отметка о выполенении задач
        $addCommentsPermission = Permission::firstOrCreate(['name' => 'add task comments']); // Добавление комментариев к задачам

        $admin->givePermissionTo([$manageUsersPermission, $manageProjectsPermission, $manageViewReports, $exportReportsPermission, $manageRolesPermission]);
        $manager->givePermissionTo([$createProjectsPermission, $manageOwnProjectsPermission, $assignTasksPermission, $viewProjectStatusPermission, $viewProjectReportsPermission, $exportProjectReportsPermission]);
        $executor->givePermissionTo([$viewAssignedTasksPermission, $compliteTasksPermission, $addCommentsPermission]);
    }
}
