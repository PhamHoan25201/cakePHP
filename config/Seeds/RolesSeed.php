<?php
declare(strict_types=1);

use Migrations\AbstractSeed;

/**
 * Roles seed.
 */
class RolesSeed extends AbstractSeed
{
    /**
     * Run Method.
     *
     * Write your database seeder using this method.
     *
     * More information on writing seeds is available here:
     * https://book.cakephp.org/phinx/0/en/seeding.html
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();
            $data[] = [
                'role_name'      => 'NormalUser',
                'created_date'       => date('Y-m-d H:i:s'),
                'updated_date'       => date('Y-m-d H:i:s'),
            ];

        $this->insert('roles', $data);
    }
}
