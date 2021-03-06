<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class CreateCategories extends AbstractMigration
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
        $table = $this->table('categories');
        $table->addColumn('category_name', 'string', [
            'limit' => 70,
        ]);
        $table->addColumn('del_flag', 'boolean', [
            'default' => 0,
        ]);
        $table->addColumn('created_date', 'timestamp', [
            'default' => 'CURRENT_TIMESTAMP'
        ]);
        $table->addColumn('updated_date', 'timestamp', [
            'default' => 'CURRENT_TIMESTAMP'
        ]);
        $table->create();
    }
}
