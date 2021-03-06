<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class CreateUsers extends AbstractMigration
{
    /**
     * Change Method.
     *
     * More information on this method is available here:
     * https://book.cakephp.org/phinx/0/en/migrations.html#the-change-method
     * @return void
     */
    public function change()
    {
        $table = $this->table('users');
        $table->addColumn('username', 'string', [
            'limit' => 100,
        ]);
        $table->addColumn('avatar', 'string', [
            'limit' => 200,
            'default' => null,

        ]);
        $table->addColumn('token', 'string', [
            'limit' => 200,
            'default' => null,

        ]);
        $table->addColumn('password', 'string', [
            'limit' => 90,
        ]);
        $table->addColumn('email', 'string', [
            'limit' => 50,
        ]);
        $table->addColumn('address', 'string', [
            'limit' => 100,
        ]);
        $table->addColumn('phonenumber', 'integer', [
            'limit' => 10,
            'default' => null,
        ]);

        $table->addColumn('point_user', 'integer', [
            'default' => 0,
        ]);
        $table->addColumn('del_flag', 'boolean', [
            'default' => 0,
        ]);
        $table->addColumn('role_id', 'integer', [
            'limit' => 11,
            'default' => 0,
        ])->addForeignKey('role_id', 'roles', 'id');

        $table->addColumn('created_date', 'timestamp', [
            'default' => 'CURRENT_TIMESTAMP'
        ]);
        $table->addColumn('updated_date', 'timestamp', [
            'default' => 'CURRENT_TIMESTAMP'
        ]);
        $table->create();
    }
}
